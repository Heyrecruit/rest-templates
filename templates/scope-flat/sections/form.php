<?php
    /** @var array $vars */
    /** @var array $jobSection */

    $jobId      = HeyUtility::getJobId($_GET);
    $locationId = HeyUtility::getLocationId($_GET);

    $language   = $vars['language'];
    $activeCompanyLocationJobs = $vars['job']['active_company_location_jobs'];

    $locationText              = $language !== 'de' ? 'Select location' : 'Standort wählen';
    $locationLabel              = $language !== 'de' ? 'This job advertisement is advertised at several locations' : 'Diese Stellenanzeige ist an mehreren Standorten ausgeschrieben';
    $applyText                 = $language !== 'de' ? 'Apply now' : 'Bewerbung abschicken';

    $applyOnMultiLocationsEnabled = $vars['job']['form_settings']['apply_on_multi_locations'] ?? false;

    $ariaLabelFormMain = $language != 'de' ? 'Application form' : 'Bewerbungsformular';
    $ariaLabelFormData = $language != 'de' ? 'Application form input data' : 'Bewerbungsformular Eingabe Daten';

    $applicationFormTitle   = $language !== 'de' ? 'Application form' : 'Bewerbungsformular';
    $applicationFormHint    = $language !== 'de' ? 'All fields marked with * are required.' : 'Alle mit * markierten Felder sind Pflichtfelder.';

?>
    <section id="section<?=$jobSection['id']?>" class="jp-section-form" aria-label="<?=$ariaLabelFormMain?>">
    <div class="container">
    <div class="row">
        <?php
        require(CURRENT_SECTION_PATH . "vacancy_offline.php");
        ?>


        <div class="col-12 col-md-9">
            <div id="job-form-wrapper" class="grey-container">

                <?php
                    if(!$vars['job']['company_location_jobs'][0]['active'] && (empty($_GET['preview']))) {
                       echo '<div class="disabledCont"></div>';
                    }

                    if(count($activeCompanyLocationJobs) > 1) {
                ?>
                        <h2 class="primary-color mb-4"><?=$locationText?></h2>
                        <div class="hey-form-row mb-5 ">
                            <div class="row">
                                <div class="col-12 col-sm-6 col-md-5 col-lg-4 mr-auto">
                                    <span class="formText"><?=$locationLabel?></span>
                                </div>
                                <div class="col-12 col-sm-6 col-md-7">
                                    <div class="customSelect">
                                        <select class="form-control" name="standort" id="scope-location-select">
                                            <?php
                                            foreach ($vars['job']['active_company_location_jobs'] as $k => $v) {
                                                $formattedLocation = HeyUtility::getFormattedAddress($v);

                                                if ($locationId == $v['company_location_id']) {
                                                    echo '<option value="' . $v['company_location_id'] . '" selected>' . HeyUtility::h($formattedLocation) . '</option>';
                                                } else {
                                                    echo '<option value="' . $v['company_location_id'] . '">' . HeyUtility::h($formattedLocation) . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php
                    }

	                foreach ($jobSection['job_section_elements'] as $key => $value) {
                        
                        if ($value['element_type'] !== 'form' && file_exists( CURRENT_ELEMENT_PATH . $value['element_type'] . '.php')) {
                            $jobSectionElement = $value;
                            ob_start();
                            include CURRENT_ELEMENT_PATH . $value['element_type'] . '.php';
                            echo ob_get_clean();
                        } elseif ($value['element_type'] === 'form') {
                            
                            $form = json_decode($value['job_section_element_strings'][0]['text'], true);

                            include ROOT . 'elements/whatsapp_apply_btn.php';

                ?>

                    <div class="form-main" role="form" aria-label="<?=$applicationFormTitle?>" aria-describedby="form-hint">
                        <small id="form-hint" class="mt-4 mb-n3 d-block text-gray">
                            <?=$applicationFormHint?>
                        </small>
                        <input type="hidden" name="job_id" value="<?= $jobId ?>" id="JobId">
                        <input type="hidden" name="company_location_id" value="<?= $locationId ?>" id="scope_company_location_id">
                        <input type="hidden" name="company_id" value="<?=$vars['company']['id']?>" id="scope_company_id">
                <?php

                        if (!empty($form)) {
                            
                            foreach ($form as $k => $v) {
                                
                                $questionCategoryTitle = HeyUtility::getQuestionStringBasedOnLanguage(
                                    $v['question_category_strings'],
                                    $vars['company']['language_id'],
                                    'title'
                                );
                                $questionCategorySubtitle = HeyUtility::getQuestionStringBasedOnLanguage(
	                                $v['question_category_strings'],
	                                $vars['company']['language_id'],
	                                'subtitle'
                                );
               ?>


                                <?php if (!empty($v['questions'])) { ?>
                                    <h3 class="primary-color"><?=HeyUtility::h($questionCategoryTitle)?></h3>
                                <?php } ?>



                                <?php
                                    echo $questionCategorySubtitle != '' ?
                                        '<p class="sub-headline">' . HeyUtility::h($questionCategorySubtitle) . '</p>'
                                        : '';
                                    
                                    foreach ($v['questions'] as $a => $b) {
    
                                        $path = file_exists(CURRENT_ELEMENT_PATH . 'form' . DS . $b['form_type'] . '.php')
                                            ? CURRENT_ELEMENT_PATH . 'form' . DS . $b['form_type'] . '.php'
                                            : ELEMENT_PATH_ROOT . 'form' . DS . $b['form_type'] . '.php';
    
                                        if (file_exists($path)) {
                                            
                                            $answer = '';
                                            
                                            $fieldValue = HeyUtility::getQuestionStringBasedOnLanguage(
	                                            $b['question_strings'],
	                                            $vars['company']['language_id'],
	                                            'value'
                                            );
                                            $fieldName = HeyUtility::h($b['field_name']);
                                            
                                            $placeholder = HeyUtility::getQuestionStringBasedOnLanguage(
	                                            $b['question_strings'],
	                                            $vars['company']['language_id'],
	                                            'placeholder'
                                            );
                                            $uniqueFieldId = uniqid();
                                            $required = $b['required'] ? '*' : '';
                                            $requiredField = $b['required'] ? 'required' : '';
                                            $questionId = $b['id'];
                                            $modalValue = HeyUtility::getQuestionStringBasedOnLanguage(
	                                            $b['question_strings'],
	                                            $vars['company']['language_id'],
	                                            'modal_value'
                                            );
                                ?>
                                            <div class="hey-form-row <?= $b['form_type'] == 'document' ? "upload-row" : "" ?>">
                                                <div class="row">
                                                <?php
                                                    $title = HeyUtility::getQuestionStringBasedOnLanguage(
                                                        $b['question_strings'],
                                                        $vars['company']['language_id'],
                                                        'title'
                                                    );
                                                ?>
                                                    <div class="col-12 col-sm-6 col-md-5">
                                                        <label class="formText mb-1" for="<?=$uniqueFieldId?>">
                                                            <?= HeyUtility::h($title) . $required ?>
                                                        </label>
                                                    </div>

                                                    <div class="col-12 col-sm-6 col-md-7">
                                                        <?php
                                                            ob_start();
                                                            include $path;
                                                            echo ob_get_clean();
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>

                                        <?php
                                            if ($b['form_type'] == 'document') {
                                        ?>
                                                <div id="scope_upload_all_documents_wrapper_<?= $b['id'] ?>"
                                                     style="display:none" class="uploadOuterWrapper">
                                                    <div class="scope_upload_error scope_upload_error_<?= $b['id'] ?>"></div>
                                                    <form method="post" id="scope_dropzone_<?= $b['id'] ?>" class="dropzone"></form>
                                                </div>
                                                <div id="scope_list_all_documents_wrapper_<?= $b['id'] ?>"
                                                     class="documentOuterWrapper">
                                                </div>
               <?php
                                                echo '<div class="multi-locations">';
                                                include ROOT . 'elements/form/multi_location_apply_select.php';
                                                echo '</div>';
                                            }
                                        }
                                    }
                                }
                            }
                       
                            $applyText = $vars['language'] != 'de' ? 'Apply now' : 'Bewerbung abschicken';
              ?>
                <div class="row justify-content-end">
                    <div class="col-12 col-sm-6 col-md-7">
                        <input class="btn btn-primary showApplicantSuccess primary-bg white-bg-hover primary-color-hover px-3"
                               style="border: 0"
                               id="saveApplicant" type="submit"
                               value="<?= $applyText ?>">
                    </div>
                </div>
              <?php
                    }
                }
              ?>
            </div>
            </div>
        </div>
    </div>
    </div>
</section>

<?php

