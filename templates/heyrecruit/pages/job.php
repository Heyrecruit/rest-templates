<?php

if (!isset($job)) {
    include __DIR__ . DS . "../../../partials/get_job.php";
}

// Job not found -> redirect to error page defined in .env
if ($job['status_code'] === 404) {
    $URL = $_ENV['BASE_PATH'] . '?page=' . $_ENV['ERROR_PAGE'] . '&code=' . $job['status_code'];
    if (headers_sent()) {
        echo("<script>window.location.href='$URL'</script>");
    } else {
        header("Location: $URL");
    }
    exit;
}

$job = $job['data'];

$formattedJobLocation = $scope->getFormattedAddress($job, true, true, true);

$applicantId = !empty($applicantId) ? $applicantId : $job['Form']['applicant_id'];

include __DIR__ . DS . '../sections' . DS . "nav.php";


$logoUrl = '';
if (!empty($company) && isset($company['Company']['logo'])) {
    $logoUrl = $company['Company']['logo'];
}

$cities = [];

if (!empty($job)) {
    foreach ($job['AllCompanyLocationJob'] as $key => $value) {
        if (!empty($value['CompanyLocationJob'])) {
            if (!in_array($value['CompanyLocation']['city'], $cities) && $locationId !== $value['CompanyLocation']['id']) {
                $cities[$value['CompanyLocation']['id']] = $value['CompanyLocation']['city'];
            }
        }
    }
}

if (!empty($job['JobSection'])) {
    foreach ($job['JobSection'] as $key => $value) {
        if (file_exists(__DIR__ . DS . '../sections' . DS . $value['section_type'] . '.php') && $value['section_type'] === 'header') {
            $jobSection = $value;
            $headerImageIncluded = true;
            ob_start();
            include __DIR__ . DS . '../sections' . DS . $value['section_type'] . '.php';
            echo ob_get_clean();
        }
    }
} ?>

<style>
    .jp-section-list h2 {
        color: <?=$company['CompanyTemplate']['key_color']?>;
    }
</style>

<div class="container">
    <div class="row">
        <div id="jp-column-left" class="col-12 col-lg-7">
            <section id="jp-section-job-info">
                <div class="row">
                    <div class="col-12">
                        <div>
                            <?php
/*                            print("<pre>".print_r($job['JobSection'],true)."</pre>");
                            */?>
                            <div>
                                <a href="/?page=jobs" id="logo" class="jp-logo">
                                    <img src="<?= $logoUrl ?>" alt="<?= $company['Company']['name'] ?> Logo">
                                </a>
                                <div>
                                    <?php
                                    if (isset($job['Job']['last_modification'])) {
                                       if ($language != 'de') {
                                          $refreshText = 'updated ' . Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $job['Job']['last_modification'])->locale('en_US')->diffForHumans();
                                       } else {
                                          $refreshText = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $job['Job']['last_modification'])->locale('de_DE')->diffForHumans() . ' aktualisiert';
                                       }
                                    } else {
                                       $refreshText = NULL;
                                    }

                                    $jobIdText = $language != 'de' ? 'job id' : 'Job-ID';
                                    ?>
                                    <span><a href="/?page=jobs"><?= $company['Company']['name'] ?></a></span>
                                    <?= $refreshText !== NULL ? '<span><i class="fal fa-clock"></i>' . $refreshText . '</span>' : '' ?>
                                    <span><i class="fal fa-barcode"></i><?= $jobIdText . ' ' . $job['Job']['id'] ?></span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <?php
                            if (!empty($job['JobSection'])) {
                                foreach ($job['JobSection'] as $key => $value) {
                                    if (file_exists(__DIR__ . DS . '../sections' . DS . $value['section_type'] . '.php') && $value['section_type'] === 'header') {
                                        $jobSection = $value;
                                        $headerImageIncluded = false;
                                        ob_start();
                                        include __DIR__ . DS . '../sections' . DS . $value['section_type'] . '.php';
                                        echo ob_get_clean();
                                    }
                                }
                            } ?>
                        </div>
                    </div>
                </div>
            </section>
            <?php
            if (!empty($job['JobSection'])) {

                foreach ($job['JobSection'] as $key => $value) {
                    if (
                    		file_exists(__DIR__ . DS . '../sections' . DS . $value['section_type'] . '.php') &&
		                    in_array($value['section_type'], ['text_and_list', 'media', 'company_info', 'contact_person'])) {

                        $jobSection = $value;
                        ob_start();
                        include __DIR__ . DS . '../sections' . DS . $value['section_type'] . '.php';

                        echo ob_get_clean();
                    }
                }

            }
            ?>
            <section id="jp-section-more-jobs">
                <div class="row">
                    <div class="col-12">
                        <h2 class="primary-color"><?= $language != 'de' ? 'More vacancies' : 'Weitere offene Stellen' ?></h2>
                        <div class="job-list" data-jobs-container="true">
                            <?php
                            $moreJobsSection = true;
                            require(__DIR__ . "/../elements/jobs_table.php")
                            ?>
                        </div>
                        <button id="all-vacancies-button" class="btn btn-primary">
                            <a href="/?page=jobs#cp-section-jobs"><?= $language != 'de' ? 'All vacancies' : 'Alle offenen Stellen' ?></a>
                        </button>
                    </div>
                </div>
            </section>

            <!-- Initiativbewerbung-Section -->
            <!--<section id="jp-section-initiative">
                <div class="row">
                    <div class="col-12">
                        <div class="initiative-tile">
                            <h2 class="primary-color"><?/*= $language != 'de' ? 'Didn’t find a matching job?' : 'Keine passende Stelle gefunden?' */?></h2>
                            <p>
                                Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor
                                invidunt ut labore et dolore magna aliquyam erat
                            </p>
                            <button class="btn btn-primary">
                                <i class="fal fa-paper-plane"></i><?/*= $language != 'de' ? 'Apply on your own initiative' : 'Jetzt initiativ bewerben' */?>
                            </button>
                        </div>
                    </div>
                </div>
            </section>-->


        </div>
        <div id="jp-column-right" class="col-12 col-lg-5">
            <?php
            if (!empty($job['JobSection'])) {

                foreach ($job['JobSection'] as $key => $value) {

                    if (file_exists(__DIR__ . DS . '../sections' . DS . $value['section_type'] . '.php') && $value['section_type'] === 'form') {

                        $jobSection = $value;
                        ob_start();
                        include __DIR__ . DS . '../sections' . DS . $value['section_type'] . '.php';

                        echo ob_get_clean();
                    }
                }
            }
            ?>

            <!-- Status-prüfen-Section -->
            <!--<section id="jp-section-check-status">
                <div class="row">
                    <div class="col-12">
                        <div class="grey-container">
                            <h2 class="primary-color"><?/*= $language != 'de' ? 'You already applied?' : 'Bereits beworben?' */?></h2>
                            <button class="btn btn-primary">
                                <?/*= $language != 'de' ? 'Check status' : 'Status prüfen' */?>
                            </button>
                        </div>
                    </div>
                </div>
            </section>-->

            <!-- Später-bewerben-Section -->
            <!--<section id="jp-section-apply-later">
                <div class="row">
                    <div class="col-12">
                        <div class="grey-container">
                            <h2 class="primary-color"><?/*= $language != 'de' ? 'Apply later' : 'Später bewerben' */?></h2>
                            <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor
                                invidunt ut labore et dolore magna aliquyam erat</p>
                            <form class="apply-later-form">
                                <input type="email" name="email" placeholder="E-Mail-Adresse">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fal fa-paper-plane"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </section>-->

            <section id="jp-section-share-job">
                <div class="row">
                    <div class="col-12">
                        <div class="grey-container">
                            <h2 class="primary-color"><?= $language != 'de' ? 'Share job ad' : 'Stellenanzeige teilen' ?></h2>
                            <div class="social-links">
                                <a class="primary-color" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2F<?="$_SERVER[HTTP_HOST]"?>%2F%3Fpage%3Djob%26id%3D<?=$job['Job']['id']?>%26location%3D<?=$job['CompanyLocation']['id']?>" target="_blank"><i
                                            class="fab fa-facebook primary-color" aria-hidden="true"></i></a>
                                <a class="primary-color" href="https://twitter.com/intent/tweet?url=<?="$_SERVER[HTTP_HOST]"?>%2F%3Fpage%3Djob%26id%3D<?=$job['Job']['id']?>%26location%3D<?=$job['CompanyLocation']['id']?>" target="_blank"><i class="fab fa-twitter primary-color"
                                                                                    aria-hidden="true"></i></a>
                                <a class="primary-color" href="" target="_blank"><i
                                            class="fab fa-facebook-messenger primary-color" aria-hidden="true"></i></a>
                                <a class="primary-color" href="" target="_blank"><i
                                            class="fas fa-envelope primary-color" aria-hidden="true"></i></a>
                                <a class="primary-color" href="" target="_blank"><i
                                            class="fas fa-share-alt primary-color" aria-hidden="true"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<?php
$pageUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$pageUrl .= "&utm_campaign=scope-social-share&utm_medium=scope-social-share";
?>

<script src="<?= $_ENV['BASE_PATH'] ?>/templates/<?= $template ?>/js/reset-form-data.js"></script>

<script>
    $(document).ready(function () {

        //Set page title and description
        templateHandler.setMetaDescriptionAndTitle('Wir suchen ab sofort: <?=$job["Job"]["title"]?>', '<?=$job["Job"]["title"]?> | <?=$company['Company']['name']?>');
    });
</script>
