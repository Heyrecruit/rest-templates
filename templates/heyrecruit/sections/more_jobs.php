<?php
	/** @var array $company */
	/** @var array $job */
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
	if(!empty($jobs['jobs'])) {

			$limit = 5;
			$currentJobId = $job['id'];
			$currentCompanyLocationId = $job['company_location_jobs'][0]['company_location_id'];
	        $openJobCount = 0;
            foreach ($jobs['jobs'] as $key => $value) {
            
                if (!empty($value['company_location_jobs'])) {
            
                    foreach ($value['company_location_jobs'] as $k => $v) {
	                    $openJobCount++;
                    }
                }
            }
		
			foreach ($jobs['jobs'] as $key => $value) {

				if (!empty($value['company_location_jobs'])) {
					
					foreach ($value['company_location_jobs'] as $k => $v) {
      
						if(!isset($limit) || ($count <= $limit)) {
							if(
								isset($currentJobId) &&
								isset($currentCompanyLocationId) &&
								$v['job_id'] === $currentJobId &&
								$v['company_location_id'] === $currentCompanyLocationId
							) {
								continue;
							}
							
                            if($count == 1) {
        ?>
                                <h2 class="primary-color">
		                            <?=$language !== 'de' ? 'More vacancies' : 'Weitere offene Stellen'?>
                                </h2>
        <?php
                            }
							
							$url = "?page=job&id=" . $value['id'] . "&location=" . $v['company_location_id'];// . "&language=" . HeyUtility::h($language);
							
                            require(CURRENT_ELEMENT_PATH . "jobs_table_row.php");
                            
							if($count >= $limit || $k+1 == $openJobCount) {
		?>
                                <button id="all-vacancies-button" class="btn btn-primary">
                                    <a href="/?page=jobs#cp-section-jobs">
										<?=$language !== 'de' ? 'All vacancies' : 'Alle offenen Stellen'?>
                                    </a>
                                </button>
		<?php
							}
							$count++;
						}
					}
				}
			}
		?>

<?php
	}
?>
