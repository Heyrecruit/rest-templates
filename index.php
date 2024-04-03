<?php
	/** @var array $company */
	/** @var string $template */
	/** @var string $language */
	
	if(!isset($scope)) {
		include __DIR__ . '/ini.php';
	}
 
	$googleTagManager4 = HeyUtility::env('GOOGLE_TAG_MANAGER');
	$measurementId     = $company['google_account']['measurementId'] ?? '';
	$propertyId        = $company['google_account']['propertyId'] ?? null;
 
 
	setcookie("ga4MeasurementId", $measurementId);
 
	$page = HeyUtility::getCurrentPage($_GET);
	$meta = HeyUtility::getPageMetadata($page, $company);
	
	unset($_SESSION['files']);

	include CURRENT_TEMPLATE_PATH . 'index.php';
?>
<script src="<?=$_ENV['BASE_PATH']?>/js/dataLayerPusher.js"></script>
<script>
    initializeDataLayerOnPageLoad(
      <?php echo json_encode($page); ?>,
      <?php echo json_encode($company); ?>,
      <?php echo json_encode($language); ?>,
      <?php echo isset($job) ? json_encode($job) : '{}'; ?>
    );

    const gtm4IdGlobal = '<?php echo $googleTagManager4; ?>';
</script>
<script type="text/javascript" src="<?=$_ENV['BASE_PATH']?>/js/googleTagManager.js"></script>
