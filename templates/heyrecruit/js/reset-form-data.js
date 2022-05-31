var formData = {};
$(document).ready(function () {

    var cookie = templateHandler.getCookie('scope_form_data');
    if (cookie !== null) {
        formData = JSON.parse(templateHandler.getCookie('scope_form_data'));
        setFormData(formData);
    }
});

$(document).on('change', 'input, select', function () {

    if (typeof $(this).attr('name') != 'undefined'){
        var value = $(this).val();

        if ($(this).is(":checkbox")) {
            value = $(this).is(":checked") ? 1 : 0;
        }

        if (!templateHandler.inArray($(this).attr('name'), ['data[ApplicantDocument][document_type]'])) {
            formData[$(this).attr('name')] = value;
        }

        templateHandler.setCookie('scope_form_data', JSON.stringify(formData), 1)
    }
});


function setFormData(data) {
    $.each(data, function (key, value) {
        if ($("[name='"+ key +"']").length){

            if ($("[name='" + key + "']").is(":checkbox") && key !== 'data[Applicant][consent_form_accepted]') {
                $("[name='" + key + "']").prop('checked', value);
            }else{
                $("[name='" + key + "']").val(value);
            }
        }
    });
}
