Dropzone.autoDiscover = false;

$(document).ready(function () {


    // Set JWT token for rest api calls
    if ($('#scope_upload_url').length && $('#scope_upload_url').val().indexOf("restApplicants") !== -1 && $('#scope_jwt').length) {
        var jwt = $('#scope_jwt').val();
        Dropzone.prototype.submitRequest = function (xhr, formData, files) {
            xhr.setRequestHeader('Authorization', 'Bearer ' + jwt);
            return xhr.send(formData);
        };
    }

    var docType = '';
    var postUrl = $('#scope_post_url').val();
    var uploadUrl = $('#scope_upload_url').val();
    var CSRF = $('#scope_csrf').val();
    var companyLocationId = $("#scope_company_location_id").val();
    var applicantId = $("#scope_applicant_id").val();

    var hiddenFields = {
        post_url: postUrl,
        csrf: CSRF
    };
    var applicantJob = {
        company_location_id: companyLocationId
    };
    var applicant = {
        id: applicantId
    };
    var params = JSON.stringify({
        HiddenField: hiddenFields,
        ApplicantJob: applicantJob,
        Applicant: applicant
    });

    $(".dropzone").dropzone({
        dictDefaultMessage: "Dokument reinziehen oder hier klicken",
        dictInvalidFileType: "Dieses Dateiformat wird nicht unterstützt.",
        dictFileTooBig: "Die Datei ist zu groß.",
        dictMaxFilesExceeded: "Es sind maximal 20 Dateien erlaubt.",
        dictRemoveFile: "löschen",
        url: uploadUrl,
        multiple: false,
        params: {params},
        dictFallbackMessage: "Bitte aktualisieren Sie Ihre Browser Version.",
        dictFallbackText: "Neuere Browser schützen besser vor Viren, Betrug, Datendiebstahl und anderen Bedrohungen Ihrer Privatsphäre und Sicherheit. Aktuelle Browser schließen Sicherheitslücken, durch die Angreifer in Ihren Computer gelangen können.",
        clickable: true,
        method: "post",
        maxFiles: 1,

        init: function () {

            this.on("addedfile", function () {
                if (this.files[1] != null) {
                    this.removeFile(this.files[0]);
                }
            });
            this.on("processing", function (file) {
                if ($("#scope_document_type").val() !== "") {
                    docType = $("#scope_document_type").val();
                    this.options.url = uploadUrl + '/' + docType;
                }
            });
        },

        accept: function (file, done) {
            if ($("#scope_document_type").val() == "") {
                alert('Bitte sagen Sie uns welches Dokument Sie hochladen wollen.');
                this.removeFile(file);
                $('.dz-preview').remove();
            } else {
                done();
            }
        },

        success: function (file, response) {

            $("#scope_document_type").prop("selected", false);
            $("#scope_document_type option:eq(0)").prop("selected", true);

            var docTypeLabel = '';
            var documentsCount = $('#scope_list_all_documents_wrapper .row').length + 1;

            switch (docType) {
                case 'picture':
                    docTypeLabel = 'Bewerbungsfoto';
                    break;
                case 'covering_letter':
                    docTypeLabel = 'Anschreiben';
                    break;
                case 'cv':
                    docTypeLabel = 'Lebenslauf';
                    break;
                case 'certificate':
                    docTypeLabel = 'Zeugnis / Bescheinigung';
                    break;
                case 'other':
                    docTypeLabel = 'Sonstiges';
                    break;
            }

            $("#scope_list_all_documents_wrapper").append(
                '<div class="row">' +
                '<div class="col-12">' +
                '<label for="document" class="formText primary-color">' +
                documentsCount + '. ' + docTypeLabel +
                '</label>' +
                '</div>' +
                '<div class="col-12">' +
                '<div class="formInput">' +
                '<i class="fas fa-file-upload primary-color ' + docType + ' mr-1" data-file-name="' + response.data.name + '" data-size="' + response.data.size + '" data-doc-type="' + docTypeLabel + '"></i>' +
                '<span>' +
                response.data.name +
                '</span>' +
                '</div>' +
                '<div class="documentDelete deleteFile" data-company-location-job-id="' + response.data.company_location_job_id + '" data-doc-type="' + docType + '" data-file-name="' + response.data.name + '" data-applicant-id="' + response.data.applicant_id + '" >' +
                '<i class="fa fa-trash mr-1 primary-color-hover" aria-hidden="true"></i>' +
                /*'Dokument löschen' +*/
                '</div>' +
                '</div>' +
                '</div>'
            );

            $("label[for='DocumentDocumentType']").text("Weiteres Dokument hochladen?");

            $('#scope_upload_all_documents_wrapper .dz-preview').remove();
            $('#scope_upload_all_documents_wrapper').hide();

            $('#scope_content_iframe_container').trigger('iframeHeightChange'); // Trigger height change for iframe
        },

        error: function (file, response) {

            $('#scope_document_type:eq(0)').prop("selected", true);

            $('#scope_upload_all_documents_wrapper .dz-preview').remove();
            $('#scope_upload_all_documents_wrapper .dz-default').html('<span>Dokument reinziehen oder klicken</span>').show();

            var error = typeof response.error !== 'undefined' ? response.error.message : 'Beim Upload ist ein Fehler aufgetreten';

            if (typeof response != 'undefined') {

                $('.scope_upload_error').html(
                    '<div class="alert alert-danger alert-dismissible error" role="alert">' +
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                    '<span aria-hidden="true">&times;</span>' +
                    '</button>' +
                    error +
                    '</div>'
                );
            }
        },

        removedfile: function (file) {
        },

        acceptedFiles: "image/*,.pdf,.doc,.docx,.xls, xlsx"
    });
});


$(document).off('change', '#scope_document_type').on('change', '#scope_document_type', function () {

    if ($(this).val() != '') {

        $('#scope_upload_all_documents_wrapper').fadeIn();
        $('#scope_upload_all_documents_wrapper .dz-default').show();

        if ($('#scope_upload_all_documents_wrapper .dz-fallback').length) {
            $('#scope_upload_all_documents_wrapper .dz-fallback').hide();
            $('#scope_upload_all_documents_wrapper .dz-message span').text('Bitte aktualisieren Sie Ihre Browser Version.');
        }

        $("#scope_content_iframe_container").trigger('iframeHeightChange'); // Trigger height change for iframe
    }
});


$(document).off('click', '.deleteFile').on('click', '.deleteFile', function () {

    var hasConfirmed = confirm('Wollen Sie das Dokument wirklich löschen?');

    if (hasConfirmed) {

        var jwt = $('#scope_jwt').length ? $('#scope_jwt').val() : false;
        var header = {'Content-type': 'application/x-www-form-urlencoded'};

        if (jwt !== false) {
            header = {'Authorization': 'Bearer ' + jwt};
        }

        var fileName = $(this).attr('data-file-name');
        var documentType = $(this).attr('data-doc-type');
        var companyLocationId = $(this).attr('data-company-location-job-id');
        var deleteUrl = $('#scope_delete_url').val() + '/' + companyLocationId + '/' + documentType + '/' + fileName;

        resetLabelNumbers();
        var jThis = $(this);
        templateHandler.ajaxCall(deleteUrl, {}, false, function (response) {
            if (response.success) {
                jThis.closest('.row').fadeOut().remove();

                if (typeof sendIframeHeight != 'undefined' && typeof sendIframeHeight === 'function') {
                    sendIframeHeight();
                }
            }
        }, function (response) {

            if (response.error && typeof response.error.message !== 'undefined') {
                console.log(response.error.message);
            }
        }, header);

        resetLabelNumbers();
    }
});
