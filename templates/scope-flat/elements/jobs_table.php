<?php
/** @var array $company */
/** @var string $language */
/** @var HeyUtility $utility */

if (!isset($scope)) {
    include __DIR__ . '/../../../ini.php';
}

if (!isset($jobs)) {
    try {
        $filter = $filter ?? $_SERVER['QUERY_STRING'];
        $jobs = $utility->getJobs($filter);
    } catch (Exception $e) {
        die('Error while loading jobs.');
    }
}
$ariaLabelCompanyJobsList = $language != 'de' ? 'List jobs' : 'Liste Stellenanzeigen';

?>
<div id="scope-jobs-table-desktop-wrap" role="region" aria-label="<?=$ariaLabelCompanyJobsList?>">
    <div class="row">
        <div class="col-12">
            <table id="scope-jobs-table-desktop">
                <thead>
                <tr>
                    <th>Offene Stellen</th>

                    <th>
                        <?php
                            if (str_contains($company['overview_page']['job_table_categories'], 'location')) {
                        ?>
                            Standort
                        <?php
                            }
                        ?>

                    </th>

                    <th>
                        <?php
                            if (str_contains($company['overview_page']['job_table_categories'], 'employment')) {
                        ?>
                            Einstellungsart
                        <?php
                            }
                        ?>
                    </th>
                    <th>

                        <?php
                        if (str_contains($company['overview_page']['job_table_categories'], 'department')) {
                        ?>
                        Fachabteilung

                        <?php
                        }
                        ?>
                    </th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php
                if (!empty($jobs)) {
                    foreach ($jobs['jobs'] as $key => $value) {
                        if (!empty($value['company_location_jobs'])) {

                            foreach ($value['company_location_jobs'] as $k => $v) {

                                $url = "?page=job&id=" . $value['id'] . "&location=" . $v['company_location_id'];
                ?>

                                <tr>
                                    <td>
                                        <a title="<?= HeyUtility::h($value['job_strings'][0]['title']) ?>"
                                           href="<?= $url ?>" target="_blank"
                                           onclick="jobClickEventListener(<?php echo htmlspecialchars(json_encode($value)); ?>)"
                                           class="primary-color secondary-color-hover ">
                                            <?= HeyUtility::h($value['job_strings'][0]['title']) ?>
                                        </a>
                                    </td>
                                    <td>
                                        <?php
                                            if (str_contains($company['overview_page']['job_table_categories'], 'location')) {
                                        ?>

                                                <div>
                                                    <i class="fas fa-map-marker-alt primary-color"></i>
                                                    <span>
                                                        <?php
	                                                        $moreLocationsText = $language !== 'de' ? 'more' : ' weitere';
	                                                        
	                                                        $formattedAddress = HeyUtility::getFormattedAddress(
		                                                        $v, false, true, false, false
	                                                        );
	                                                        
	                                                        if (empty($formattedAddress)) {
		                                                        $formattedAddress = HeyUtility::getFormattedAddress($v);
	                                                        }
	                                                        
	                                                        if(count($value['company_location_jobs']) == 2){
		                                                        $formattedAddressTwo = HeyUtility::getFormattedAddress(
			                                                        $value['company_location_jobs'][1], false, true, false, false
		                                                        );
		                                                        
		                                                        if (empty($formattedAddressTwo)) {
			                                                        $formattedAddressTwo = HeyUtility::getFormattedAddress($value['company_location_jobs'][1]);
		                                                        }
		                                                        
		                                                        $formattedAddress .= ', ' . $formattedAddressTwo;
		                                                        
	                                                        }elseif(count($value['company_location_jobs']) > 2){
		                                                        $formattedAddress .= ', ' . (count($value['company_location_jobs'])-1) . ' ' .$moreLocationsText;
	                                                        }
	                                                        
	                                                        if (!empty($formattedAddress)) {
		                                                        echo HeyUtility::h($formattedAddress);
	                                                        }
                                                        ?>
                                                    </span>
                                                </div>
                                        <?php
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if (str_contains($company['overview_page']['job_table_categories'], 'employment')) {
                                            ?>
                                            <div>
                                                <i class="far fa-clock primary-color"></i>
                                                <span>
                                                    <?php
                                                    if (!empty($value['job_strings'][0]['employment'])) {
                                                        echo HeyUtility::h(
                                                            implode(', ',
                                                                explode(',', $value['job_strings'][0]['employment'])
                                                            )
                                                        );
                                                    }
                                                    ?>
                                                </span>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                    <td class="employment-td">
                                        <?php
                                        if (str_contains($company['overview_page']['job_table_categories'], 'department')) {
                                            ?>
                                            <div>
                                        <span>
                                         <?php
                                         if (!empty($value['job_strings'][0]['department'])) {
                                             echo '<i class="fal fa-hashtag primary-color"></i>' . HeyUtility::h(
                                                     trim($value['job_strings'][0]['department'])
                                                 );
                                         }
                                         ?>
                                        </span>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <a href="<?= $url ?>" target="_blank"
                                           onclick="jobClickEventListener(<?php echo htmlspecialchars(json_encode($value)); ?>)">

                                            <i class="fas fa-chevron-right primary-color"></i>
                                        </a>
                                    </td>
                                </tr>
                <?php
                                break;
                            
                            }
                        }
                    }
                }
                ?>

                </tbody>
            </table>
            <?php
	            require(ELEMENT_PATH_ROOT . "pagination.php");
            ?>
        </div>
    </div>
</div>

<div class="pb-3">

    <div id="scope-jobs-table-mobile-wrap" role="list" aria-label="<?=$ariaLabelCompanyJobsList?>">
        <div class="row">

            <?php
            if (!empty($jobs)) {
                foreach ($jobs['jobs'] as $key => $value) {

                    if (!empty($value['company_location_jobs'])) {

                        foreach ($value['company_location_jobs'] as $k => $v) {

                            $url = "?page=job&id=" . $value['id'] . "&location=" . $v['company_location_id'];
           ?>

                            <div class="col-12 col-md-6" role="listitem" aria-label="<?= HeyUtility::h($value['job_strings'][0]['title']) ?>">

                                <table class="scope-jobs-table-mobile">
                                    <tbody>
                                    <tr>
                                        <td>
                                            <a href="<?= $url ?>" target="_blank" class="primary-color"
                                               onclick="jobClickEventListener(<?php echo htmlspecialchars(json_encode($value)); ?>)">

                                                <?= HeyUtility::h($value['job_strings'][0]['title']) ?>
                                            </a>
                                        </td>
                                        <td class="scope-jobs-table-mobile-angle" rowspan="4">
                                            <a href="<?= $url ?>" target="_blank"
                                               onclick="jobClickEventListener(<?php echo htmlspecialchars(json_encode($value)); ?>)">

                                                <i class="fas fa-chevron-right primary-color"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <?php
                                            if (str_contains($company['overview_page']['job_table_categories'], 'location')) {
                                                ?>
                                                <div>
                                                    <i class="fas fa-map-marker-alt primary-color"></i>
                                                    <span>
                                                      <?php
                                                          $moreLocationsText = $language !== 'de' ? 'more' : ' weitere';
                                                          
                                                          $formattedAddress = HeyUtility::getFormattedAddress(
                                                              $v, false, true, false, false
                                                          );
                                                          
                                                          if (empty($formattedAddress)) {
                                                              $formattedAddress = HeyUtility::getFormattedAddress($v);
                                                          }
                                                          
                                                          if(count($value['company_location_jobs']) == 2){
                                                              $formattedAddressTwo = HeyUtility::getFormattedAddress(
                                                                  $value['company_location_jobs'][1], false, true, false, false
                                                              );
                                                              
                                                              if (empty($formattedAddressTwo)) {
                                                                  $formattedAddressTwo = HeyUtility::getFormattedAddress($value['company_location_jobs'][1]);
                                                              }
                                                              
                                                              $formattedAddress .= ', ' . $formattedAddressTwo;
                                                              
                                                          }elseif(count($value['company_location_jobs']) > 2){
                                                              $formattedAddress .= ', ' . (count($value['company_location_jobs'])-1) . ' ' .$moreLocationsText;
                                                          }
                                                          
                                                          if (!empty($formattedAddress)) {
                                                              echo '<i class="fal fa-map-marker-alt"></i>' .
                                                                  HeyUtility::h($formattedAddress);
                                                          }
                                                      ?>
                                                </span>
                                                </div>
                                                <?php
                                            } ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <?php
                                            if (str_contains($company['overview_page']['job_table_categories'], 'employment')) {
                                                ?>
                                                <div>
                                                    <i class="far fa-clock primary-color"></i>
                                                    <span>
                                        <?php
                                        if (!empty($value['job_strings'][0]['employment'])) {
                                            echo HeyUtility::h(
                                                implode(', ',
                                                    explode(',', $value['job_strings'][0]['employment'])
                                                )
                                            );
                                        }
                                        ?>
                                    </span>
                                                </div>
                                                <?php
                                            } ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <?php
                                            if (str_contains($company['overview_page']['job_table_categories'], 'department')) {
                                                ?>
                                                <div>
                                    <span>
                                         <?php
                                         if (!empty($value['job_strings'][0]['department'])) {
                                             echo '<i class="fal fa-hashtag primary-color"></i>' . HeyUtility::h(trim($value['job_strings'][0]['department'])
                                                 );
                                         }
                                         ?>
                                    </span>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>
	                          
                            </div>
           <?php
                            break;
                        }
                    }
                }
            }
           ?>
	        
	        <?php
		        require(ELEMENT_PATH_ROOT . "pagination.php");
	        ?>
        </div>
    </div>
</div>
