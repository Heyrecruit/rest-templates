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

$count = 1;

?>
<div id="scope-jobs-table-desktop-wrap">
    <div class="row">
        <div class="col-12">
            <table id="scope-jobs-table-desktop">
                <thead>
                <tr>
                    <th>Offene Stellen</th>
                    <th>Standort</th>
                    <th>Einstellungsart</th>
                    <th>Fachabteilung</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php
                if (!empty($jobs)) {
                    foreach ($jobs['jobs'] as $key => $value) {
                        if (!empty($value['company_location_jobs'])) {

                            foreach ($value['company_location_jobs'] as $k => $v) {

                                if (!isset($limit) || ($count <= $limit)) {
                                    $url = "?page=job&id=" . $value['id'] . "&location=" . $v['company_location_id'] . "&language=" . HeyUtility::h($language);
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
                                                                $formattedAddress = HeyUtility::getFormattedAddress(
                                                                    $v, false, true, false
                                                                );

                                                                if (empty($formattedAddress)) {
                                                                    $formattedAddress = HeyUtility::getFormattedAddress($v);
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
                                        <td>
                                            <?php
                                            if (str_contains($company['overview_page']['job_table_categories'], 'department')) {
                                                ?>
                                                <div>
                                            <span>
                                             <?php
                                             if (!empty($value['job_strings'][0]['department'])) {
                                                 echo '<i class="fal fa-hashtag"></i>' . HeyUtility::h(
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
                                    $count++;
                                }
                            }
                        }
                    }
                }
                ?>

                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="pb-3">

    <div id="scope-jobs-table-mobile-wrap">
        <div class="row">

            <?php
            if (!empty($jobs)) {
                foreach ($jobs['jobs'] as $key => $value) {

                    if (!empty($value['company_location_jobs'])) {

                        foreach ($value['company_location_jobs'] as $k => $v) {

                            if (!isset($limit) || ($count <= $limit)) {
                                $url = "?page=job&id=" . $value['id'] . "&location=" . $v['company_location_id'] . "&language=" . HeyUtility::h($language);
                                ?>

                                <div class="col-12 col-md-6">

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
                                              $formattedAddress = HeyUtility::getFormattedAddress(
                                                  $v, false, true, false
                                              );

                                              if (empty($formattedAddress)) {
                                                  $formattedAddress = HeyUtility::getFormattedAddress($v);
                                              }

                                              if (!empty($formattedAddress)) {
                                                  echo HeyUtility::h($formattedAddress);
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
                                                 echo '<i class="fal fa-hashtag"></i>' . HeyUtility::h(trim($value['job_strings'][0]['department'])
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
                                $count++;
                            }
                        }
                    }
                }
            }
            ?>
        </div>
    </div>
</div>
