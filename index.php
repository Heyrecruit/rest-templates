<?php

	if(!isset($scope)) {
		include __DIR__ . '/ini.php';
	}

	$page = !isset($_GET['page']) ? 'jobs' : $_GET['page'];

	$page = strtolower(preg_replace("/[^a-zA-Z0-9_äüö-]/", "", $page));


	$metadata = [
		'jobs' => [
			'title'       => 'Karriere bei ' . $company['Company']['name'],
			'description' => 'Das Karriereportal der ' . $company['Company']['name'] . '. Alle offenen Stellen der ' . $company['Company']['name'] . ' auf einem Blick.'
		],
		'job'  => [
			'title'       => 'Karriere bei ' . $company['Company']['name'],
			'description' => 'Das Karriereportal der ' . $company['Company']['name'] . '. Alle offenen Stellen der ' . $company['Company']['name'] . ' auf einem Blick.'
		]
	];

	if(isset($metadata[$page]) && is_array($metadata[$page])) {
		$meta = $metadata[$page];
	} else {
		$meta = [
			'title'       => 'Karriereportal - ' . $company['Company']['name'],
			'description' => 'Geh deinen Weg mit uns'
		];
	}



	include __DIR__ . '/templates/' . $template . '/index.php';

