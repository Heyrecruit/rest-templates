<?php

	error_reporting(E_ALL);
	ini_set('display_errors', true);

	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}

	require_once 'HeyUtility.php';

	require_once __DIR__ . '/vendor/autoload.php';

	$dotenv = Dotenv\Dotenv::create(__DIR__);
	$dotenv->load();

	$utility = new HeyUtility($_ENV);

	if (!$_ENV['DEBUG']) {
		error_reporting(0);
		@ini_set('display_errors', 0);
	}

	$cookieBanner = $_ENV['COOKIE_BANNER'] ?? false;

	$scope    = $utility->getScope();
    $template = $utility->getTemplateFolder();

	$company  = $utility->getCompany();

	$scope->setFilter($_SERVER['QUERY_STRING']);

	$allowedOverviewPageGetParams = [
		'filter', 'job_table_categories', 'show_description', 'show_map',
		'show_table_header', 'stand_alone_site', 'has_contact_section',
		'show_contact', 'show_social_links', 'show_company_infos', 'redirect_url'
	];

	$company['overview_page'] = HeyUtility::updateArrayWithGetParams(
		$company['overview_page'],
		$_GET,
		$allowedOverviewPageGetParams
	);

	$utility->defineConstants($template);

	$language = $_GET['language'] ?? $company['languages']['shortcodes'][$company['language_id']];

	if(!in_array($language, $company['languages']['shortcodes'])){
		$language = null;
	}

	if (!is_dir(CURRENT_TEMPLATE_PATH)) {
		die('Template not found.');
	}

    $fallbackDataProtectionModal = './templates/fallback_data_protection_modal.php';