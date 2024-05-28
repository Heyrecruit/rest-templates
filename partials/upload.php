<?php
	/** @var array $company */
	/** @var HeyUtility $utility */
	
	if(!isset($scope)) {
		include __DIR__ . '/../ini.php';
	}
	
	$files = $_SESSION['files'] ?? [];
	
	try {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			
			if(!empty($_GET['type']) && !empty($_GET['questionId'])) {
				
				$documentType = $_GET['type'];
				$fieldName    = $_GET['questionId'];
				
				$file = $utility->processUploadedFiles($documentType, $fieldName, $_FILES);
				
				if(!empty($file)) {
					$files[] = $file;
					$_SESSION['files'] = $files;
					
					$response = [
						'status' => 'success',
						'message' => 'The file has been uploaded successfully',
						'data' => $file,
					];
				}else{
					$response = [
						'status' => 'error',
						'message' => 'The file could not be uploaded',
					];
				}
				
				echo json_encode($response);
			}
		}
	} catch (Exception $e) {
		die('Es ist ein Fehler aufgetreten.');
	}