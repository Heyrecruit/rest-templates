<?php
    /** @var array $vars */
    /** @var array $jobSection */
?>
<section id="jp-section-form">



    <div class="row">
        <div class="col-12">


            <div id="job-form-wrapper" class="grey-container">

                <?php if(!$vars['job']['company_location_jobs'][0]['active'] && (empty($_GET['preview']))) {?>
                    <div class="disabledCont"></div>
                <?php }?>

                <?php
                 
	                $jobId      = HeyUtility::getJobId($_GET);
	                $locationId = HeyUtility::getLocationId($_GET);
                 
	                $language   = $vars['language'];
	
	                foreach ($jobSection['job_section_elements'] as $key => $value) {
                        
                        if ($value['element_type'] !== 'form' && file_exists( CURRENT_ELEMENT_PATH . $value['element_type'] . '.php')) {
                            $jobSectionElement = $value;
                            ob_start();
                            include CURRENT_ELEMENT_PATH . $value['element_type'] . '.php';
                            echo ob_get_clean();
                        } elseif ($value['element_type'] === 'form') {
                            
                            $form = json_decode($value['job_section_element_strings'][0]['text'], true);

                ?>
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
                                <h3><?=HeyUtility::h($questionCategoryTitle)?></h3>
                
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
                                            $questionId = $b['id'];
                                            $modalValue = HeyUtility::getQuestionStringBasedOnLanguage(
	                                            $b['question_strings'],
	                                            $vars['company']['language_id'],
	                                            'modal_value'
                                            );
                                ?>
                                            <div class="hey-form-row <?= $b['form_type'] == 'document' ? "upload-row" : "" ?>">
                                                <?php
                                                    $title = HeyUtility::getQuestionStringBasedOnLanguage(
                                                        $b['question_strings'],
                                                        $vars['company']['language_id'],
                                                        'title'
                                                    );
                                                    if ($title !== 'Einverständniserklärung') {
                                                ?>
                                                        <span class="formText"><?= HeyUtility::h($title) . $required ?></span>
                                                        <div>
                                                <?php
                                                    } else {
                                                ?>
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
                                                    <form method="post" id="scope_dropzone_<?= $b['id'] ?>" class="dropzone"></form>
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
                       
                            $applyText = $vars['language'] != 'de' ? 'Apply now' : 'Bewerbung abschicken';
              ?>
                            <button id="saveApplicant" type="submit" class="btn btn-primary">
                                <i class="fal fa-paper-plane"></i><?= $applyText ?>
                            </button>
              <?php
                    }
                }
              ?>
            </div>
        </div>
    </div>
</section>

<?php

