<?php
/** @var array $company */
/** @var string $language */
/** @var HeyUtility $utility */

if(!isset($scope)) {
    include __DIR__ . '/../../../ini.php';
}

if(!isset($jobs)) {
	try {
		$filter = $filter ?? $_SERVER['QUERY_STRING'];
		$jobs   = $utility->getJobs($filter);
	} catch (Exception $e) {
		die('Error while loading jobs.');
	}
}

$count = 1;
if(!empty($jobs)) {
 
	foreach ($jobs['jobs'] as $key => $value) {
		
		if (!empty($value['company_location_jobs'])) {
			
			foreach ($value['company_location_jobs'] as $k => $v) {
				if(!isset($limit) || ($count <= $limit)) {
     
					$url = "?page=job&id=" . $value['id'] . "&location=" . $v['company_location_id'];// . "&language=" . HeyUtility::h($language);
					require(CURRENT_ELEMENT_PATH . "jobs_table_row.php");
					$count++;
				}
			}
		}
	}
}
