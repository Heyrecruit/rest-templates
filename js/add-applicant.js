$(document).ready(function (e) {

    var applyNow = templateHandler.findGetParameter('apply');

    if (applyNow == 1) {
        $('html, body').animate({
            scrollTop: formOffset
        }, 2000);
    }

    $(document).off('click', '#saveApplicant').on('click', '#saveApplicant', function (e) {

        e.preventDefault();

        var documetsUpload = true;

        var isUploadRequired = $(".formText").filter(function () {
            return $(this).text() === "Welches Dokument möchten Sie hochladen?*";
        }).length;

        if ($('#scope_list_all_documents_wrapper').length && isUploadRequired) {

            if ($('#scope_list_all_documents_wrapper').children().length == 0) {
                documetsUpload = confirm("Wollen Sie die Bewerbung ohne ein hochgeladenes Dokument abschicken?");
            }
        }

        if (documetsUpload) {
            var applicant = getApplicationFormData();
            addApplicant(applicant);
        }
    });
});

function addApplicant(applicant) {

    if (typeof applicant.ApplicantJob['job_id'] != 'undefined' && typeof applicant.ApplicantJob['company_location_id']) {

        var cookies = templateHandler.getCookiesArray();

        if (typeof cookies['scope_analytics[current_page]'] !== 'undefined') {
            applicant['current_page'] = JSON.parse(cookies['scope_analytics[current_page]']);
        }

        if (typeof cookies['scope_analytics[referrer]'] !== 'undefined') {
            applicant['referrer'] = JSON.parse(cookies['scope_analytics[referrer]']);
        }

        var url = $('#scope_post_url').val();
        var jwt = $('#scope_jwt').length ? $('#scope_jwt').val() : false;
        var header = {'Content-type': 'application/x-www-form-urlencoded'};

        if (jwt !== false) {
            header = {'Authorization': 'Bearer ' + jwt};
        }

        templateHandler.ajaxCall(url, applicant, false, function (response) {
            if (response.success && typeof response.data.applicant_job_id != 'undefined') {

                alert("Ihre Bewerbung war erfolgreich");

               if (typeof response.data.redirect_url != 'undefined') {
                    if(response.data.redirect_url != null) {
                        window.location.href = response.data.redirect_url + '?applicant_job_id=' + response.data.applicant_job_id + '&success=1';
                    } else {
                        let w = window.location;
                        let url = w.protocol + "//" + w.host + "/?page=danke&job=" + response.data.job_id + "&location=" + response.data.company_location_id ;
                        window.location.href = url;
                    }

                } else {
                    var url = templateHandler.getBaseUrl() + 'app/jobs/preview/' + response.data.job_id + '?job=' + response.data.job_id + '&location=' + response.data.company_location_id + '&success=1';
                    window.location.href = url;
                }
            }
        }, function (response) {

            if (typeof response.error.message !== 'undefined') {
                alert(response.error.message);
            }

            if (typeof response.error.validation_message !== 'undefined' && !jQuery.isEmptyObject(response.error.validation_message)) {
                setInputErrorMsg(response.error.validation_message);
            }

            if (typeof templateHandler != 'undefined' && typeof templateHandler.sendIframeHeight === 'function') {
                templateHandler.sendIframeHeight();
            }


        }, header);

        // Trigger height change for iframe
        $("#scope_content_iframe_container").trigger('iframeHeightChange');
    }
}

function getApplicationFormData(parentElementId) {
    var applicant = {
        Applicant: {},
        ApplicantJob: {},
        QuestionAnswer: {},
        HiddenField: {}
    };
    parentElementId = typeof parentElementId != 'undefined' ? parentElementId : '';

    applicant.ApplicantJob['job_id'] = $(parentElementId + " input[name='data[Job][id]']").val();
    applicant.HiddenField['post_url'] = $(parentElementId + " #scope_post_url").val();
    applicant.HiddenField['csrf'] = $(parentElementId + " #scope_csrf").val();

    $(parentElementId + " input[name^='data[Applicant]'], " + parentElementId + " select[name^='data[Applicant]'], " + parentElementId + " textarea[name^='data[Question]']").each(function (index, element) {
        var name = $(element).attr('name');
        var firstIndex = templateHandler.secondIndexOf('[', name) + 1;
        var secoundIndex = name.lastIndexOf(']');

        var answer = $(element).val();

        if ($(element).attr('type') == 'checkbox') {
            answer = $(element).is(':checked') ? 1 : '';
        }
        applicant.Applicant[name.substring(firstIndex, secoundIndex)] = answer;

        if (typeof $(element).attr('data-question-id') != 'undefined') {
            applicant.QuestionAnswer[$(element).attr('data-question-id')] = {
                question_string: $(element).closest('.row').find('.formText').text(),
                question_id: $(element).attr('data-question-id'),
                answer: answer
            };
        }
    });

    $(parentElementId + " input[name^='data[ApplicantJob]'], " + parentElementId + " select[name^='data[ApplicantJob]'], " + parentElementId + " textarea[name^='data[Question]']").each(function (index, element) {
        var name = $(element).attr('name');
        var firstIndex = templateHandler.secondIndexOf('[', name) + 1;
        var secoundIndex = name.lastIndexOf(']');

        var answer = $(element).val();

        if ($(element).attr('type') == 'checkbox') {
            answer = $(element).is(':checked') ? 1 : '';
        }

        applicant.ApplicantJob[name.substring(firstIndex, secoundIndex)] = answer;

        if (typeof $(element).attr('data-question-id') != 'undefined') {
            applicant.QuestionAnswer[$(element).attr('data-question-id')] = {
                question_string: $(element).closest('.row').find('.formText').text(),
                question_id: $(element).attr('data-question-id'),
                answer: answer
            };
        }
    });

    $(parentElementId + " input[name^='data[Question]'], " + parentElementId + " select[name^='data[Question]'], " + parentElementId + " textarea[name^='data[Question]']").each(function (index, element) {
        var data = {
            question_string: $(element).closest('.row').find('.formText').text(),
            question_id: $(element).attr('data-question-id'),
            answer: ''
        };

        if (typeof applicant.QuestionAnswer[$(element).attr('data-question-id')] === 'undefined') {
            applicant.QuestionAnswer[$(element).attr('data-question-id')] = data;
        }

        if ($(element).attr('type') === 'checkbox') {
            var answer = $(element).is(':checked') ? $(element).closest('div').find('.label').text() : '';
            if (applicant.QuestionAnswer[$(element).attr('data-question-id')]['answer'] !== '') {
                applicant.QuestionAnswer[$(element).attr('data-question-id')]['answer'] += ';';
            }
            applicant.QuestionAnswer[$(element).attr('data-question-id')]['answer'] += answer;

        } else {
            applicant.QuestionAnswer[$(element).attr('data-question-id')].answer = $(element).val();
        }
    });

    return applicant;
}

function setInputErrorMsg(errors) {
    $('.error').remove();

    if (errors != null) {
        var $lastErrorElement = null;
        $.each(errors, function (index, value) {

            $("*[name='data[Applicant][" + index + "]'], *[name='data[ApplicantJob][" + index + "]'], *[name^='data[Question][" + index + "]']").parent().parent().append(
                $('<span class="error">' + value + '</span>').fadeIn('slow')
            );

            $lastErrorElement = $("*[name='data[Applicant][" + index + "]'], *[name='data[ApplicantJob][" + index + "]'], *[name^='data[Question][" + index + "]']").parent().parent();
        });

        if ($lastErrorElement != null) {
            $([document.documentElement, document.body]).animate({
                scrollTop: $lastErrorElement.offset().top - 100
            }, 1000);
        }

        templateHandler.sendIframeHeight();
    }
}

function resetLabelNumbers() {
    $('#scope_list_all_documents_wrapper label').each(function (key, index) {
        var oldNumberLength = $(index).text().substr(0, $(index).text().indexOf('.')).length;

        $(index).text(key + 1 + $(index).text().substr(oldNumberLength, $(index).text().length));

    });
}
