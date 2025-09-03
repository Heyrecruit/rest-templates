<?php

$language = $vars['language'];

$ariaLabelIntro = $language != 'de' ? 'Job Intro' : 'Stellenanzeige Intro';
?>

<section id="scope-jobs-intro-section" class="row no-gutters" aria-label="<?=$ariaLabelIntro?>">
    <div class="col-12" role="region"  aria-labelledby="jobIntroTitle">
        <div id="scope-jobs-intro-section-hl-wrap">
            <?php
            foreach($jobSection['job_section_elements'] as $key => $value) {
                if(
                    $value['element_type'] !== 'image'
                    && file_exists(__DIR__ . DS . '../elements' . DS . $value['element_type'] . '.php')
                ) {
                    $jobSectionElement = $value;
                    ob_start();
                    include __DIR__ . DS . '../elements' . DS . $value['element_type'] . '.php';
                    $element = ob_get_clean();

                    echo $element;
                }
            }

            $job = $vars['job'];
            $companyLocationJobs = $job['active_company_location_jobs'];
            ?>

            <div id="scope-jobs-intro-section-hl-line"></div>

            <div id="scope-jobs-intro-section-info">

                <div id="locationWrapper" class="primary-color-hover">
                    <i class="fas fa-map-marker-alt"></i>
                    <div class="locationTrigger">
                        <span><?=$vars['formatted_job_location']?></span>
                        <?php
                        if(count($companyLocationJobs) > 1){
                            ?>
                            <i class="fas fa-angle-down"></i>
                            <?php
                        }
                        ?>
                    </div>
                    <?php
                    if(count($companyLocationJobs) > 1){
                        ?>
                        <ul id="locationList">
                            <?php
                            foreach($companyLocationJobs as $a => $b){
                                $formattedAddress = HeyUtility::getFormattedAddress($b);
                                ?>
                                <li class="locationTriggerLi" data-location-id="<?=$b['company_location_id']?>">
                                    <?=HeyUtility::h($formattedAddress)?>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                        <?php
                    }
                    ?>
                </div>

                <?php
                $parts  = explode(",", $job['job_strings'][0]['employment']);
                $result = implode(', ', $parts);
                ?>

                <span><i class="far fa-clock"></i> <?=HeyUtility::h($result)?></span>


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
                ?>


            </div>
            <div id="scope-jobs-intro-section-btn">
                <?php
                $text = $language != 'de' ? 'Apply now' : 'Jetzt bewerben';
                ?>
                <a href="#job-form-wrapper" class="btn primary-bg primary-color-hover white-bg-hover px-3">
                    <i class="fas fa-paper-plane mr-2"></i> <?=$text?>
                </a>
            </div>
        </div>
        <div>
            <?php
            foreach ($jobSection['job_section_elements'] as $key => $value) {
                if (
                    $value['element_type'] === 'image' &&
                    file_exists(__DIR__ . DS . '../elements' . DS . $value['element_type'] . '.php')
                ) {
                    $jobSectionElement = $value;
                    ob_start();
                    include __DIR__ . DS . '../elements' . DS . $value['element_type'] . '.php';
                    echo ob_get_clean();
                }
            }
            ?>
        </div>
    </div>
</section>

