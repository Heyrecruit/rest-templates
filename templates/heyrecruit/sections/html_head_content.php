<?php
    /** @var array $meta */
    /** @var string $page */
    /** @var string $template */
    /** @var array $job */
    /** @var array $fonts */
    /** @var array $company */
?>
<meta charset="utf-8">
<title><?=strip_tags($meta['title'])?></title>
<?php
	if($page === 'job' && !empty($job)) {
    
        if(!empty($job['job_strings'][0]['description'])) {
	        $description = $job['job_strings'][0]['description'];
        }else{
            $description = $job['job_strings'][0]['subtitle'] . ' ' .
                $job['job_strings'][0]['title'];
        }
?>
		<meta name="description" content="<?=strip_tags($description)?>"/>
		<meta property="og:type" content="website"/>
		<meta property="og:title" content="<?=strip_tags($job['job_strings'][0]['title'])?>"/>
		<meta property="og:description" content='<?=strip_tags($description)?>'/>
<?php
        
        $images = HeyUtility::getSectionElementImages($job);
        
        if (!empty($images)) {
            foreach ($images as $imageUrl) {
?>
            <meta property="og:image" content="<?=strip_tags($imageUrl)?>"/>
<?php
		    }
	    }
	}
	
	if ($page === 'jobs' && !empty($company['overview_header_picture'])) {
?>
        <meta property="og:image" content="<?=strip_tags($company['overview_header_picture'])?>"/>
<?php
	}
?>

<meta name="author" content="Heyrecruit">
<meta name="copyright" content="Heyrecruit 2022">
<meta name="keywords" content="E-Recruiting">
<meta name="viewport" content="width=device-width">
<meta name="apple-mobile-web-app-capable" content="yes">

<?php
    include ELEMENT_PATH_ROOT . "canonical.php";
?>

<link rel="stylesheet" type="text/css" href="/css/cookieBanner.css?version=<?=VERSION?>">
<?php
    $basePath = !empty($_ENV['BASE_PATH']) ? $_ENV['BASE_PATH'] : __DIR__;
    if(is_file($basePath . '/templates/'. $template . '/css/cookieBanner.css')) {
?>
	    <link rel="stylesheet" type="text/css"
              href="<?=$_ENV['BASE_PATH']?>/templates/<?=$template?>/css/cookieBanner.css?version=<?=VERSION?>">
<?php
    }

	include $_ENV['BASE_PATH'] . 'partials/load_custom_font.php';
?>

<script src="/js/cookieBanner.js?version=<?=VERSION?>"></script>
<style>
  body {
      font-family: '<?=$fonts[$company['company_templates']['template_font']]?>' , sans-serif;
  }

	/* Set class to override the default CookieBanner */

	.cookie h1, .cookie h2, .cookie h3, span.info, .cookie .cookieModal .descrption .infoTrigger {
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

	.error {
		color: <?=$company['company_templates']['key_color']?> !important;
	}

    .cookie p, .cookie td, .cookie a, .cookie span {
        font-size: 14px !important;
        line-height: 24px !important;
    }
</style>
<!-- end cookieBanner -->
<!-- Favicon -->
<?php

	if(is_dir(__DIR__ . '/../img/fav/heyrecruit')) {
?>
		<link rel="apple-touch-icon" sizes="60x60" href="<?=$_ENV['BASE_PATH']?>/templates/<?=$template?>/img/fav/heyrecruit/heapple-icon-60x60.png">
		<link rel="apple-touch-icon" sizes="72x72" href="<?=$_ENV['BASE_PATH']?>/templates/<?=$template?>/img/fav/heyrecruit/apple-icon-72x72.png">
		<link rel="apple-touch-icon" sizes="76x76" href="<?=$_ENV['BASE_PATH']?>/templates/<?=$template?>/img/fav/heyrecruit/apple-icon-76x76.png">
		<link rel="apple-touch-icon" sizes="114x114" href="<?=$_ENV['BASE_PATH']?>/templates/<?=$template?>/img/fav/heyrecruit/apple-icon-114x114.png">
		<link rel="apple-touch-icon" sizes="120x120" href="<?=$_ENV['BASE_PATH']?>/templates/<?=$template?>/img/fav/heyrecruit/apple-icon-120x120.png">
		<link rel="apple-touch-icon" sizes="144x144" href="<?=$_ENV['BASE_PATH']?>/templates/<?=$template?>/img/fav/heyrecruit/apple-icon-144x144.png">
		<link rel="apple-touch-icon" sizes="152x152" href="<?=$_ENV['BASE_PATH']?>/templates/<?=$template?>/img/fav/heyrecruit/apple-icon-152x152.png">
		<link rel="apple-touch-icon" sizes="180x180" href="<?=$_ENV['BASE_PATH']?>/templates/<?=$template?>/img/fav/heyrecruit/apple-icon-180x180.png">
		<link rel="icon" type="image/png" sizes="192x192" href="<?=$_ENV['BASE_PATH']?>/templates/<?=$template?>/img/fav/heyrecruit/android-icon-192x192.png">
		<link rel="icon" type="image/png" sizes="32x32" href="<?=$_ENV['BASE_PATH']?>/templates/<?=$template?>/img/fav/heyrecruit/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="96x96" href="<?=$_ENV['BASE_PATH']?>/templates/<?=$template?>/img/fav/heyrecruit/favicon-96x96.png">
		<link rel="icon" type="image/png" sizes="16x16" href="<?=$_ENV['BASE_PATH']?>/templates/<?=$template?>/img/fav/heyrecruit/favicon-16x16.png">
		<link rel="manifest" href="<?=$_ENV['BASE_PATH']?>/templates/<?=$template?>/img/fav/heyrecruit/manifest.json">
		<meta name="msapplication-TileImage" content="<?=$_ENV['BASE_PATH']?>/templates/<?=$template?>/img/fav/heyrecruit/ms-icon-144x144.png">
<?php
	}
?>


<meta name="msapplication-TileColor" content="#ffffff">
<meta name="theme-color" content="<?=$company['company_templates']['key_color']?>">

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
