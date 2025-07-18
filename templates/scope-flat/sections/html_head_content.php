<meta charset="utf-8">
<?php
if(isset($page) && $page === 'job') {
    $meta['title'] = HeyUtility::h($job['job_strings'][0]['title']) . ' | Karriere bei ' . HeyUtility::h($company['name']);
}
?>

<title><?php echo $meta['title']; ?></title>
<?php
include ELEMENT_PATH_ROOT . "canonical.php";
include ELEMENT_PATH_ROOT . "meta.php";
?>

<link rel="stylesheet" type="text/css" href="/css/bootstrap.4.4.1.css?version=<?=VERSION?>">
<link rel="stylesheet" type="text/css" href="/css/apply_on_more_locations.css?version=<?=VERSION?>">
<link rel="stylesheet" type="text/css" href="/css/whatsapp.css?version=<?=VERSION?>">
<!-- start cookieBanner -->
<link rel="stylesheet" type="text/css" href="/css/cookieBanner.css?version=<?=VERSION?>">
<?php
	$basePath = !empty($_ENV['BASE_PATH']) ? $_ENV['BASE_PATH'] : __DIR__;
?>
<?php if(is_file($basePath . '/templates/' . $template . '/css/cookieBanner.css')) { ?>
	<link rel="stylesheet" type="text/css"
	      href="<?=$_ENV['BASE_PATH']?>/templates/<?=$template?>/css/cookieBanner.css?version=<?=VERSION?>">
<?php } ?>
<script src="/js/cookieBanner.js?version=<?=VERSION?>"></script>
<style>
    /* Set class to override the default CookieBanner */

    .cookie h1, .cookie h2, .cookie h3, span.info, .cookie .cookieModal .descrption .infoTrigger, .fa-times.remove-search:hover {
        color: <?=$company['company_templates']['key_color']?> !important;
    }

    .cookie .cookieModal .switch input:checked + .slider {
        background-color: <?=$company['company_templates']['key_color']?> !important;
    }

    .cookie .button.color {
        background: <?=$company['company_templates']['key_color']?> !important;
        border-color: <?=$company['company_templates']['key_color']?> !important;
    }

    .cookie .button.color:hover {
        background: white !important;
        color: <?=$company['company_templates']['key_color']?> !important;
    }

    .cookie p, .cookie td, .cookie a, .cookie span {
        font-size: 14px !important;
        line-height: 24px !important;
    }

    #scope_datenschutz a {
        color: <?=$company['company_templates']['key_color']?> !important;
    }
    body section#jp-section-form #job-form-wrapper .hey-form-row .multiselect-native-select .btn-group.open button,
    body section#jp-section-form #job-form-wrapper .hey-form-row .multiselect-native-select .btn-group button:hover,
    body section#jp-section-form #job-form-wrapper .hey-form-row .multiselect-native-select .btn-group button:focus {
        border-color:<?=$company['company_templates']['key_color']?> !important;
    }

    .multi-locations h3,
    .custom-tooltip > i {
        color: <?=$company['company_templates']['key_color']?> !important;
    }
</style>
<!-- end cookieBanner -->
<!-- Favicon -->
<?php

	if(is_dir(__DIR__ . '/../img/fav')) {
		?>
		<link rel="apple-touch-icon" sizes="60x60"
		      href="<?=$_ENV['BASE_PATH']?>/templates/<?=$template?>/img/fav/apple-icon-60x60.png">
		<link rel="apple-touch-icon" sizes="72x72"
		      href="<?=$_ENV['BASE_PATH']?>/templates/<?=$template?>/img/fav/apple-icon-72x72.png">
		<link rel="apple-touch-icon" sizes="76x76"
		      href="<?=$_ENV['BASE_PATH']?>/templates/<?=$template?>/img/fav/apple-icon-76x76.png">
		<link rel="apple-touch-icon" sizes="114x114"
		      href="<?=$_ENV['BASE_PATH']?>/templates/<?=$template?>/img/fav/apple-icon-114x114.png">
		<link rel="apple-touch-icon" sizes="120x120"
		      href="<?=$_ENV['BASE_PATH']?>/templates/<?=$template?>/img/fav/apple-icon-120x120.png">
		<link rel="apple-touch-icon" sizes="144x144"
		      href="<?=$_ENV['BASE_PATH']?>/templates/<?=$template?>/img/fav/apple-icon-144x144.png">
		<link rel="apple-touch-icon" sizes="152x152"
		      href="<?=$_ENV['BASE_PATH']?>/templates/<?=$template?>/img/fav/apple-icon-152x152.png">
		<link rel="apple-touch-icon" sizes="180x180"
		      href="<?=$_ENV['BASE_PATH']?>/templates/<?=$template?>/img/fav/apple-icon-180x180.png">
		<link rel="icon" type="image/png" sizes="192x192"
		      href="<?=$_ENV['BASE_PATH']?>/templates/<?=$template?>/img/fav/android-icon-192x192.png">
		<link rel="icon" type="image/png" sizes="32x32"
		      href="<?=$_ENV['BASE_PATH']?>/templates/<?=$template?>/img/fav/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="96x96"
		      href="<?=$_ENV['BASE_PATH']?>/templates/<?=$template?>/img/fav/favicon-96x96.png">
		<link rel="icon" type="image/png" sizes="16x16"
		      href="<?=$_ENV['BASE_PATH']?>/templates/<?=$template?>/img/fav/favicon-16x16.png">
		<link rel="manifest" href="<?=$_ENV['BASE_PATH']?>/templates/<?=$template?>/img/fav/manifest.json">
		<meta name="msapplication-TileImage"
		      content="<?=$_ENV['BASE_PATH']?>/templates/<?=$template?>/img/fav/ms-icon-144x144.png">
		<?php
	}
?>


<meta name="msapplication-TileColor" content="#ffffff">
<meta name="theme-color" content="#73CCE6">

<!-- Javascript -->
<script src="<?=$_ENV['BASE_PATH']?>/js/jquery-3.3.1.min.js"></script>
<script src="<?=$_ENV['BASE_PATH']?>/js/jquery-ui.min.js"></script>
<script src="<?=$_ENV['BASE_PATH']?>/js/jquery.touchSwipe.js"></script>
<script src="<?=$_ENV['BASE_PATH']?>/js/dropzone.js"></script>


<!--[if lt IE 8]>
<script src="<?=$_ENV['BASE_PATH']?>/templates/<?=$template?>/js/vendor/html5shiv.min.js"></script>
<![endif]-->

<!-- Styles -->
<link rel="stylesheet" type="text/css" href="<?=$_ENV['BASE_PATH']?>/templates/<?=$template?>/css/style.css?version=<?=VERSION?>">
<link rel="stylesheet" type="text/css" href="<?=$_ENV['BASE_PATH']?>/css/dropzone.css?version=<?=VERSION?>">
<link rel="stylesheet" type="text/css" href="<?=$_ENV['BASE_PATH']?>/css/jquery-ui.min.css?version=<?=VERSION?>">
<link rel="stylesheet" type="text/css" href="<?=$_ENV['BASE_PATH']?>/css/slider.css?version=<?=VERSION?>">


<!-- Facebook Pixel -->
<?php
	switch($company['id']){
		case 135:
?>
			<!-- Facebook Pixel Code -->

			<script>

                !function (f, b, e, v, n, t, s) {
                    if (f.fbq) return;
                    n = f.fbq = function () {
                        n.callMethod ?

                            n.callMethod.apply(n, arguments) : n.queue.push(arguments)
                    };

                    if (!f._fbq) f._fbq = n;
                    n.push = n;
                    n.loaded = !0;
                    n.version = '2.0';

                    n.queue = [];
                    t = b.createElement(e);
                    t.async = !0;

                    t.src = v;
                    s = b.getElementsByTagName(e)[0];

                    s.parentNode.insertBefore(t, s)
                }(window, document, 'script', 'https://connect.facebook.net/en_US/fbevents.js');

                fbq('init', '623007947859446');

                fbq('track', 'PageView');

			</script>

			<noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=623007947859446&ev=PageView&noscript=1"/></noscript>

			<!-- End Facebook Pixel Code -->
<?php
	}
