<section id="scope-jobs-intro-section" class="row no-gutters">
    <div class="col-12">
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
            $language = $vars['language'];
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

