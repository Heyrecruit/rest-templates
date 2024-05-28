<?php
$createdDate = DateTime::createFromFormat('Y-m-d\TH:i:sP', $company['created']);
$createdDateFormatting = 'Y-m-d H:i:s';
$createdDateFormatted = $createdDate->format($createdDateFormatting);

$beforeUpdate = new DateTime('2024-04-05 16:00:00');
$checkDate = new DateTime($createdDateFormatted);

if (!empty($company['logo'])) {
    $logoCropped = $company['logo'];
    $logoUrlCropped = str_replace("/files/Companies/", "/images/files/Companies/", $logoCropped) . '?w=550&h=275&fit=fill';
}


if($page === 'job' && !empty($job)) {

    if(!empty($job['job_strings'][0]['description'])) {
        $description = $job['job_strings'][0]['description'];
    }else{
        if(!empty($job['job_strings'][0]['subtitle'])) {
            $description = $job['job_strings'][0]['subtitle'] . ' ' .
                $job['job_strings'][0]['title'];
        } else {
            $description = 'Wir suchen ab sofort einen / eine ' .
                $job['job_strings'][0]['title'];
        }
    }

    ?>
    <meta name="description" content="<?=HeyUtility::h(strip_tags($description))?>"/>

    <!-- Facebook -->
    <?php if ($beforeUpdate > $checkDate) { ?>
        <meta property="og:url" content="https://<?=HeyUtility::h($company['company_setting']['rest_sub_domain'])?>.scope-recruiting.de/?page=job&id=<?=HeyUtility::h($jobId)?>&location=<?=HeyUtility::h($locationId)?>">
    <?php } else {?>
        <meta property="og:url" content="https://<?=HeyUtility::h($company['company_setting']['rest_sub_domain'])?>.heyrecruit.de/?page=job&id=<?=HeyUtility::h($jobId)?>&location=<?=HeyUtility::h($locationId)?>">
    <?php } ?>

    <meta property="og:type" content="website"/>
    <meta property="og:title" content="<?=HeyUtility::h(strip_tags($job['job_strings'][0]['title']))?> bei <?=HeyUtility::h(strip_tags($company['name']))?>"/>
    <meta property="og:description" content='<?=HeyUtility::h(strip_tags($description))?> '/>

    <?php

    $images = HeyUtility::getSectionElementImages($job);

    if (!empty($company['logo'])) { ?>
        <meta property="og:image" content="<?=HeyUtility::h($logoUrlCropped)?>"/>
    <?php } else {
        if (!empty($images)) {
            foreach ($images as $imageUrl) {
                ?>
                <meta property="og:image" content="<?=HeyUtility::h($imageUrl)?>"/>
                <?php
            }
        } else {
            if ($beforeUpdate > $checkDate) {
                echo '<meta property="og:image" content="https://www.scope-recruiting.de/img/scope_default_job_header_image.png"/>';
            } else {
                echo '<meta property="og:image" content="https://www.heyrecruit.de/img/scope_default_job_header_image.png"/>';
            }
        }
    }
    ?>

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <?php if ($beforeUpdate > $checkDate) { ?>
        <meta property="twitter:domain" content="<?=HeyUtility::h($company['company_setting']['rest_sub_domain'])?>.scope-recruiting.de">
        <meta property="twitter:url" content="https://<?=HeyUtility::h($company['company_setting']['rest_sub_domain'])?>.scope-recruiting.de/?page=job&id=<?=HeyUtility::h($jobId)?>&location=<?=HeyUtility::h($locationId)?>">
    <?php } else {?>
        <meta property="twitter:domain" content="<?=HeyUtility::h($company['company_setting']['rest_sub_domain'])?>.heyrecruit.de">
        <meta property="twitter:url" content="https://<?=HeyUtility::h($company['company_setting']['rest_sub_domain'])?>.heyrecruit.de/?page=job&id=<?=HeyUtility::h($jobId)?>&location=<?=HeyUtility::h($locationId)?>">
    <?php } ?>
    <meta name="twitter:title" content="<?=HeyUtility::h(strip_tags($job['job_strings'][0]['title']))?> bei <?=HeyUtility::h(strip_tags($company['name']))?>">
    <meta name="twitter:description" content="<?=HeyUtility::h(strip_tags($description))?>">
    <?php

    $images = HeyUtility::getSectionElementImages($job);

    if (!empty($company['logo'])) { ?>
        <meta name="twitter:image" content="<?=HeyUtility::h($logoUrlCropped)?>"/>
    <?php } else {
        if (!empty($images)) {
            foreach ($images as $imageUrl) {
                ?>
                <meta name="twitter:image" content="<?=HeyUtility::h($imageUrl)?>"/>
                <?php
            }
        } else {

            if ($beforeUpdate > $checkDate) {
                echo '<meta name="twitter:image" content="https://www.scope-recruiting.de/img/scope_default_job_header_image.png"/>';
            } else {
                echo '<meta name="twitter:image" content="https://www.heyrecruit.de/img/scope_default_job_header_image.png"/>';
            }

        }
    }
}

if ($page === 'jobs') { ?>

    <!-- Facebook -->
    <?php if ($beforeUpdate > $checkDate) { ?>
        <meta property="og:url" content="https://<?=HeyUtility::h($company['company_setting']['rest_sub_domain'])?>.scope-recruiting.de/">
    <?php } else {?>
        <meta property="og:url" content="https://<?=HeyUtility::h($company['company_setting']['rest_sub_domain'])?>.heyrecruit.de/">
    <?php } ?>

    <meta property="og:type" content="website"/>
    <meta property="og:title" content="<?=HeyUtility::h(strip_tags($meta['title']))?>">

    <?php if (!empty($company['overview_page']['overview_page_strings'][0]['description'])) { ?>
        <meta property="og:description" content="<?=HeyUtility::h(strip_tags($company['overview_page']['overview_page_strings'][0]['description']))?>">
    <?php } else { ?>
        <meta property="og:description" content="<?=('Entdecke bei uns spannende Karrieremöglichkeiten und werde Teil von '. HeyUtility::h($company['name']))?>">
    <?php } ?>


    <?php if (!empty($company['logo'])) { ?>
        <meta property="og:image" content="<?=HeyUtility::h($logoUrlCropped)?>"/>
    <?php } else if(!empty($company['overview_header_picture'])) { ?>
        <meta property="og:image" content="<?=HeyUtility::h($company['overview_header_picture'])?>"/>
    <?php } else {?>
        <?php if ($beforeUpdate > $checkDate) { ?>
            <meta property="og:image" content="https://www.scope-recruiting.de/img/scope_default_job_header_image.png"/>
        <?php } else {?>
            <meta property="og:image" content="https://www.heyrecruit.de/img/scope_default_job_header_image.png"/>
        <?php }?>
    <?php } ?>


    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">

    <?php if ($beforeUpdate > $checkDate) { ?>
        <meta property="twitter:domain" content="<?=HeyUtility::h($company['company_setting']['rest_sub_domain'])?>.scope-recruiting.de">
        <meta property="twitter:url" content="https://<?=HeyUtility::h($company['company_setting']['rest_sub_domain'])?>.scope-recruiting.de/">
    <?php } else {?>
        <meta property="twitter:domain" content="<?=HeyUtility::h($company['company_setting']['rest_sub_domain'])?>.heyrecruit.de">
        <meta property="twitter:url" content="https://<?=HeyUtility::h($company['company_setting']['rest_sub_domain'])?>.heyrecruit.de/">
    <?php } ?>

    <meta name="twitter:title" content="<?=HeyUtility::h(strip_tags($meta['title']))?>">

    <?php if (!empty($company['overview_page']['overview_page_strings'][0]['description'])) { ?>
        <meta name="twitter:description" content="<?=HeyUtility::h(strip_tags($company['overview_page']['overview_page_strings'][0]['description']))?>">
    <?php } else { ?>
        <meta name="twitter:description" content="<?=('Entdecke bei uns spannende Karrieremöglichkeiten und werde Teil von der '. HeyUtility::h($company['name']))?>">
    <?php } ?>

    <?php if (!empty($company['logo'])) { ?>
        <meta name="twitter:image" content="<?=HeyUtility::h($logoUrlCropped)?>"/>
    <?php } else if(!empty($company['overview_header_picture'])) { ?>
        <meta name="twitter:image" content="<?=HeyUtility::h($company['overview_header_picture'])?>"/>
    <?php } else {?>
        <?php if ($beforeUpdate > $checkDate) { ?>
            <meta name="twitter:image" content="https://www.scope-recruiting.de/img/scope_default_job_header_image.png"/>
        <?php } else {?>
            <meta name="twitter:image" content="https://www.heyrecruit.de/img/scope_default_job_header_image.png"/>
        <?php }?>
    <?php } ?>

    <!-- BASE-TAGS -->

    <?php if (!empty($company['overview_page']['overview_page_strings'][0]['description'])) { ?>
        <meta name="description" content="<?=HeyUtility::h(strip_tags($company['overview_page']['overview_page_strings'][0]['description']))?>">
    <?php } else { ?>
        <meta name="description" content="<?=('Entdecke bei uns spannende Karrieremöglichkeiten und werde Teil von der '. HeyUtility::h($company['name']))?>">
    <?php } ?>
    <?php
}
?>

<meta name="author" content="Heyrecruit">
<meta name="copyright" content="Heyrecruit <?=date('Y')?>">
<meta name="keywords" content="<?=strip_tags('Stellenangebote bei '.HeyUtility::h($company['name']).', '.HeyUtility::h($company['name']).' Jobs, Offene Stellen bei ' .HeyUtility::h($company['name']))?>">
<meta name="viewport" content="width=device-width">
<meta name="apple-mobile-web-app-capable" content="yes">
