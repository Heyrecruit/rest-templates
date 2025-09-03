<?php
	/** @var array $vars */
	/** @var array $jobSection */
	
    if ($vars['include_header_image']) {
?>
       <header>
          <?php
             
              foreach ($jobSection['job_section_elements'] as $key => $value) {
                 if (
                     $value['element_type'] === 'image' &&
                     file_exists(__DIR__ . DS . '../elements' . DS . $value['element_type'] . '.php')
                 ) {
                    $headerImage = true;
                    $jobSectionElement = $value;
                    ob_start();
                    include __DIR__ . DS . '../elements' . DS . $value['element_type'] . '.php';
                    echo ob_get_clean();
                    $headerImage = false;
                 }
              }
          ?>
   </header>
<?php
    } else {
        foreach ($jobSection['job_section_elements'] as $key => $value) {
            if (
                $value['element_type'] !== 'image' &&
                $value['element_type'] !== 'text' &&
                file_exists(__DIR__ . DS . '../elements' . DS . $value['element_type'] . '.php')
            ) {
                $jobSectionElement = $value;
                ob_start();
                include __DIR__ . DS . '../elements' . DS . $value['element_type'] . '.php';
                echo ob_get_clean();
            }
        }
?>
        <div class="flexbox-badges">
            <span>
                <i class="fal fa-map-marker-alt"></i>
                <?=HeyUtility::h($vars['formatted_job_location'])?>
            </span>
            <span>
                <i class="fal fa-clock"></i>
                <?= preg_replace(
                    '/(?<!\d),|,(?!\d{3})/',
                    ', ',
                    $vars['job']['job_strings'][0]['employment']
                ) ?>
            </span>
            
            <?php
                if ($vars['job']['job_strings'][0]['department']) {
            ?>
                    <span>
                        <i class="fal fa-hashtag"></i>
                        <?=HeyUtility::h($vars['job']['job_strings'][0]['department'])?>
                    </span>
            <?php
                }
            ?>
	        
	        <?php

            switch ($vars['job']['salary_type']) {
                case "year":
                    $salaryType = $vars['language'] != 'de' ? "per year" :"pro Jahr";
                    break;
                case "month":
                    $salaryType = $vars['language'] != 'de' ? "per month" :"pro Monat";
                    break;
                case "hour":
                    $salaryType = $vars['language'] != 'de' ? "per hour" :"pro Stunde";
                    break;
                default:
                    $salaryType = '';
            }

            if($vars['job']['salary_is_public']) {
	                $salaryMin = $vars['job']['salary_min'] ?? null;
	                $salaryMax = $vars['job']['salary_max'] ?? null;
	                $salary    = $vars['job']['salary'] ?? null;
	                
	                $salaryOutput = null;
	                
	                if ($salaryMin && $salaryMax && $salaryMin != $salaryMax) {
		                // Spanne anzeigen
		                $minFormatted = number_format($salaryMin, 0, ',', '.');
		                $maxFormatted = number_format($salaryMax, 0, ',', '.');
		                $salaryOutput = "{$minFormatted}–{$maxFormatted} €";
	                } elseif ($salary) {
		                // Festgehalt
		                $salaryOutput = number_format($salary, 0, ',', '.') . ' €';
	                } elseif ($salaryMin) {
		                $salaryOutput = 'ab ' . number_format($salaryMin, 0, ',', '.') . ' €';
	                } elseif ($salaryMax) {
		                $salaryOutput = 'bis ' . number_format($salaryMax, 0, ',', '.') . ' €';
	                }
	                
	                if ($salaryOutput){
		    ?>
                    <span>
                        <i class="fal fa-money-bill-wave"></i>
                        <?= $salaryType ?> <?= $salaryOutput ?>
                    </span>
            <?php

                    }
                }
		       
                if ($vars['job']['remote']) {
                    $remoteString = "";
                    
                    switch ($vars['job']['remote']) {
                        case "complete":
                            $remoteString = $vars['language'] != 'de' ? "100%" :"Komplett";
                        break;
                        case "sometimes":
                            $remoteString = $vars['language'] != 'de' ? "Sometimes" : "Teilweise";
                        break;
                        default:
                            $remoteString = $vars['language'] != 'de' ? "No" :"Nein";
                   }
            ?>
                   <span><i class="fal fa-house"></i>Homeoffice: <?= $remoteString ?> </span>
            <?php
                }
            ?>
       </div>
<?php
        foreach ($jobSection['job_section_elements'] as $key => $value) {
            if ($value['element_type'] === 'text' && file_exists(__DIR__ . DS . '../elements' . DS . $value['element_type'] . '.php')) {
                $jobSectionElement = $value;
                ob_start();
                include __DIR__ . DS . '../elements' . DS . $value['element_type'] . '.php';
                echo ob_get_clean();
            }
        }
    }
?>
