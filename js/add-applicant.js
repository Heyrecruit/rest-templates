var applyErrorCount = 0;

$(document).ready(function (e) {
    let applyNow = templateHandler.findGetParameter("apply");

    if (applyNow == 1) {
        $("html, body").animate({scrollTop: formOffset,}, 2000);
    }
});

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
            const applicant = serializeToObject($('#job-form-wrapper')[0])
            // dataLayerPusher
            const storedHeyData = localStorage.getItem("heyData");
            const heyData = storedHeyData ? JSON.parse(storedHeyData) : {};

            //const MID = document.body.getAttribute('data-ga4-measurement-id') || '';
            const sess = templateHandler.getCurrentGaSessionFields();
            const clientId = templateHandler.getClientIdFromGaCookie();
            const timestamp_micros = templateHandler.computeTimestampMicrosWithinSession(sess);

            const dataLayer = {
                utm_source:         getUTMParameterByName('utm_source'),
                utm_medium:         getUTMParameterByName('utm_medium'),
                utm_campaign:       getUTMParameterByName('utm_campaign'),
                vq_source:          getUTMParameterByName('vq_source'),
                vq_campaign:        getUTMParameterByName('vq_campaign'),
                client_id:          clientId,
                session_id:         sess?.session_id,
                session_number:     sess?.session_number,
                timestamp_micros:   timestamp_micros,
            };

            if (dataLayer.vq_source && dataLayer.vq_campaign) {
                dataLayer.hey_vonq_campaign = `${dataLayer.vq_campaign}/${dataLayer.vq_source}`;
            }

            const applicantData = {
                applicant: applicant,
                analytics: dataLayer,
                hey_data: heyData,
            };

            addApplicant(applicantData);

            $('#preloaderApply').css('display','flex');
        }
    });

// Diese Funktion liest den jeweiligen UTM-Parameter aus der URL
function getUTMParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    let regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(window.location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

function addApplicant(data, userDomainOnly = false) {
    let url = new URL(window.location.href);
    let domain = `${url.protocol}//${url.hostname}`;
    let desiredURL = !userDomainOnly ? url.origin + url.pathname : domain;

    grecaptcha.ready(function() {

        grecaptcha.execute('6Lc0GBgoAAAAAKFu__B4Hi73ScrRoUG2GqpvSTT1', {action: 'submit'}).then(function(token) {

            data.re_captcha = token;

            templateHandler.ajaxCall(desiredURL +  '/partials/apply.php', data, false, function (response) {
                applyErrorCount = 0;
                $('#preloaderApply').hide();
                if (response.status === 'success' && typeof response.data.applicant_job_id != 'undefined') {
                    applicationSentEventListener();
                    alert("Ihre Bewerbung war erfolgreich");

                    if(typeof response.data.redirect_url != 'undefined' && response.data.redirect_url !== '') {
                        window.location.href = response.data.redirect_url;
                    } else {
                        window.location.href = desiredURL + "?page=danke&job=" + response.data.job_id + "&location=" + response.data.company_location_id ;
                    }
                }else{
                    applicationFailed();
                    if (response.detail === 'Validation error') {
                        handleErrors(response);
                    }else if(response.detail === 'Conflict'){
                        alert(response.errors);
                    }else if(response.detail === 'Gone') {
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

function serializeToObject(root, opts = {}) {
    const {
        parseNumbers = true,
        parseBooleans = false,
        trim = true,
        includeDisabled = false,
        include = null,           // z.B. ['job_id','company_location_id']
        exclude = []              // z.B. ['company_id']
    } = opts;

    const fields = root.querySelectorAll('input, select, textarea');
    const data = Object.create(null);

    const shouldInclude = (name) =>
        (!include || include.includes(name)) && !exclude.includes(name);

    const coerce = (v) => {
        if (v == null) return v;
        let val = String(v);
        if (trim) val = val.trim();
        if (parseBooleans && /^(true|false)$/i.test(val)) return val.toLowerCase() === 'true';
        if (parseNumbers && /^-?\d+(\.\d+)?$/.test(val)) return Number(val);
        return val;
    };

    const add = (name, value, forceArray = false) => {
        if (!shouldInclude(name)) return;
        const v = coerce(value);
        if (name.endsWith('[]') || forceArray) {
            const base = name.endsWith('[]') ? name.slice(0, -2) : name;
            if (!Array.isArray(data[base])) data[base] = [];
            data[base].push(v);
            return;
        }
        if (name in data) {
            if (!Array.isArray(data[name])) data[name] = [data[name]];
            data[name].push(v);
        } else {
            data[name] = v;
        }
    };

    for (const field of fields) {
        const { name, type, disabled, tagName } = field;
        if (!name) continue;
        if (disabled && !includeDisabled) continue;

        const t = (type || '').toLowerCase();
        if (['button', 'file', 'reset', 'submit'].includes(t)) continue;

        // SELECTs
        if (tagName === 'SELECT') {
            if (field.multiple) {
                const selected = Array.from(field.selectedOptions).map(o => o.value);
                // Für multi immer Array (auch bei 1 Wert)
                add(name, selected, true); // forceArray=true
            } else {
                if (field.value !== '') add(name, field.value);
            }
            continue;
        }

        // Checkbox/Radio nur wenn checked
        if ((t === 'checkbox' || t === 'radio')) {
            if (field.checked) add(name, field.value);
            continue;
        }

        // Standard input/textarea
        if (field.value !== '') add(name, field.value);
    }

    return data;
}


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
                $lastErrorElement = inputField.parent();
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