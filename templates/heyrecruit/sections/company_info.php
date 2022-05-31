<section id="jp-section-company-info">
    <div id="company-image" class="row">
       <div class="col-12">
          <?php
          foreach ($jobSection['JobSectionElement'] as $key => $value) {
             if ($value['element_type'] === 'image' && file_exists(__DIR__ . DS . '../elements' . DS . $value['element_type'] . '.php')) {
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
              foreach ($jobSection['JobSectionElement'] as $key => $value) {
                 if ($value['element_type'] === 'h2' && file_exists(__DIR__ . DS . '../elements' . DS . $value['element_type'] . '.php')) {
                    $jobSectionElement = $value;
                    ob_start();
                    include __DIR__ . DS . '../elements' . DS . $value['element_type'] . '.php';
                    echo ob_get_clean();
                 }
              }
              ?>
              <div id="company-numbers" class="flexbox-badges">
                 <?php
                 $employeeText = $language != 'de' ? 'employees' : 'Mitarbeiter';
                 $locationText = $language != 'de' ? 'locations' : 'Standorte';
                 $companyEmployeeNumberText = $companyEmployeeNumber;
                 if($companyEmployeeNumber == 'unter 25'){
                     $companyEmployeeNumberText = $language != 'de' ? 'under 25' : 'unter 25';
                 }
                 if($companyEmployeeNumber == 'über 100'){
                     $companyEmployeeNumberText = $language != 'de' ? 'more than 100' : 'über 100';
                 }
                 ?>
                 <span><i class="fal fa-user"></i><?= $companyEmployeeNumberText . " " . $employeeText ?></span> <span><i class="fal fa-map-marker-alt"></i><?= $company['Company']['location_count'] . " " . $locationText ?></span>
                 <?php if ($company['Company']['business_type'] !== '') { ?>
                    <span><i class="fal fa-industry"></i><?= $company['Company']['business_type'] ?></span>
                 <?php } ?>
              </div>
              <div class="social-links">
                 <?php
	                 foreach ($jobSection['JobSectionElement'] as $key => $value) {

	                    if (
		                    ($value['element_type'] === 'social_links' && file_exists(__DIR__ . DS . '../elements' . DS . $value['element_type'] . '.php')) ||
		                    ($value['element_type'] === 'text' && file_exists(__DIR__ . DS . '../elements' . DS . $value['element_type'] . '.php'))
	                    ) {
	                       $jobSectionElement = $value;
	                       ob_start();
	                       include __DIR__ . DS . '../elements' . DS . $value['element_type'] . '.php';
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
