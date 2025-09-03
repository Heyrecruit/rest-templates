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
	          $url = "?page=job&id=" . $value['id'] . "&location=" . $v['company_location_id'] . "&language=" . HeyUtility::h($language);
?>
              <div class="row">
                  <div class="col-12">
                      <div class="job-tile" role="listitem">
                          <div class="job-info-wrap">
                              <a target="_blank" href="<?=$url?>"
                                 onclick="relatedJobClickEventListener(<?php echo htmlspecialchars(json_encode($value)); ?>)">
                                  <h2 class="primary-color"><?=HeyUtility::h($value['job_strings'][0]['title'])?></h2>
                              </a>
                              <div>
						          <?php
							          if (str_contains($company['overview_page']['job_table_categories'], 'location')) {
								          ?>
                                          <span>
                                                <?php
                                                    $formattedAddress = HeyUtility::getFormattedAddress(
                                                        $v, false, true, false
                                                    );
                
                                                    if (empty($formattedAddress)) {
                                                        $formattedAddress = HeyUtility::getFormattedAddress($v);
                                                    }
                
                                                    if (!empty($formattedAddress)) {
                                                        echo '<i class="fal fa-map-marker-alt"></i>' .
                                                            HeyUtility::h($formattedAddress);
                                                    }
                                                ?>
                                          </span>
								          <?php
							          }
							          if (str_contains($company['overview_page']['job_table_categories'], 'employment')) {
								          ?>
                                          <span>
                                                <?php
                                                    if (!empty($value['job_strings'][0]['employment'])) {
                                                        echo '<i class="fal fa-clock"></i>' . HeyUtility::h(
                                                                implode(', ',
                                                                    explode(',', $value['job_strings'][0]['employment'])
                                                                )
                                                            );
                                                    }
                                                ?>
                                           </span>
								          <?php
							          }
							
							          if (str_contains($company['overview_page']['job_table_categories'], 'department')) {
								          ?>
                                          <span>
                                              <?php
                                                  if (!empty($value['job_strings'][0]['department'])) {
                                                      echo '<i class="fal fa-hashtag"></i>' . HeyUtility::h(
                                                              trim($value['job_strings'][0]['department'])
                                                          );
                                                  }
                                              ?>
                                           </span>
								          <?php
							          }
						          ?>
                              </div>
                          </div>
                          <a class="btn btn-primary" target="_blank" href="<?=$url?>"
                             onclick="relatedJobClickEventListener(<?php echo htmlspecialchars(json_encode($value)); ?>)">
					          <?= $language != 'de' ? 'Details' : 'Zur Stellenanzeige' ?>
                          </a>
                      </div>
                  </div>
              </div>
<?php
	          $count++;
          }
      }
   }
}
}
