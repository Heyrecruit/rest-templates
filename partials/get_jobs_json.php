<?php
	if(!isset($scope)) {
		include __DIR__ . '/../ini.php';
	}

	$response = [
		'success' => false,
		'data' => null,
	];

	if(strpos($_SERVER["QUERY_STRING"], 'language') === false && isset($_GET['lng'])) {
		$_SERVER["QUERY_STRING"] .= '&language=' . $_GET['lng'];
	}

	$jobs = $scope->getJobs($company['Company']['id']);

	if($jobs['status_code'] == 200) {
		$response['data'] = $jobs['data'];
		$response['success'] = true;
	}else{
		$response = $jobs;
	}

	echo json_encode($response);
	die;
