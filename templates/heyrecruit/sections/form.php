<section id="jp-section-form">
    <div class="row">
        <div class="col-12">
            <div id="job-form-wrapper" class="grey-container">
                <?php
                foreach ($jobSection['JobSectionElement'] as $key => $value) {

                    if ($value['element_type'] !== 'form' && file_exists(__DIR__ . DS . '../elements' . DS . $value['element_type'] . '.php')) {

                        $jobSectionElement = $value;
                        ob_start();
                        include __DIR__ . DS . '../elements' . DS . $value['element_type'] . '.php';
                        echo ob_get_clean();
                    } elseif ($value['element_type'] === 'form') {

                        $form = json_decode($value['text'], true);

                        $postUrl = 'restApplicants/add/' . $jobId . '/' . $locationId;
                        $uploadUrl = 'restApplicants/uploadDocument/' . $applicantId;
                        $deleteUrl = 'restApplicants/deleteDocument/' . $applicantId;

                        ?>
                        <input type="hidden" name="data[Job][id]" value="<?= $jobId ?>" id="JobId">
                        <input type="hidden" name="data[Applicant][id]" value="<?= $applicantId ?>"
                               id="scope_applicant_id">
                        <input type="hidden" name="data[ApplicantJob][company_location_id]"
                               value="<?= $locationId ?>" id="scope_company_location_id">
                        <input type="hidden" name="data[Company][id]" value="<?= $company['Company']['id'] ?>"
                               id="scope_company_id">
                        <input type="hidden" name="data[HiddenField][post_url]"
                               value="<?= $job['Form']['post_url'] ?>" id="scope_post_url">
                        <input type="hidden" name="data[HiddenField][upload_url]"
                               value="<?= $job['Form']['upload_url'] ?>" id="scope_upload_url">
                        <input type="hidden" name="data[HiddenField][delete_url]"
                               value="<?= $job['Form']['delete_url'] ?>" id="scope_delete_url">
                        <input type="hidden" name="data[HiddenField][csrf]"
                               value="<?= $job['Form']['csrf_token'] ?>" id="scope_csrf">
                        <input type="hidden" name="data[HiddenField][jwt]" value="<?= $authData['token'] ?>"
                               id="scope_jwt">

                        <?php

                        if (!empty($form['QuestionCategory'])) {
                            foreach ($form['QuestionCategory'] as $k => $v) {


                                $questionCategoryTitle = getQuestionStringBasedOnLanguage($company['Languages']['ids'], $v['QuestionCategoryString'], 'title', $language);
                                $questionCategorySubtitle = getQuestionStringBasedOnLanguage($company['Languages']['ids'], $v['QuestionCategoryString'], 'subtitle', $language);
                                //$questionCategoryTitle = !empty($v['QuestionCategoryString']) ? $v['QuestionCategoryString'][0]['title'] : '';
                                ?>
                                <h3><?= $questionCategoryTitle ?></h3>
                                <?php
                                echo $questionCategorySubtitle != '' ? '<p class="sub-headline">' . $questionCategorySubtitle . '</p>' : '';
                                foreach ($v['Question'] as $a => $b) {

                                    $path = file_exists(ELEMENT_PATH . 'form' . DS . $b['form_type'] . '.php')
                                        ? ELEMENT_PATH . 'form' . DS . $b['form_type'] . '.php'
                                        : ELEMENT_PATH_ROOT . 'form' . DS . $b['form_type'] . '.php';

                                    if (file_exists($path)) {
                                        $answer = '';
                                        $fieldValue = getQuestionStringBasedOnLanguage($company['Languages']['ids'], $b['QuestionString'], 'value', $language);
                                        $fieldName = $b['field_name'];
                                        $placeholder = getQuestionStringBasedOnLanguage($company['Languages']['ids'], $b['QuestionString'], 'placeholder', $language);
                                        $uniqueFieldId = uniqid();
                                        $required = $b['required'] ? '*' : '';
                                        $questionId = $b['id'];
                                        $modalValue = getQuestionStringBasedOnLanguage($company['Languages']['ids'], $b['QuestionString'], 'modal_value', $language);
                                        ?>
                                        <div class="<?= $b['form_type'] == 'document' ? "upload-row" : "" ?>">
                                            <?php
                                            $title = getQuestionStringBasedOnLanguage($company['Languages']['ids'], $b['QuestionString'], 'title', $language);
                                            if ($title !== 'Einverständniserklärung') {
                                                ?>
                                                <span class="formText"><?= $title . $required ?></span>
                                                <div>
                                            <?php } else { ?>
                                            <div class="extra-margin">
                                                <?php
                                                }
                                                ob_start();
                                                include $path;
                                                echo ob_get_clean();
                                                ?>
                                            </div>
                                        </div>

                                        <?php
                                        if ($b['form_type'] == 'document') {
                                            ?>
                                            <div id="scope_upload_all_documents_wrapper_<?= $b['id'] ?>"
                                                 style="display:none" class="uploadOuterWrapper">
                                                <div class="scope_upload_error scope_upload_error_<?= $b['id'] ?>"></div>
                                                <form method="post" id="scope_dropzone_<?= $b['id'] ?>"
                                                      action="<?= $postUrl ?>" class="dropzone"></form>
                                            </div>
                                            <div id="scope_list_all_documents_wrapper_<?= $b['id'] ?>"
                                                 class="documentOuterWrapper">
                                            </div>
                                            <?php
                                        }
                                    }
                                }
                            }
                        }
                        ?>
                        <?php
                        $applyText = $language != 'de' ? 'Apply now' : 'Bewerbung abschicken';
                        ?>
                                            <button id="saveApplicant" type="submit" class="btn btn-primary">
                                                <i class="fal fa-paper-plane"></i><?= $applyText ?>
                                            </button>
                        <!--<input class="btn showApplicantSuccess btn-primary"
                               id="saveApplicant" type="submit" value="<?/*= $applyText */?>">-->
                        <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>
</section>

<?php
function getQuestionStringBasedOnLanguage($languageIds, $data, $key, $language)
{
    $string = '';
    if (!empty($data)) {
        if (isset($languageIds[strtolower($language)])) {

            foreach ($data as $k => $value) {


                if (isset($value[$key]) && $value['language_id'] == $languageIds[strtolower($language)]) {
                    $string = $value[$key];
                    break;
                } else {
                    $string = $value[$key];
                }
            }
        }
    }

    return $string;
}

