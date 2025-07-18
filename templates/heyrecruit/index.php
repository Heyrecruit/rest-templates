<?php
    /** @var HeyRestApi $scope */
    /** @var array $company */
    /** @var string $template */
    /** @var string $page */

    use Heyrecruit\HeyRestApi;
?>
<!DOCTYPE html>
<html lang="<?=HeyUtility::h($language)?>">
<head>
    <meta name="google-site-verification" content="eI_MQb_IOqtuvB3AeFpa1W_DtqcePhYYCklaQ7yzK9U"/>
    <style>
        /* Set class to override the default template color outta scope */
        <?php
            echo HeyUtility::generateCompanyStyles(
                $company['company_templates']['key_color'],
                $company['company_templates']['secondary_color']
            );
        ?>
    </style>
    <?php
        try {

            $jobs = $scope->getJobs($company['id']);

            if($jobs['status_code'] === 200) {
                $jobs = $jobs['response']['data'] ?? null;
            }else{
                die($jobs['response']['message']);
            }

        } catch (Exception $e) {
            die('Fehler beim Laden der Stellenanzeigen.');
        }

        if ($page === 'job') {

            $jobId      = HeyUtility::getJobId($_GET);
            $locationId = HeyUtility::getLocationId($_GET);

            try {
                $job = $scope->getJob($company['id'], $jobId, $locationId);
                HeyUtility::redirectIfJobNotFound($job['response']['data'] ?? null);

                if($job['status_code'] === 200) {
                    $job = $job['response']['data'];
                }else{
                    die($job['response']['message']);
                }

            } catch (Exception $e) {
                die('Stellenanzeige nicht gefunden.');
            }
        }

        include CURRENT_SECTION_PATH . 'html_head_content.php';
    ?>
</head>

<?php
    $bodyData = HeyUtility::getBodyDataAttributes(
        $_ENV['BASE_PATH'],
        $template,
        $_SERVER['SERVER_NAME'],
        $company['name'],
        $company['company_templates']['key_color'],
        $measurementId,
        $propertyId,
        $company['overview_page']['show_map']
    );

    echo '<body ' . $bodyData . '>';


    if (isset($_GET['formBottom'])) {
        $tplFormBottom = true;
    } else {
        $tplFormBottom = false;
    }

    // Start Redirect Query
    if (isset($_GET['redirect_url'])) {
?>
        <div id="preloader">
            <div class="bouncing-loader">
                <div></div>
                <div></div>
                <div></div>
            </div>
            <span>
                Sie werden weitergeleitet.
            </span>
        </div>
<?php
    } else {
?>
        <div id="preloaderApply">
            <div class="bouncing-loader">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>

        <div id="page" class="<?= $page == 'jobs' ? "careerpage" : "" ?>" data-scope-outer-container="true">
        <?php
            if(file_exists(__DIR__ . DS . 'pages' . DS . "$page.php")) {
                include __DIR__ . DS . 'pages' . DS . "$page.php";
            }

            $page = HeyUtility::getCurrentPage($_GET);

            $displayFooter = '';

            if (isset($_GET['stand_alone_site']) && !filter_var($_GET['stand_alone_site'], FILTER_VALIDATE_BOOLEAN) && $page == 'jobs') {
                $displayFooter = 'style="display:none"';
            }
        ?>
        <footer <?= $displayFooter ?>>
            <?php
                include CURRENT_SECTION_PATH . 'footer.php';
            ?>
        </footer>
    </div>
<?php
        if($displayFooter !== 'style="display:none"') {
            include CURRENT_PAGE_PATH . "impressum.php";
        }

        include ROOT . 'partials/google_4_jobs.php';
    }
?>

</body>
</html>
