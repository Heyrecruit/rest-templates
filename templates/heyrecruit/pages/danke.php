<?php
$bgUrl = 'https://www.scope-recruiting.de/img/scope_default_job_header_image.png';
$logoUrl = '';

if (isset($company['overview_header_picture'])) {
   $bgUrl = $company['overview_header_picture'];
}

$logoUrl = $company['logo'];
?>

<main id="ty-main">
   <img id="ty-background" src="<?= $bgUrl ?>" alt="">
   <section>
      <div id="logo">
         <img src="<?= $logoUrl ?>" alt="<?= HeyUtility::h($company['name']) ?> Logo">
      </div>
      <h1>Vielen Dank, die Bewerbung war erfolgreich!</h1>
      <h2>Wir werden uns schnellstmöglich melden.</h2>
      <a class="btn btn-primary" href="/">Zur Karriereseite</a>
   </section>
</main>
<img src="https://www.talent.com/tracker/img-pixel.php?tracker=heyrecruit">
<iframe src="https://www.adzuna.de/app_complete/10750" scrolling="no" frameborder="0" width="1" height="1"></iframe>