<?php
	/** @var array $company */
	
	if(!isset($scope)) {
		include __DIR__ . '/../ini.php';
	}
	
	try {
		$jobs = $scope->getJobs($company['id']);
	} catch (Exception $e) {
		die('Fehler beim Laden der Stellenanzeigen.');
	}

	echo json_encode($jobs);
	die;
