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

<?php
	HeyUtility::includeSections($job['job_sections'], [], $vars);
 
	$pageUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$pageUrl .= "&utm_campaign=scope-social-share&utm_medium=scope-social-share";
?>
<div id="social-bar" role="navigation" aria-label="Social Media Kanäle">
	<div>
		<a href="http://www.facebook.com/sharer.php?u=<?=urlencode($pageUrl . '&utm_source=facebook')?>" target="_blank" class="primary-bg" aria-label="Facebook">
			<i class="fab fa-facebook-f"></i>
		</a>
	</div>
	<div>
		<a href="https://twitter.com/share?url=<?=urlencode($pageUrl . '&utm_source=twitter')?>" target="_blank" class="primary-bg" aria-label="X">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" aria-label="Logo X">
                <path d="M453.2 112L523.8 112L369.6 288.2L551 528L409 528L297.7 382.6L170.5 528L99.8 528L264.7 339.5L90.8 112L236.4 112L336.9 244.9L453.2 112zM428.4 485.8L467.5 485.8L215.1 152L173.1 152L428.4 485.8z"/>
            </svg>
		</a>
	</div>
	<div>
		<a href="https://www.xing.com/spi/shares/new?url=<?=urlencode($pageUrl . '&utm_source=xing')?>" target="_blank" class="primary-bg" aria-label="Xing">
			<i class="fab fa-xing"></i>
		</a>
	</div>
	<div>
		<a href="https://www.scope-recruiting.de/jobs/printJob/<?=$jobId?>/<?=$locationId?>/<?=$company['language_id']?>" target="_blank" class="primary-bg" aria-label="Stellenanzeige drucken">
			<i class="fas fa-print"></i>
		</a>
	</div>
</div>
<div id="mobile-social-bar" role="navigation" aria-label="Social Media Kanäle">
	<div id="mobile-social-bar-trigger">
		<a class="primary-bg"><i class="fa fa-share-alt" id="fa-trigger" aria-hidden="true"></i></a>
	</div>
	<div>
		<a href="http://www.facebook.com/share.php?u=<?=urlencode($pageUrl . '&utm_source=facebook')?>" target="_blank" class="primary-bg scope_facebook_share" aria-label="Facebook"><i
					class="fab fa-facebook-f" aria-hidden="true"></i></a>
	</div>
	<div>
		<a href="https://twitter.com/share?url=<?=urlencode($pageUrl . '&utm_source=twitter')?>"
		   target="_blank" class="primary-bg scope_twitter_share" aria-label="X"><i class="fab fa-twitter" aria-hidden="true"></i></a>
	</div>
	<div>
		<a href="WhatsApp://send?text=Schau mal: Diesen Job habe ich gefunden: <?=urlencode($pageUrl)?>" target="_blank" class="primary-bg" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
	</div>
	<div>
		<a href="https://www.xing.com/spi/shares/new?url=<?=urlencode($pageUrl . '&utm_source=xing')?>"
		   target="_blank" class="primary-bg" aria-label="Xing"><i class="fab fa-xing" aria-hidden="true"></i></a>
	</div>
	<div>
		<a href="mailto:?Subject=Job Angebot&amp;Body=Diesen%20Job%20habe%20ich%20gefunden:%20<?=urlencode($pageUrl)?>"
		   target="_blank" class="primary-bg" aria-label="E-Mail"><i class="fa fa-envelope" aria-hidden="true"></i></a>
	</div>
	<div>
		<a href="mailto:?Subject=Stellenanzeige&amp;body=Schau mal: Diesen Job habe ich gefunden: <?=urlencode($pageUrl)?>" target="_top" class="primary-bg" aria-label="Stellenanzeige drucken">
			<i class="fa fa-print" aria-hidden="true"></i>
		</a>
	</div>
</div>


