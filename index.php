<?php
/**
 * @var array $company
 * @var string $template
 * @var string $language
 * @var string $fallbackDataProtectionModal
 */

if (!isset($scope)) {
    include __DIR__ . '/ini.php';
}

$googleTagManager4       = HeyUtility::env('GOOGLE_TAG_MANAGER');
$companyTrackingSettings = $company['company_tracking_settings'] ?? [];
$measurementId           = $company['google_account']['measurementId'] ?? '';
$propertyId              = $company['google_account']['propertyId'] ?? null;

setcookie("ga4MeasurementId", $measurementId);
$safeJsString = addslashes($measurementId);
?>
<script type='text/javascript'>
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push({ ga4MeasurementId: '<?=$safeJsString?>' });
</script>
<?php

$page = HeyUtility::getCurrentPage($_GET);
$meta = HeyUtility::getPageMetadata($page, $company);

try {
    $trackingSettings = HeyUtility::buildTrackingSettings($companyTrackingSettings);
} catch (JsonException $e) {
	$trackingSettings = [];
}
	
	if($page === 'jobs' && !empty($company['overview_page']['redirect_url'])) {
?>
    <script type="text/javascript">
        if (window.self === window.top) { // Überprüft, ob die aktuelle Seite in einem Iframe geladen wurde.
            window.location.href = "<?=$company['overview_page']['redirect_url']?>";
        }
    </script>
<?php
}

unset($_SESSION['files']);

include CURRENT_TEMPLATE_PATH . 'index.php';

if (file_exists($fallbackDataProtectionModal))
    include_once $fallbackDataProtectionModal;
?>
<script src="<?= $_ENV['BASE_PATH'] ?>/js/dataLayerPusher.js"></script>
<script>
    initializeDataLayerOnPageLoad(
        <?php echo json_encode($page); ?>,
        <?php echo json_encode($company); ?>,
        <?php echo json_encode($language); ?>,
        <?php echo isset($job) ? json_encode($job) : '{}'; ?>
    );

    const GTM4_GLOBAL_ID = '<?php echo $googleTagManager4; ?>';
    const TRACKING_SETTINGS = JSON.parse('<?= json_encode($trackingSettings); ?>');
</script>
<script type="text/javascript" src="<?= $_ENV['BASE_PATH'] ?>/js/tracking.js"></script>
<script type="text/javascript" src="<?= $_ENV['BASE_PATH'] ?>/js/redirect.js"></script>
