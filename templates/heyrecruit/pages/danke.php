<?php
$bgUrl = 'https://www.scope-recruiting.de/img/scope_default_job_header_image.png';
$logoUrl = '';

if (!empty($company) && isset($company['Company']['overview_header_picture'])) {
   $bgUrl = $company['Company']['overview_header_picture'];
}

if (!empty($company) && isset($company['Company']['logo_big'])) {
   $logoUrl = $company['Company']['logo_big'];
}
?>

<main id="ty-main">
   <img id="ty-background" src="<?= $bgUrl ?>" alt="">
   <section>
      <div id="logo">
         <img src="<?= $logoUrl ?>" alt="<?= $company['Company']['name'] ?> Logo">
      </div>
      <h1>Vielen Dank, die Bewerbung war erfolgreich!</h1>
      <h2>Wir werden uns schnellstmöglich melden.</h2>
      <a class="btn btn-primary" href="/">Zur Karriereseite</a>
   </section>
</main>