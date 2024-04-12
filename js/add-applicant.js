$(document).ready(function (e) {
    let applyNow = templateHandler.findGetParameter("apply");

    if (applyNow == 1) {
        $("html, body").animate(
            {
                scrollTop: formOffset,
            },
            2000
        );
    }

    $(document)
        .off("click", "#saveApplicant")
        .on("click", "#saveApplicant", function (e) {
            e.preventDefault();

            let documentUpload = true;

            let isUploadRequired = $(".formText").filter(function () {
                return $(this).text() === "Welches Dokument möchten Sie hochladen?*";
            }).length;

            if ($("#scope_list_all_documents_wrapper").length && isUploadRequired) {
                if ($("#scope_list_all_documents_wrapper").children().length == 0) {
                    documentUpload = confirm(
                        "Wollen Sie die Bewerbung ohne ein hochgeladenes Dokument abschicken?"
                    );
                }
            }

            if (documentUpload) {
                const applicant = serialize($('#job-form-wrapper')[0])

                // dataLayerPusher
                const storedHeyData = localStorage.getItem("heyData");
                const heyData = storedHeyData ? JSON.parse(storedHeyData) : {};

                const dataLayer = {
                    hey_source: getUTMParameterByName('utm_source'),
                    hey_medium: getUTMParameterByName('utm_medium'),
                    hey_campaign: getUTMParameterByName('utm_campaign'),
                    source: getUTMParameterByName('utm_source'),
                    medium: getUTMParameterByName('utm_medium'),
                    campaign: getUTMParameterByName('utm_campaign'),
                    vq_source: getUTMParameterByName('vq_source'),
                    vq_campaign: getUTMParameterByName('vq_campaign')
                };

                let dataLayerQueryString = new URLSearchParams(dataLayer).toString();
                let heyDataQueryString = new URLSearchParams(heyData).toString();

                //applicant["dataLayer"]['ga_client_id'] = getGAClientId();

                if(dataLayer.vq_source && dataLayer.vq_campaign) {
                    dataLayerQueryString += `hey_source=${dataLayer.vq_campaign + '/' + dataLayer.vq_source}`;
                }

                addApplicant(applicant + '&' + dataLayerQueryString + '&' + heyDataQueryString);
            }
        });
});

function getGAClientId() {
    let gaCookie = document.cookie.split('; ').find(row => row.startsWith('_ga='));
    if (gaCookie) {
        let clientId = gaCookie.split('=')[1];
        return clientId.substring(6);  // Ersten 6 Zeichen entfernen
    } else {
        return null;
    }
}

// Diese Funktion liest den jeweiligen UTM-Parameter aus der URL
function getUTMParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    let regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(window.location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

// convert camelcase to underscore
function keysToUnderscore(obj) {
    const deepMapKeys = (obj, mapFn) => {
        return Array.isArray(obj)
            ? obj.map((val) => deepMapKeys(val, mapFn))
            : typeof obj === "object"
                ? Object.keys(obj).reduce((acc, current) => {
                    const key = mapFn(current);
                    const val = obj[current];
                    acc[key] = val instanceof Object ? deepMapKeys(val, mapFn) : val;
                    return acc;
                }, {})
                : obj;
    };

    const camelToUnderscoreKey = (key) =>
        key
            .replace(/([A-Z][a-z]+)/g, (_, p1, offset) => {
                if (offset === 0) {
                    return p1.charAt(0).toLowerCase() + p1.slice(1);
                } else {
                    return "_" + p1.toLowerCase();
                }
            })
            .replace(/([a-z])([A-Z])/g, "$1_$2")
            .toLowerCase();

    return deepMapKeys(obj, camelToUnderscoreKey);
}

var applyErrorCount = 0;
function addApplicant(data, userDomainOnly = false) {
    let url = new URL(window.location.href);
    let domain = `${url.protocol}//${url.hostname}`;
    let desiredURL = !userDomainOnly ? url.origin + url.pathname : domain;

    grecaptcha.ready(function() {

        grecaptcha.execute('6Lc0GBgoAAAAAKFu__B4Hi73ScrRoUG2GqpvSTT1', {action: 'submit'}).then(function(token) {

            data += '&re_captcha=' + token;

            templateHandler.ajaxCall(desiredURL +  '/partials/apply.php', data, false, function (response) {

                if (response.status === 'success' && typeof response.data.applicant_job_id != 'undefined') {

                    applicationSentEventListener();
                    alert("Ihre Bewerbung war erfolgreich");

                    if(typeof response.data.redirect_url != 'undefined' && response.data.redirect_url !== '') {
                        window.location.href = response.data.redirect_url;
                    } else {
                        window.location.href = desiredURL + "/?page=danke&job=" + response.data.job_id + "&location=" + response.data.company_location_id ;
                    }
                }else{
                    applicationFailed();
                    if (response.detail === 'Validation error') {
                        handleErrors(response);
                    }else if(response.detail === 'Conflict'){
                        alert(response.errors);
                    }else if(response.detail === 'Not Found') {
                        alert('Stellenanzeige ist nicht mehr aktiv.');
                    }
                }

                if (typeof templateHandler != 'undefined' && typeof templateHandler.sendIframeHeight === 'function') {
                    templateHandler.sendIframeHeight();
                }
            }, function (){
                if(applyErrorCount < 1) {
                    applyErrorCount++;
                    addApplicant(data, true);
                }
            });
        });
    });

}

function serialize(element, fields = []) {
    for (const child of element.children) {
        let currentField = child;

        if (child.children.length && currentField.type !== 'select-multiple' && currentField.type !== 'select-one') {
            serialize(child, fields);
        } else {
            const isNamedField = currentField.name && currentField.value !== '';
            const isFieldEnabled = !currentField.disabled;
            const isFieldTypeValid = currentField.type !== 'button' && currentField.type !== 'file' && currentField.type !== 'reset' && currentField.type !== 'submit';

            if (isNamedField && isFieldEnabled && isFieldTypeValid) {
                if (currentField.type === 'select-multiple' || currentField.type === 'select-one') {
                    for (const option of child.options) {
                        if (option.selected) {
                            fields.push(encodeURIComponent(currentField.name) + "=" + encodeURIComponent(option.value));
                        }
                    }
                } else if (currentField.type !== 'checkbox' && currentField.type !== 'radio' || currentField.checked) {
                    fields.push(encodeURIComponent(currentField.name) + "=" + encodeURIComponent(currentField.value));
                }
            }
        }
    }

    return fields.join('&').replace(/%20/g, '+');
};


function handleErrors(response) {
    $(".error").remove();

    let data = response;
    let $lastErrorElement = null;

    if(data.status === "error") {
        for (let field in data.errors) {

            let inputField = $(
                "*[name='data[Applicant][" + field + "]'], " +
                "*[name='data[ApplicantJob][" + field + "]'], " +
                "*[name^='data[Question][" + field + "]'], " +
                "*[name^='data[ApplicantDocument][" + field + "]']," +
                "*[name^='" + field + "']"
            );

            if(inputField.length) {
                $lastErrorElement = inputField.parent().parent();
                $lastErrorElement.append(
                    $('<span class="error">' + data.errors[field] + '</span>').fadeIn('slow')
                );
            }
        }
    }

    if ($lastErrorElement) {
        $([document.documentElement, document.body]).animate(
            {
                    scrollTop: $lastErrorElement.offset().top - 100,
        }, 1000
    );
        }

    templateHandler.sendIframeHeight();
}

function resetLabelNumbers() {
    $("#scope_list_all_documents_wrapper label").each(function (key, index) {
        let oldNumberLength = $(index)
            .text()
            .substr(0, $(index).text().indexOf(".")).length;

        $(index).text(
            key + 1 + $(index).text().substr(oldNumberLength, $(index).text().length)
        );
    });
}