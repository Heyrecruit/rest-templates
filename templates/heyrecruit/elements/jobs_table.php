<?php

if (!isset($scope)) {
    include __DIR__ . '/../../../ini.php';
}

if (!isset($jobs)) {
    $jobs = $scope->getJobs($company['Company']['id']);

    if ($jobs['status_code'] == 200) {
        $jobs = $jobs['data'];
    }
}

if (isset($moreJobsSection)) {
   $currentJobId = $job['Job']['id'];
   $currentJobDepartment = $job['Job']['department'];
   $jobsInSameDepartment = false;

   foreach ($jobs as $key => $value) {
      if (!empty($value['CompanyLocationJob']) AND $value['Job']['id'] !== $currentJobId AND $value['Job']['department'] === $currentJobDepartment) {
         $jobsInSameDepartment = true;
      }
   }
}

$i = 0;

foreach ($jobs as $key => $value) {
   if (!empty($value['CompanyLocationJob']) AND (!isset($moreJobsSection) OR (isset($moreJobsSection) AND $value['Job']['id'] !== $currentJobId AND (($jobsInSameDepartment AND $value['Job']['department'] === $currentJobDepartment) OR !$jobsInSameDepartment) AND $i < 5))) {
      foreach ($value['CompanyLocationJob'] as $k => $v) {
         ?>
         <div class="row">
            <div class="col-12">
               <div class="job-tile">
                  <div class="job-info-wrap">
                     <a target="_blank" href="?page=job&id=<?= $value['Job']['id'] ?>&location=<?= $v['company_location_id'] ?>&language=<?= $language ?>"><h2 class="primary-color"><?= $value['Job']['title'] ?></h2></a>
                     <div>
                        <?php
                        if (strpos($company['OverviewPage']['job_table_categories'], 'location') !== false) {
                           ?>
                           <span>
                             <?php
                             $formattedAddress = $scope->getFormattedAddress($v, false, true, false);

                             if (empty($formattedAddress)) {
                                $formattedAddress = $scope->getFormattedAddress($v, true, true, true);
                             }

                             if ($formattedAddress != "") {
                                echo '<i class="fal fa-map-marker-alt"></i>' . $formattedAddress;
                             }
                             ?>
                         </span>
                           <?php
                        }
                        if (strpos($company['OverviewPage']['job_table_categories'], 'employment') !== false) {
                           ?>
                           <span>
                             <?php
                             if ($value['Job']['employment'] != "") {
                                if (strpos($value['Job']['employment'], ',') !== false) {
                                   echo '<i class="fal fa-clock"></i>' . implode(', ', explode(',', $value['Job']['employment']));
                                } else {
                                   echo '<i class="fal fa-clock"></i>' . $value['Job']['employment'];
                                }
                             }
                             ?>
                         </span>
                           <?php
                        }
                        if (strpos($company['OverviewPage']['job_table_categories'], 'department') !== false) {
                           ?>
                           <span>
                             <?php
                             if ($value['Job']['department'] != "") {
                                echo '<i class="fal fa-hashtag"></i>' . $value['Job']['department'];
                             }
                             ?>
                         </span>
                           <?php
                        }
                        ?>
                     </div>
                  </div>
                  <a class="btn btn-primary" target="_blank" href="?page=job&id=<?= $value['Job']['id'] ?>&location=<?= $v['company_location_id'] ?>&language=<?= $language ?>"><?= $language != 'de' ? 'Details' : 'Zur Stellenanzeige' ?></a>
               </div>
            </div>
         </div>
         <?php
         $i++;
      }
   }
}



/*$jobsExist = false;

foreach ($jobs as $key => $value) {
   if (!empty($value['CompanyLocationJob']) AND (!isset($moreJobsSection) OR ($job['Job']['id'] != $value['Job']['id'] and $value['Job']['department'] === $job['Job']['department']))) {
      $jobsExist = true;
   }
}



$i = 0;*/

/*foreach ($jobs as $key => $value) {
   if (!empty($value['CompanyLocationJob']) AND ($i < 5 AND $jobsExist AND $job['Job']['id'] != $value['Job']['id'] AND ((isset($moreJobsSection) AND $value['Job']['department'] === $job['Job']['department']) OR (!$jobsExist) OR !isset($moreJobsSection)))) {

   }

   $i++;
}*/
