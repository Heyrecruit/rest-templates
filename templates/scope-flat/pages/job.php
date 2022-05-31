<?php

	if(!isset($job)){
		include __DIR__ . DS . "../../../partials/get_job.php";
	}

	// Job not found -> redirect to error page defined in .env
	if($job['status_code'] === 404) {
		$URL = $_ENV['BASE_PATH'] . '?page=' . $_ENV['ERROR_PAGE'] . '&code=' . $job['status_code'];
		if(headers_sent()) {
			echo("<script>window.location.href='$URL'</script>");
		} else {
			header("Location: $URL");
		}
		exit;
	}

	$job                  = $job['data'];
	$formattedJobLocation = $scope->getFormattedAddress($job, false, true, false);

	if($language !== 'de') {
		$formattedJobLocation = str_replace('Deutschland', 'Germany', $formattedJobLocation);
	}

	$applicantId = !empty($applicantId) ? $applicantId : $job['Form']['applicant_id'];

	include __DIR__ . DS . '../sections' . DS . "nav.php";
?>
<style>
	#intro_form h2, #intro_form p {
		color: # <?=$job['Template']['headline_color']?> !important;
	}
</style>

<?php
	$cities = [];

	if(!empty($job)) {
		foreach($job['AllCompanyLocationJob'] as $key => $value) {
			if(!empty($value['CompanyLocationJob'])) {
				if(!in_array($value['CompanyLocation']['city'], $cities) && $locationId !== $value['CompanyLocation']['id']) {
					$cities[$value['CompanyLocation']['id']] = $value['CompanyLocation']['city'];
				}
			}
		}
	}

	if(!empty($job['JobSection'])) {

		foreach($job['JobSection'] as $key => $value) {

			if(file_exists(__DIR__ . DS . '../sections' . DS . $value['section_type'] . '.php')) {

				$jobSection = $value;
				echo '<div id="section' . $value['id'] . '" style="visibility:hidden"></div>';
				ob_start();
				include __DIR__ . DS . '../sections' . DS . $value['section_type'] . '.php';

				echo ob_get_clean();
			}
		}
	}


	$pageUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$pageUrl .= "&utm_campaign=scope-social-share&utm_medium=scope-social-share";

	$languageId = isset($language) && $language !== 'de' ? 2 : 1;

?>
<div id="social-bar">
	<div>
		<a href="http://www.facebook.com/sharer.php?u=<?=urlencode($pageUrl . '&utm_source=facebook')?>" target="_blank" class="primary-bg">
			<i class="fab fa-facebook-f"></i>
		</a>
	</div>
	<div>
		<a href="https://twitter.com/share?url=<?=urlencode($pageUrl . '&utm_source=twitter')?>" target="_blank" class="primary-bg">
			<i class="fab fa-twitter"></i>
		</a>
	</div>
	<div>
		<a href="https://www.xing.com/spi/shares/new?url=<?=urlencode($pageUrl . '&utm_source=xing')?>" target="_blank" class="primary-bg">
			<i class="fab fa-xing"></i>
		</a>
	</div>
	<div>
		<a href="https://www.scope-recruiting.de/jobs/printJob/<?=$jobId?>/<?=$locationId?>/<?=$languageId?>" target="_blank" class="primary-bg">
			<i class="fas fa-print"></i>
		</a>
	</div>
</div>
<div id="mobile-social-bar">
	<div id="mobile-social-bar-trigger">
		<a class="primary-bg"><i class="fa fa-share-alt" id="fa-trigger" aria-hidden="true"></i></a>
	</div>
	<div>
		<a href="http://www.facebook.com/share.php?u=<?=urlencode($pageUrl . '&utm_source=facebook')?>" target="_blank" class="primary-bg scope_facebook_share"><i
					class="fab fa-facebook-f" aria-hidden="true"></i></a>
	</div>
	<div>
		<a href="https://twitter.com/share?url=<?=urlencode($pageUrl . '&utm_source=twitter')?>"
		   target="_blank" class="primary-bg scope_twitter_share"><i class="fab fa-twitter" aria-hidden="true"></i></a>
	</div>
	<div>
		<a href="WhatsApp://send?text=Schau mal: Diesen Job habe ich gefunden: <?=urlencode($pageUrl)?>" target="_blank" class="primary-bg"><i class="fab fa-whatsapp"></i></a>
	</div>
	<div>
		<a href="https://www.xing.com/spi/shares/new?url=<?=urlencode($pageUrl . '&utm_source=xing')?>"
		   target="_blank" class="primary-bg"><i class="fab fa-xing" aria-hidden="true"></i></a>
	</div>
	<div>
		<a href="mailto:?Subject=Job Angebot&amp;Body=Diesen%20Job%20habe%20ich%20gefunden:%20<?=urlencode($pageUrl)?>"
		   target="_blank" class="primary-bg"><i class="fa fa-envelope" aria-hidden="true"></i></a>
	</div>
	<div>
		<a href="mailto:?Subject=Stellenanzeige&amp;body=Schau mal: Diesen Job habe ich gefunden: <?=urlencode($pageUrl)?>" target="_top" class="primary-bg">
			<i class="fa fa-print" aria-hidden="true"></i>
		</a>
	</div>
</div>

<script src="<?=$_ENV['BASE_PATH']?>/templates/<?=$template?>/js/reset-form-data.js"></script>

<script>
    $(document).ready(function () {

        //Set page title and description
        templateHandler.setMetaDescriptionAndTitle('Wir suchen ab sofort: <?=$job["Job"]["title"]?>', '<?=$job["Job"]["title"]?> | <?=$company['Company']['name']?>');
    });
</script>