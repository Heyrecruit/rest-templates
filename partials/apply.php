<?php
	/** @var array $company */
	/** @var HeyUtility $utility */
	
	if(!isset($scope)) {
		include __DIR__ . '/../ini.php';
	}
	
	try {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		
			$response = $utility->apply($_POST, $_POST['re_captcha'], $_SESSION['files'] ?? []);
			
			echo json_encode($response['response']);
		}
	} catch (Exception $e) {
		die('Es ist ein Fehler aufgetreten.');
	}