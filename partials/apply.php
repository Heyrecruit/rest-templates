<?php
	/** @var array $company */
	/** @var HeyUtility $utility */
	
	if(!isset($scope)) {
		include __DIR__ . '/../ini.php';
	}
	
	try {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			
			$files = $_SESSION['files'] ?? [];
			$captcha = $_POST['re_captcha'] ?? null;
			
			$response = $utility->apply($_POST, $files, $captcha);
			
			echo json_encode($response['response']);
		}
	} catch (Exception $e) {
		die('Es ist ein Fehler aufgetreten.');
	}