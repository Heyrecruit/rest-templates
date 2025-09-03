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
    
    $companyName = $job['multiposting_company_name'] ?? $company['name'];

    $ariaLabelJobHeader = $language != 'de' ? 'Job Header' : 'Kopfzeile Stellenanzeige';
    $ariaLabelJobKeyData = $language != 'de' ? 'Job key data' : 'Stellenanzeige Eckdaten';
    $ariaLabelIntro = $language != 'de' ? 'Job Intro' : 'Stellenanzeige Intro';
?>

<style>
    .jp-section-list h2 {
        color: <?=HeyUtility::h($company['company_templates']['key_color'])?>;
    }
    body section .social-links a:hover i {
        color: #fff !important;
    }
    body section .social-links a:hover {
        color: #fff !important;
        background: <?=HeyUtility::h($company['company_templates']['key_color'])?>;
    }
</style>

<div class="container pt-4 px-4 px-sm-5 px-lg-3<?php if ($tplFormBottom == true) {?> fullJobWidth<?php }?>" role="main">
    <div class="row">
        <div id="jp-logo-top" class="col-12" role="region" aria-label="<?=$ariaLabelJobHeader?>">
            <a href="/?page=jobs" id="logo" class="jp-logo">
                <img src="<?=$logoUrl?>" alt="<?=HeyUtility::h($companyName)?> Logo">
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
                <span><a href="/?page=jobs"><?=HeyUtility::h($companyName)?></a></span>
                <?= $refreshText !== null ? '<span><i class="fal fa-clock"></i>' . $refreshText . '</span>' : '' ?>
                <span><i class="fal fa-barcode"></i><?= 'Job-ID' . ' ' . $job['id'] ?></span>
            </div>
        </div>

        <?php
            require(CURRENT_SECTION_PATH . "vacancy_offline.php");
      
            if ($tplFormBottom == true) {
                echo '<div id="jp-column-left" class="col-12">';
            } else {
                echo '<div id="jp-column-left" class="col-12 col-lg-7">';
            }
        ?>
        
        <section id="jp-section-job-info" aria-label="<?=$ariaLabelJobKeyData?>">
            <div class="row">
                <div class="col-12">
                    <div>
                        <?php
                            $vars['include_header_image'] = false;
                            HeyUtility::includeSections($job['job_sections'], ['header'], $vars);
                        ?>
                    </div>
                </div>
                <div class="col-12 cta-mobile mb-sm-3 mb-lg-0<?php if ($tplFormBottom == true) {?> d-block<?php } else {?> d-block d-lg-none<?php } ?>">
                    <?php
                        $applyText = $language !== 'de' ? 'Apply now' : 'Jetzt bewerben';
                    ?>
                    <a href="#job-form-wrapper" class="btn btn-primary mt-4"><i class="fas fa-paper-plane mr-2"></i> <?=$applyText?></a>
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

        <section id="jp-section-share-job" aria-label="Social Media Kanäle">
            <div class="row">
                <div class="col-12">
                    <div class="grey-container">
                        <h2 class="primary-color"><?= $language !== 'de' ? 'Share job ad' : 'Stellenanzeige teilen' ?></h2>
                        <div class="social-links" id="job-share-links">
                            <?php
                                $pageUrl = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                            ?>
                            <a class="primary-color social-link-a" data-type="xing/share" href="https://www.xing.com/spi/shares/new?url=<?=urlencode($pageUrl)?>" target="_blank" aria-label="Xing">
                                <i class="fab fa-xing primary-color"></i>
                            </a>

                            <a class="primary-color social-link-a" href="https://www.linkedin.com/sharing/share-offsite/?url=<?=urlencode($pageUrl)?>" target="_blank" aria-label="LinkedIn">
                                <i class="fab fa-linkedin primary-color"></i>
                            </a>

                            <a class="primary-color social-link-a" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2F<?="$_SERVER[HTTP_HOST]"?>%2F%3Fpage%3Djob%26id%3D<?=$job['id']?>%26location%3D<?=$job['company_location_jobs'][0]['id']?>" target="_blank" aria-label="Facebook">
                                <i class="fab fa-facebook primary-color" aria-hidden="true"></i>
                            </a>

                            <a class="primary-color social-link-a" href="https://twitter.com/intent/tweet?url=<?="$_SERVER[HTTP_HOST]"?>%2F%3Fpage%3Djob%26id%3D<?=$job['id']?>%26location%3D<?=$job['company_location_jobs'][0]['id']?>" target="_blank" aria-label="X">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
                                    <path d="M453.2 112L523.8 112L369.6 288.2L551 528L409 528L297.7 382.6L170.5 528L99.8 528L264.7 339.5L90.8 112L236.4 112L336.9 244.9L453.2 112zM428.4 485.8L467.5 485.8L215.1 152L173.1 152L428.4 485.8z"/>
                                </svg>
                            </a>

                            <a class="primary-color social-link-a" href="mailto:?subject=<?= $companyName ?> sucht <?=$job["job_strings"][0]["title"]?>&body=Ich habe ein Jobangebot entdeckt, das Dich interessieren könnte.%0D%0A%0D%0ASchau Dir die Stellenanzeige gleich unter folgendem Link an:%0D%0A <?=urlencode($pageUrl)?>" target="_blank" aria-label="E-Mail">
                                <i class="fas fa-envelope primary-color" aria-hidden="true"></i>
                            </a>

                            <a class="primary-color social-link-a mobile" href="whatsapp://send?text=Ich habe ein Jobangebot entdeckt, das Dich interessieren könnte. <?=urlencode($pageUrl)?>" target="_blank" aria-label="WhatsApp">
                                <i class="fab fa-whatsapp primary-color"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="jp-section-more-jobs">
            <div class="row">
                <div class="col-12">

                    <div class="job-list" data-jobs-container="true" role="list" aria-label="Liste weiterer Stellenanzeigen">
                        <?php
                            require(CURRENT_SECTION_PATH . "more_jobs.php");
                        ?>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <?php
        if ($tplFormBottom == true) {
            echo '<div id="jp-column-right" class="col-12">';
        } else {
            echo '<div id="jp-column-right" class="col-12 col-lg-5">';
        }
        
        HeyUtility::includeSections(
            $job['job_sections'],
            ['form'],
            $vars
        );
    ?>
</div>
</div>
</div>

<?php
	if (!empty($job['multiposting_company_name'])) {
		?>
        <script>
            const search = '<?=HeyUtility::h($company['name'])?>';
            const replace = '<?=$job['multiposting_company_name']?>';

            // <title>
            if (document.title.includes(search)) {
                document.title = document.title.replaceAll(search, replace);
            }

            document.querySelectorAll('meta').forEach(meta => {
                if (meta.content && meta.content.includes(search)) {
                    meta.content = meta.content.replaceAll(search, replace);
                }
            });
        </script>
		<?php
	}
?>