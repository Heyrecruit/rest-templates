<?php

	error_reporting(E_ALL);
	ini_set('display_errors', true);

	if(session_status() == PHP_SESSION_NONE) {
		session_start();
	}

	require_once __DIR__ . '/vendor/autoload.php';

	use \ScopeRecruiting\ScopeRestApi;

	define('DS', '/');

	// Read .env config file
	$dotenv = Dotenv\Dotenv::create(__DIR__);
	$dotenv->load();

	if(!$_ENV['DEBUG']) {
		error_reporting(0);
		@ini_set('display_errors', 0);
	}

	$scope = new ScopeRestApi($_ENV);

	$pageURL = 'http';
	if($_SERVER["HTTPS"] == "on") {
		$pageURL .= "s";
	}

	if(isset($_SERVER["HTTP_HOST"])) {
		$pageURL .= "://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
	} else {
		$pageURL .= "://" . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
	}

	$referrer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $pageURL;

	if(!isset($_SESSION['referrer']) || strtolower(parse_url($referrer, PHP_URL_HOST)) != strtolower($_SERVER['HTTP_HOST'])) {
		$_SESSION['referrer'] = $referrer;
	}

	if(strpos($_SERVER["QUERY_STRING"], 'language') === false && isset($_GET['lng'])) {
		$_SERVER["QUERY_STRING"] .= '&language=' . $_GET['lng'];
	}

	$scope->setReferrer($_SESSION['referrer']);

	if($scope->analytics['active']) {
		$scope->setAnalyticsCookie();
	}

	$scope->setFilter($_SERVER["QUERY_STRING"]);

	$url = $_SERVER['HTTP_HOST'];

    $subDomain = explode('.', $_SERVER['HTTP_HOST'])[0];

    $company = $scope->getCompanyBySubDomain($subDomain);

    if($company['status_code'] !== 200) {
        $company = $scope->getCompany($_ENV['SCOPE_CLIENT_ID']);
    }

    if($company['status_code'] !== 200){
        die($company['error']['message']);
    }

    $authData = $scope->getAuthData();
    $company  = $company['data'];
    $googleTagManager = $scope->getGoogleTagCode($company['CompanySetting']['google_tag_public_id']);


    $template = $company['Company']['template_folder'];
	$template = 'pima';

    define("TEMPLATE_PATH", $_SERVER['DOCUMENT_ROOT'] . $_ENV['BASE_PATH'] . DS . 'templates' . DS . $template. DS);
    define("SECTION_PATH", TEMPLATE_PATH . 'sections' . DS);
    define("PAGE_PATH", TEMPLATE_PATH  . 'pages' . DS);
    define("ELEMENT_PATH", TEMPLATE_PATH . 'elements' . DS);

	$language = isset($_GET['language']) ? $_GET['language'] : 'de';

	if(!is_dir(__DIR__ . '/templates/' . $template)){
		die('Template not found.');
	}

