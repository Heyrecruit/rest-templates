<?php
    /** @var array $vars */
    /** @var array $jobSection */
	
	$jobId      = HeyUtility::getJobId($_GET);
	$locationId = HeyUtility::getLocationId($_GET);
	
	$language                  = $vars['language'];
    $activeCompanyLocationJobs = $vars['job']['active_company_location_jobs'];
    
	$locationText              = $language !== 'de' ? 'Select location' : 'Standort wählen';
	$applyText                 = $language !== 'de' ? 'Apply now' : 'Bewerbung abschicken';

	$applicationFormTitle                 = $language !== 'de' ? 'Application form' : 'Bewerbungsformular';
	$applicationFormHint                 = $language !== 'de' ? 'All fields marked with * are required.' : 'Alle mit * markierten Felder sind Pflichtfelder.';

	$applyOnMultiLocationsEnabled = $vars['job']['form_settings']['apply_on_multi_locations'] ?? false;
?>
<section id="jp-section-form" role="region" aria-label="Bewerbungsformular">
    <div class="row">
        <div class="col-12">
            <div id="job-form-wrapper" class="grey-container">
                <?php
                    if($vars['job']['company_id'] == 135 && $vars['job']['job_strings'][0]['department'] == 'Fahrer') {
                ?>
                        <!-- Talk n Jobs Integration CCG -->
                        <script>
                            document.addEventListener('DOMContentLoaded', () => {

                                function getQueryParams(url) {
                                    const params = new URL(url).searchParams;
                                    return {
                                        id: params.get('id'),
                                        location: params.get('location')
                                    };
                                }

                                const currentUrl = window.location.href;
                                const result = getQueryParams(currentUrl);

                                const id = result.id;
                                const location = result.location;

                                const tag = `<a class="btn btn-primary" href="https://app.talk-n-job.de/chat/2000734_${id}:${location}/ccg">Jetzt mit Sprachbewerbung bewerben</a>`;
                                const container = document.getElementById('talknjob');
                                if (container) {
                                    container.innerHTML = tag;
                                }
                            });
                        </script>
                        <style>
                            #jp-section-form #job-form-wrapper #talknjob {
                                text-align: center;
                                margin-bottom: 20px;
                            }
                            #jp-section-form #job-form-wrapper #talknjob>a {
                                margin: 0 auto 10px auto;
                                display: inline-block;
                                font-size: 1rem;
                                line-height: 45px;
                                text-align: center;
                            }
                        </style>
                        <div id="talknjob"></div>
                <?php
                    }

                    if(!$vars['job']['company_location_jobs'][0]['active'] && empty($_GET['preview'])) {
                        echo '<div class="disabledCont"></div>';
                    }

                    if(count($activeCompanyLocationJobs) > 1) {
                ?>
                        <h2 class="primary-color"><?=$locationText?></h2>
                        <div class="hey-form-row mb-5 ">
                            <div>
                                <div class="customSelect">
                                    <select class="form-control" name="standort" id="scope-location-select">
					                    <?php
						                    foreach ($activeCompanyLocationJobs as $k => $v) {
							                    $formattedLocation = HeyUtility::getFormattedAddress($v);

							                    if ($locationId == $v['company_location_id']) {
								                    echo '<option value="' . $v['company_location_id'] . '" selected>' . HeyUtility::h($formattedLocation) . '</option>';
							                    } else {
								                    echo '<option value="' . $v['company_location_id'] . '">' . HeyUtility::h($formattedLocation) . '</option>';
							                    }
						                    }
					                    ?>
                                    </select>
                                    <i class="far fa-angle-down"></i>
                                </div>
                            </div>
                        </div>
                <?php
                    }

	                foreach ($jobSection['job_section_elements'] as $key => $value) {

                        if ($value['element_type'] !== 'form' && file_exists( CURRENT_ELEMENT_PATH . $value['element_type'] . '.php')) {
                            $jobSectionElement = $value;
                            include CURRENT_ELEMENT_PATH . $value['element_type'] . '.php';
                        } elseif ($value['element_type'] === 'form') {

                            $form = json_decode($value['job_section_element_strings'][0]['text'], true);

                            if(!empty($form)) {
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

                                            if (!empty($v['questions'])) {
                                                echo "<h3>" . HeyUtility::h($questionCategoryTitle) . "</h3>";
                                            }

                                            echo $questionCategorySubtitle != '' ? '<p class="sub-headline">' . HeyUtility::h($questionCategorySubtitle) . '</p>' : '';

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
                                                    $required      = $b['required'] ? '*' : '';
                                                    $requiredField      = $b['required'] ? 'required' : '';
                                                    $questionId    = $b['id'];

                                                    $modalValue = HeyUtility::getQuestionStringBasedOnLanguage(
                                                        $b['question_strings'],
                                                        $vars['company']['language_id'],
                                                        'modal_value'
                                                    );

                                                    $title = HeyUtility::getQuestionStringBasedOnLanguage(
                                                        $b['question_strings'],
                                                        $vars['company']['language_id'],
                                                        'title'
                                                    );

                                                    $isDocument = ($b['form_type'] === 'document');
                                                    $isConsent  = ($title === 'Einverständniserklärung');
                                                    $rowClass   = $isDocument ? 'upload-row' : '';
                                                    $innerClassStart = $isConsent  ? '<div class="extra-margin">' : '';
                                                    $innerClassEnd = $isConsent  ? '</div>' : '';
                                    ?>
                                                    <div class="hey-form-row mb-3 <?= $rowClass ?>">

                                                        <?php
                                                            if (!$isConsent && !$isDocument) {
                                                        ?>
                                                            <label class="formText mb-1" for="<?=$uniqueFieldId?>">
                                                                <?= HeyUtility::h($title) . $required ?>
                                                            </label>
                                                        <?php
                                                            } elseif ($isDocument) {
                                                        ?>
                                                            <label class="formText mb-1" for="scope_document_type_<?=$questionId?>">
                                                                <?= HeyUtility::h($title) . $required ?>
                                                            </label>
                                                        <?php
                                                            }
                                                        ?>

                                                            <?php
                                                                echo $innerClassStart;
                                                                include $path;
                                                                echo $innerClassEnd;
                                                            ?>

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

	                                                    include ROOT . 'elements/form/multi_location_apply_select.php';
                                                    }
                                                }
                                            }
                                        }
                                    ?>
                                    <button id="saveApplicant" type="submit" class="btn btn-primary">
                                        <i class="fas fa-paper-plane"></i><?= $applyText ?>
                                    </button>
                                </div>
                <?php
			                }
                        }
                    }
                ?>
            </div>
        </div>
    </div>
</section>