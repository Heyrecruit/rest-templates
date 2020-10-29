<?php
	$jobId      = null;
	$locationId = null;

	if(isset($_GET['job'])) {
		$jobId = $_GET['job'];
	} elseif(isset($_GET['id'])) {
		$jobId = $_GET['id'];
	}

	if(isset($_GET['location'])) {
		$locationId = $_GET['location'];
	} elseif(isset($_GET['companyLocationId'])) {
		$locationId = $_GET['companyLocationId'];
	}

	$applicantId = isset($_GET['applicant']) ? $_GET['applicant'] : null;

	$job = $scope->getJob($jobId, $locationId);


