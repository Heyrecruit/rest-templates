<?php
	/** @var array $company */
	/** @var HeyUtility $utility */
	
	if(!isset($scope)) {
		include __DIR__ . '/../ini.php';
	}
	
	$files = $_SESSION['files'] ?? [];
	
	try {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			
			$fileName = $_POST['name'];
			$fileType = $_POST['type'];
			
			if(!empty($files)) {
				
				foreach ($files as $key =>  $file) {
					if($file['name'] === $fileName && $file['type'] === $fileType) {
						unset($files[$key]);
					}
				}
				$_SESSION['files'] = $files;
				
				$response = [
					'status' => 'success',
					'message' => 'The file has been deleted successfully'
				];
			}else{
				$response = [
					'status' => 'error',
					'message' => 'The file could not be deleted',
				];
			}
			
			echo json_encode($response);
		}
	} catch (Exception $e) {
		die('Es ist ein Fehler aufgetreten.');
	}