<meta charset="utf-8">
<title><?php echo $meta['title']; ?></title>
<meta name="author" content="SCOPE Recruiting">
<meta name="copyright" content="SCOPE Recruiting 2019">
<meta name="keywords" content="E-Recruiting">
<meta name="description" content="Benutzerfreundliches Stellen- und Bewerbermanagement
für einen strukturierten Ablauf bei der Personalbeschaffung">
<meta name="viewport" content="width=device-width">
<meta name="apple-mobile-web-app-capable" content="yes">
<!-- start cookieBanner -->
<link rel="stylesheet" type="text/css" href="/css/cookieBanner.css">
<?php if(is_file($_ENV['BASE_PATH'] . '/templates/'.$template.'/css/cookieBanner.css')) { ?>
	<link rel="stylesheet" type="text/css" href="<?=$_ENV['BASE_PATH']?>/templates/<?=$template?>/css/cookieBanner.css">
<?php } ?>
<script src="/js/cookieBanner.js"></script>
<style>
	/* Set class to override the default CookieBanner */

	.cookie h1, .cookie h2, .cookie h3, span.info, .cookie .cookieModal .descrption .infoTrigger {
		color: <?=$company['CompanyTemplate']['key_color']?> !important;
	}

	.cookie .cookieModal .switch input:checked + .slider {
		background-color: <?=$company['CompanyTemplate']['key_color']?> !important;
	}

	.cookie .button.color {
		background: <?=$company['CompanyTemplate']['key_color']?> !important;
		border-color: <?=$company['CompanyTemplate']['key_color']?> !important;
	}

	.cookie .button.color:hover {
		background: white !important;
		color: <?=$company['CompanyTemplate']['key_color']?> !important;
	}

    .cookie p, .cookie td, .cookie a, .cookie span {
        font-size: 14px !important;
        line-height: 24px !important;
    }

    #scope_datenschutz a {
        color: <?=$company['CompanyTemplate']['key_color']?> !important;
    }
</style>
<!-- end cookieBanner -->
<!-- Favicon -->
<?php

	if(is_dir(__DIR__ . '/../img/fav')) {
?>
		<link rel="apple-touch-icon" sizes="60x60" href="<?=$_ENV['BASE_PATH']?>/templates/<?=$template?>/img/fav/apple-icon-60x60.png">
		<link rel="apple-touch-icon" sizes="72x72" href="<?=$_ENV['BASE_PATH']?>/templates/<?=$template?>/img/fav/apple-icon-72x72.png">
		<link rel="apple-touch-icon" sizes="76x76" href="<?=$_ENV['BASE_PATH']?>/templates/<?=$template?>/img/fav/apple-icon-76x76.png">
		<link rel="apple-touch-icon" sizes="114x114" href="<?=$_ENV['BASE_PATH']?>/templates/<?=$template?>/img/fav/apple-icon-114x114.png">
		<link rel="apple-touch-icon" sizes="120x120" href="<?=$_ENV['BASE_PATH']?>/templates/<?=$template?>/img/fav/apple-icon-120x120.png">
		<link rel="apple-touch-icon" sizes="144x144" href="<?=$_ENV['BASE_PATH']?>/templates/<?=$template?>/img/fav/apple-icon-144x144.png">
		<link rel="apple-touch-icon" sizes="152x152" href="<?=$_ENV['BASE_PATH']?>/templates/<?=$template?>/img/fav/apple-icon-152x152.png">
		<link rel="apple-touch-icon" sizes="180x180" href="<?=$_ENV['BASE_PATH']?>/templates/<?=$template?>/img/fav/apple-icon-180x180.png">
		<link rel="icon" type="image/png" sizes="192x192" href="<?=$_ENV['BASE_PATH']?>/templates/<?=$template?>/img/fav/android-icon-192x192.png">
		<link rel="icon" type="image/png" sizes="32x32" href="<?=$_ENV['BASE_PATH']?>/templates/<?=$template?>/img/fav/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="96x96" href="<?=$_ENV['BASE_PATH']?>/templates/<?=$template?>/img/fav/favicon-96x96.png">
		<link rel="icon" type="image/png" sizes="16x16" href="<?=$_ENV['BASE_PATH']?>/templates/<?=$template?>/img/fav/favicon-16x16.png">
		<link rel="manifest" href="<?=$_ENV['BASE_PATH']?>/templates/<?=$template?>/img/fav/manifest.json">
		<meta name="msapplication-TileImage" content="<?=$_ENV['BASE_PATH']?>/templates/<?=$template?>/img/fav/ms-icon-144x144.png">
<?php
	}
?>

<?php
	if(isset($_GET['page']) && $_GET['page'] === 'job' && isset($job['status_code']) && $job['status_code'] === 200) {
?>
		<meta property="og:type" content="website"/>
		<meta property="og:title" content="<?=$job['data']['Job']['title']?>"/>
		<meta property="og:description" content='<?=$job['data']['Job']['description']?>'/>
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
<link rel="stylesheet" type="text/css" href="<?=$_ENV['BASE_PATH']?>/templates/<?=$template?>/css/style.css">
<link rel="stylesheet" type="text/css" href="<?=$_ENV['BASE_PATH']?>/css/dropzone.css">
<link rel="stylesheet" type="text/css" href="<?=$_ENV['BASE_PATH']?>/css/slider.css">
