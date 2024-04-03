<?php
    /** @var array $job */
    /** @var array $company */
    /** @var int $locationId */
    /** @var string $language */
    /** @var string $template */
    /** @var HeyUtility $utility */
	HeyUtility::redirectIfJobNotFound($job);
	
	$formattedJobLocation = HeyUtility::getFormattedAddress($job['company_location_jobs'][0]);
	$language = $job['language']['shortcut'];
	$company['language_id'] = $job['language']['id'];
	$logoUrl = $company['logo'];
    
    include CURRENT_SECTION_PATH . "nav.php";
    
    $logoUrl = $company['logo'];
    
    $vars = [
        'include_header_image' => true,
        'formatted_job_location' => $formattedJobLocation,
        'job' => $job,
        'company' => $company,
        'language' => $language,
    ];
    
    HeyUtility::includeSections($job['job_sections'], ['header'], $vars);
?>

<style>
    .jp-section-list h2 {
        color: <?=$company['company_templates']['key_color']?>;
    }
</style>

<div class="container">
    <div class="row">

        <?php
            require(CURRENT_SECTION_PATH . "vacancy_offline.php");
        ?>

        <div id="jp-column-left" class="col-12 col-lg-7">
            <section id="jp-section-job-info" >
                <div class="row">
                    <div class="col-12">
                        <div>
                           
                            <div>
                                <a href="/?page=jobs" id="logo" class="jp-logo">
                                    <img src="<?=$logoUrl?>" alt="<?=HeyUtility::h($company['name'])?> Logo">
                                </a>
                                <div>
                                    <?php
                                        if (isset($job['last_modification'])) {
                                           if ($language != 'de') {
                                              $refreshText = 'updated ' . Carbon\Carbon::parse(
                                                  $job['last_modification']
                                              )->locale('en_US')->diffForHumans();
                                           } else {
                                              $refreshText = Carbon\Carbon::parse(
                                                  $job['last_modification']
                                              )->locale('de_DE')->diffForHumans() . ' aktualisiert';
                                           }
                                        } else {
                                           $refreshText = null;
                                        }
                                    ?>
                                    <span><a href="/?page=jobs"><?=HeyUtility::h($company['name'])?></a></span>
                                    <?= $refreshText !== null ? '<span><i class="fal fa-clock"></i>' . $refreshText . '</span>' : '' ?>
                                    <span><i class="fal fa-barcode"></i><?= 'Job-ID' . ' ' . $job['id'] ?></span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <?php
	                            $vars['include_header_image'] = false;
                                HeyUtility::includeSections($job['job_sections'], ['header'], $vars);
                            ?>
                        </div>
                    </div>
                    <div class="col-12 cta-mobile">
                        <?php
	                        $applyText = $language !== 'de' ? 'Apply now' : 'Jetzt bewerben';
                        ?>
                      <a href="#job-form-wrapper" class="btn btn-primary mt-4"><?=$applyText?></a>
                    </div>
                </div>
            </section>

            <?php
	            HeyUtility::includeSections(
		            $job['job_sections'],
		            ['text_and_list', 'media', 'company_info', 'contact_person'],
		            $vars
	            );
            ?>


          <section id="jp-section-more-jobs">
            <div class="row">
              <div class="col-12">

                <div class="job-list" data-jobs-container="true">
                  <?php
                      require(CURRENT_SECTION_PATH . "more_jobs.php");
                  ?>
                </div>
              </div>
            </div>
          </section>
        </div>
        <div id="jp-column-right" class="col-12 col-lg-5">
            <?php
          
            HeyUtility::includeSections(
                $job['job_sections'],
                ['form'],
                $vars
            );
            ?>

            <section id="jp-section-share-job">
                <div class="row">
                    <div class="col-12">
                        <div class="grey-container">
                            <h2 class="primary-color"><?= $language !== 'de' ? 'Share job ad' : 'Stellenanzeige teilen' ?></h2>
                            <div class="social-links" id="job-share-links">
                                <?php
                                $pageUrl = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                                ?>
                                <a class="primary-color" data-type="xing/share" href="https://www.xing.com/spi/shares/new?url=<?=urlencode($pageUrl)?>" target="_blank">
                                    <i class="fab fa-xing primary-color"></i>
                                </a>

                                <a class="primary-color" href="https://www.linkedin.com/sharing/share-offsite/?url=<?=urlencode($pageUrl)?>" target="_blank">
                                    <i class="fab fa-linkedin primary-color"></i>
                                </a>

                                <a class="primary-color" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2F<?="$_SERVER[HTTP_HOST]"?>%2F%3Fpage%3Djob%26id%3D<?=$job['id']?>%26location%3D<?=$job['company_location_jobs'][0]['id']?>" target="_blank">
                                    <i class="fab fa-facebook primary-color" aria-hidden="true"></i>
                                </a>

                                <a class="primary-color" href="https://twitter.com/intent/tweet?url=<?="$_SERVER[HTTP_HOST]"?>%2F%3Fpage%3Djob%26id%3D<?=$job['id']?>%26location%3D<?=$job['company_location_jobs'][0]['id']?>" target="_blank">
                                    <i class="fab fa-twitter primary-color" aria-hidden="true"></i>
                                </a>

                                <a class="primary-color" href="mailto:?subject=<?= $company['name'] ?> sucht <?=$job["job_strings"][0]["title"]?>&body=Ich habe ein Jobangebot entdeckt, das Dich Interessieren könnte.%0D%0A%0D%0ASchau Dir die Stellenanzeige gleich unter folgendem Link an:%0D%0A <?=urlencode($pageUrl)?>" target="_blank">
                                    <i class="fas fa-envelope primary-color" aria-hidden="true"></i>
                                </a>

                                <a class="primary-color mobile" href="whatsapp://send?text=Ich habe ein Jobangebot entdeckt, das Dich Interessieren könnte. <?=urlencode($pageUrl)?>" target="_blank">
                                    <i class="fab fa-whatsapp primary-color"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {

        //Set page title and description
        templateHandler.setMetaDescriptionAndTitle(
            'Wir suchen ab sofort: <?=HeyUtility::h($job["job_strings"][0]["title"])?>',
            '<?=HeyUtility::h($job["job_strings"][0]["title"])?> | <?=HeyUtility::h($company['name'])?>'
        );
    });
</script>
