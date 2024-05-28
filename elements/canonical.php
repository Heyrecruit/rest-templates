<?php

$jobId      = HeyUtility::getJobId($_GET);
$locationId = HeyUtility::getLocationId($_GET);

$createdDate = DateTime::createFromFormat('Y-m-d\TH:i:sP', $company['created']);
$createdDateFormatting = 'Y-m-d H:i:s';
$createdDateFormatted = $createdDate->format($createdDateFormatting);

$beforeUpdate = new DateTime('2024-04-05 16:00:00');
$checkDate = new DateTime($createdDateFormatted);

if ($page === 'jobs') {
    if ($beforeUpdate > $checkDate) {
        echo '<link rel="canonical" href="https://' . HeyUtility::h($company['company_setting']['rest_sub_domain']) . '.scope-recruiting.de/" />';
    } else {
        echo '<link rel="canonical" href="https://' . HeyUtility::h($company['company_setting']['rest_sub_domain']) . '.heyrecruit.de/" />';
    }
}
if($page === 'job' && !empty($job)) {
    if ($beforeUpdate > $checkDate) {
        echo '<link rel="canonical" href="https://' . HeyUtility::h($company['company_setting']['rest_sub_domain']) . '.scope-recruiting.de/?page=job&id='.HeyUtility::h($jobId).'&location='.HeyUtility::h($locationId).'" />';
    } else {
        echo '<link rel="canonical" href="https://' . HeyUtility::h($company['company_setting']['rest_sub_domain']) . '.heyrecruit.de/?page=job&id='.HeyUtility::h($jobId).'&location='.HeyUtility::h($locationId).'" />';
    }
}
if($page === 'danke') {
    if ($beforeUpdate > $checkDate) {
        echo '<link rel="canonical" href="https://' . HeyUtility::h($company['company_setting']['rest_sub_domain']) . '.scope-recruiting.de/?page=danke&id='.HeyUtility::h($jobId).'&location='.HeyUtility::h($locationId).'" />';
    } else {
        echo '<link rel="canonical" href="https://' . HeyUtility::h($company['company_setting']['rest_sub_domain']) . '.heyrecruit.de/?page=danke&id='.HeyUtility::h($jobId).'&location='.HeyUtility::h($locationId).'" />';
    }
}

?>

