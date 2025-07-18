<?php
	/** @var array $jobSection */
	/** @var array $vars */
?>
<section id="jp-section-company-info" class="col-12">
    <div id="company-image" class="row">
       <div class="col-12">
          <?php
           
	          foreach ($jobSection['job_section_elements'] as $key => $value) {
                 if (
                     $value['element_type'] === 'image' &&
                     file_exists(__DIR__ . DS . '../elements' . DS . $value['element_type'] . '.php')
                 ) {
                    $companyInfoSection = true;
                    $jobSectionElement = $value;
                    ob_start();
                    include __DIR__ . DS . '../elements' . DS . $value['element_type'] . '.php';
                    echo ob_get_clean();
                    $companyInfoSection = false;
                 }
              }
          ?>
       </div>
    </div>
    <div id="company-info-wrapper" class="row">
        <div class="col-12">
           <div id="company-info-box">
              <?php
                  foreach ($jobSection['job_section_elements'] as $key => $value) {
                     if (
                         $value['element_type'] === 'h2' &&
                         file_exists(CURRENT_ELEMENT_PATH . $value['element_type'] . '.php')
                     ) {
                        $jobSectionElement = $value;
                        ob_start();
                        include CURRENT_ELEMENT_PATH . $value['element_type'] . '.php';
                        echo ob_get_clean();
                     }
                  }
              ?>
              <div id="company-numbers" class="flexbox-badges">
                 <?php
                     $employeeText = $vars['language'] != 'de' ? 'employees' : 'Mitarbeiter';
                     $locationText = $vars['language'] != 'de' ? 'locations' : 'Standorte';

                     $companyEmployeeNumberText = HeyUtility::getFormattedEmployeeNumber(
                         $vars['company']['employee_number'],
                         $vars['language']
                     );
                 ?>
                <?php
                    if (!empty($companyEmployeeNumberText)) {
                ?>
                    <span>
                        <i class="fal fa-user"></i><?= $companyEmployeeNumberText . " " . $employeeText ?>
                    </span>
                <?php
                    }
                ?>

                  <span>
                      <i class="fal fa-map-marker-alt"></i>
                      <?=$locationText?>: <?=$vars['company']['company_location_count']?>
                  </span>
                <?php
                    
                     if (!empty($vars['company']['industry'])) {
                         $industry =  $vars['company']['language_id'] === 1
                             ? $vars['company']['industry']['name_de']
                             :$vars['company']['industry']['name_en'];
                ?>
                        <span><i class="fal fa-industry"></i><?=HeyUtility::h($industry)?></span>
                <?php
                     }
                ?>
              </div>
              <div class="social-links" id="social-links">
                 <?php
	                 foreach ($jobSection['job_section_elements'] as $key => $value) {

	                    if (
		                    (
                                $value['element_type'] === 'social_links' &&
                                file_exists(CURRENT_ELEMENT_PATH . $value['element_type'] . '.php')
                            ) ||
		                    (
                                $value['element_type'] === 'text' &&
                                file_exists(CURRENT_ELEMENT_PATH . $value['element_type'] . '.php')
                            )
	                    ) {
	                       $jobSectionElement = $value;
	                       ob_start();
	                       include CURRENT_ELEMENT_PATH . $value['element_type'] . '.php';
	                       $element = ob_get_clean();

	                       echo $element;
	                    }
	                 }
                 ?>
              </div>
           </div>
        </div>
    </div>
</section>
