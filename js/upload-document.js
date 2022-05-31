Dropzone.autoDiscover = false;

function ApplicantDocumentUpload() {

    this.defaultFormPreId = 'scope_dropzone_';
    this.defaultListDocumentsPreId = 'scope_list_all_documents_wrapper_';

    this.applicantId = null;
    this.companyLocationId = null;
    this.questionId = null;
    this.postUrl = null;
    this.uploadUrl = null;
    this.CSRF = null;
    this.params = null
    this.dropZones = [];

    this.init = () => {
        var _this = this;

        $(document).ready(function () {

            // Set JWT token for rest api calls
            if ($('#scope_upload_url').length && $('#scope_upload_url').val().indexOf("restApplicants") !== -1 && $('#scope_jwt').length) {
                var jwt = $('#scope_jwt').val();
                Dropzone.prototype.submitRequest = function (xhr, formData, files) {
                    xhr.setRequestHeader('Authorization', 'Bearer ' + jwt);
                    return xhr.send(formData);
                };
            }

            _this.postUrl = $('#scope_post_url').val();
            _this.uploadUrl = $('#scope_upload_url').val();
            _this.CSRF = $('#scope_csrf').val();
            _this.companyLocationId = $("#scope_company_location_id").val();
            _this.applicantId = $("#scope_applicant_id").val();

            var hiddenFields = {
                post_url: _this.postUrl,
                csrf: _this.CSRF
            };

            var applicantJob = {
                company_location_id: _this.companyLocationId
            };

            var applicant = {
                id: _this.applicantId
            };

            _this.params = JSON.stringify({
                HiddenField: hiddenFields,
                ApplicantJob: applicantJob,
                Applicant: applicant
            });
        });

        this.setEventHandler();
    };

    this.setEventHandler = () => {
        var _this = this;

        $(document).off('change', '.scope_document_type').on('change', '.scope_document_type', function () {
            _this.questionId = $(this).attr('data-question-id');

            if ($(this).val() !== '') {

                _this.initDropzone(_this.questionId, $(this).val());

                $('#scope_upload_all_documents_wrapper_' + _this.questionId).fadeIn();
                $('#scope_upload_all_documents_wrapper_' + _this.questionId + ' .dz-default').show();

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
                var questionId = $(this).attr('data-question-id');
                var deleteUrl = $('#scope_delete_url').val() + '/' + companyLocationId + '/' + documentType + '/' + questionId + '/' + fileName;

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
    }

    this.initDropzone = (questionId, documentType) => {
        var _this = this;

        if ($('#' + _this.defaultFormPreId + questionId).length) {

            if (typeof _this.dropZones[_this.questionId] !== 'undefined') {
                _this.dropZones[_this.questionId].destroy();
                delete _this.dropZones[_this.questionId];
            }

            if (typeof documentType !== 'undefined' && documentType !== '') {

                var language =  $('#scope_document_type_' + questionId).attr('data-language');

                _this.dropZones[questionId] = new Dropzone('#' + _this.defaultFormPreId + questionId, {
                    dictDefaultMessage: language === 'de' ? "Dokument reinziehen oder hier klicken" : 'Drag the document or click here',
                    dictInvalidFileType: "Dieses Dateiformat wird nicht unterstützt.",
                    dictFileTooBig: "Die Datei ist zu groß.",
                    dictMaxFilesExceeded: "Es sind maximal 20 Dateien erlaubt.",
                    dictRemoveFile: "löschen",
                    url: _this.uploadUrl + '/' + questionId + '/' + encodeURI(documentType),
                    multiple: false,
                    params: _this.params,
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
                    },

                    accept: function (file, done) {
                        done();
                    },
                    success: function (file, response) {

                        $("#scope_document_type_" + questionId).prop("selected", false);
                        $("#scope_document_type_" + questionId + " option:eq(0)").prop("selected", true);

                        var docTypeLabel = _this.getDocumentLabelFromValue(documentType);

                        $("#scope_list_all_documents_wrapper_" + questionId).append(
                            '<div class="row">' +
                            '<div class="col-12">' +
                            '<div class="formInput documentList">' +
                            '<label for="document" class="formText primary-color">' + docTypeLabel + '</label>' +
                            '<i class="fas fa-file-upload primary-color ' + documentType + ' mr-2" data-file-name="' + response.data.name + '" data-size="' + response.data.size + '" data-doc-type="' + docTypeLabel + '"></i>' +
                            '<span>' +
                            response.data.name +
                            '</span>' +
                            '<div class="documentDelete deleteFile" data-company-location-job-id="' + response.data.company_location_job_id + '" data-doc-type="' + documentType + '" data-file-name="' + response.data.name + '" data-applicant-id="' + response.data.applicant_id + '" data-question-id="' + questionId + '" >' +
                            '<i class="fa fa-trash mr-1 primary-color-hover" aria-hidden="true"></i>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '<input type="hidden" name="data[Question][' + questionId + '][has_uploaded]" value="1"' +
                            '</div>'
                        );

                        $("label[for='DocumentDocumentType']").text("Weiteres Dokument hochladen?");

                        $('#scope_upload_all_documents_wrapper_' + questionId + ' .dz-preview').remove();
                        $('#scope_upload_all_documents_wrapper_' + questionId).hide();

                        $('#scope_content_iframe_container').trigger('iframeHeightChange'); // Trigger height change for iframe
                    },

                    error: function (file, response) {

                        $('#scope_document_type_' + questionId + ':eq(0)').prop("selected", true);

                        $('#scope_upload_all_documents_wrapper_' + questionId + ' .dz-preview').remove();
                        $('#scope_upload_all_documents_wrapper_' + questionId + ' .dz-default').html('<span>Dokument reinziehen oder klicken</span>').show();

                        var error = typeof response.error !== 'undefined' ? response.error.message : 'Beim Upload ist ein Fehler aufgetreten';

                        if (typeof response != 'undefined') {

                            $('.scope_upload_error_' + questionId).html(
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

                    acceptedFiles: "image/*,.pdf,.doc,.docx,.xls,.xlsx,.ppt,.odt"
                });
            } else {
                alert('Bitte wählen Sie ein Dokument aus der Liste aus.');
            }
        }
    }

    this.getDocumentLabelFromValue = (docType) => {
        var docTypeLabel = docType;

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
        return docTypeLabel;
    }

    this.init();
}

if (typeof applicantDocumentUpload === 'undefined') {
    var applicantDocumentUpload = new ApplicantDocumentUpload();

} else {
    applicantDocumentUpload = new ApplicantDocumentUpload();
}
