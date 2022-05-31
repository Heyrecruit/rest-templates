<?php
	if(!isset($scope)) {
		include __DIR__ . '/../../ini.php';
	}

	$googleTagManager = $scope->getGoogleTagCode($company['CompanySetting']['google_tag_public_id']);
?>

<!DOCTYPE html>
<html>
<head>
	<meta name="google-site-verification" content="eI_MQb_IOqtuvB3AeFpa1W_DtqcePhYYCklaQ7yzK9U" />
	<style>
		/* Set class to override the default template color outta scope */
		.primary-color {
			color: <?=$company['CompanyTemplate']['key_color']?> !important;
		}

		.primary-color-hover:hover,
		.primary-color-hover:hover span,
		.primary-color-hover:hover i,
      .dz-message .dz-button,
      ol li::marker {
			color: <?=$company['CompanyTemplate']['key_color']?> !important;
		}

		.primary-bg {
			background: <?=$company['CompanyTemplate']['key_color']?> !important;
		}

      .primary-bg-before:before,
      .primary-bg-before ul li:before,
      .primary-bg-hover:hover,
      .scope-img-wrap .dot.active {
			background: <?=$company['CompanyTemplate']['key_color']?> !important;
		}

		.secondary-color {
			color: <?=$company['CompanyTemplate']['secondary_color']?> !important;
		}

		.secondary-color-hover:hover {
			color: <?=$company['CompanyTemplate']['secondary_color']?> !important;
		}

		.secondary-bg {
			background: <?=$company['CompanyTemplate']['secondary_color']?> !important;
		}

		.secondary-bg-hover:hover {
			background: <?=$company['CompanyTemplate']['secondary_color']?> !important;
		}
	</style>
	<?php
		//echo $googleTagManager['head'];

		if(isset($_GET['page']) && $_GET['page'] === 'job') {
			include __DIR__ . DS . "../../partials/get_job.php";
		}

		include __DIR__ . DS . 'sections' . DS . 'html_head_content.php';
	?>
</head>
<?php

	echo "<body data-base-path=\"{$_ENV['BASE_PATH']}/templates/$template\"
	            data-domain=\"{$_SERVER['SERVER_NAME']}\"
	            data-company-name=\"{$company['Company']['name']}\"
	            data-key-color=\"{$company['CompanyTemplate']['key_color']}\"
	            data-gtm-id=\"{$company['CompanySetting']['google_tag_public_id']}\"
	            data-gtm-property-id=\"_gat_{$company['CompanySetting']['google_analytics_property_id']}\"
	            data-datenschutz-url=\"#scope_datenschutz\"
	            data-language=\"{$language}\"
	            data-datenschutz-class=\"\">";

	//		echo $googleTagManager['body'];
?>

<div id="page" data-scope-outer-container="true">
	<?php
		include __DIR__ . DS . 'pages' . DS . "$page.php";
	?>

	<?php
		$displayFooter = '';
		if(isset($_GET['stand_alone_site']) && !$_GET['stand_alone_site'] && $page == 'jobs') {
			$displayFooter = 'style="display:none"';
		}
	?>
	<footer <?=$displayFooter?>>
		<?php
			include __DIR__ . DS . 'sections' . DS . 'footer.php';
		?>
	</footer>

</div>
<?php
	include __DIR__ . DS . 'pages' . DS . "impressum.php";

	include __DIR__ . DS . '../../partials/google_4_jobs.php';
?>
</body>
</html>
