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
	
	$vars = [
		'include_header_image' => true,
		'formatted_job_location' => $formattedJobLocation,
		'job' => $job,
		'company' => $company,
		'language' => $language,
	];
	
	include CURRENT_SECTION_PATH . "nav.php";
?>
<style>
	#intro_form h2, #intro_form p {
		color: # <?=$job['Template']['headline_color']?> !important;
	}
</style>

<?php
	HeyUtility::includeSections($job['job_sections'], [], $vars);
 
	$pageUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$pageUrl .= "&utm_campaign=scope-social-share&utm_medium=scope-social-share";
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
		<a href="https://www.scope-recruiting.de/jobs/printJob/<?=$jobId?>/<?=$locationId?>/<?=$company['language_id']?>" target="_blank" class="primary-bg">
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


