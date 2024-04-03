<div class="container-fluid">
	<div class="row">
		<div class="col-12 col-sm-6">
            <?php

            $imprint = $company['imprint'];
            $data_protection = $company['data_protection'];

            $imprintLink = filter_var($imprint, FILTER_VALIDATE_URL) !== false;
            $dataProtectionLink = filter_var($data_protection, FILTER_VALIDATE_URL) !== false;

            if ($imprintLink !== true) {

                ?>
                <a href="#scope_impressum" class="primary-color scope_open_modal" data-toggle="modal"
                   data-target="#scope_impressum"><?= $company['language_id'] !== 1 ? 'Legal notice' : 'Impressum' ?></a>
            <?php } else { ?>
                <a href="<?=$company['imprint']?>" target="_blank" class="primary-color"><?= $company['language_id'] !== 1 ? 'Legal notice' : 'Impressum' ?></a>
            <?php } ?>

            <?php if ($dataProtectionLink !== true) { ?>
                <a href="#scope_datenschutz" class="primary-color scope_open_modal" data-toggle="modal"
                   data-target="#scope_impressum"><?= $company['language_id'] !== 1 ? 'Privacy policy' : 'Datenschutz' ?></a>
            <?php } else { ?>
                <a href="<?=$company['data_protection']?>" target="_blank" class="primary-color"><?= $company['language_id'] !== 1 ? 'Privacy policy' : 'Datenschutz' ?></a>
            <?php }  ?>
        </div>
		<div class="col-12 col-sm-6">
			<?php
				$scopeFooterTxt = $language === 'de' ? 'Heyrecruit – die All-in-one-Bewerbermanagement-Software' : 'Heyrecruit – the all-in-one applicant management software';
			?>
			<a href="http://www.heyrecruit.de" class="primary-color" target="_blank"><?=$scopeFooterTxt?></a>
		</div>
	</div>
</div>

<script src="https://www.google.com/recaptcha/api.js?render=<?=HeyUtility::env('RECAPTCHA_SITE_KEY')?>"></script>
<script src="<?=$_ENV['BASE_PATH']?>/templates/<?=$template?>/js/nav.js?version=<?=VERSION?>"></script>
<script src="<?=$_ENV['BASE_PATH']?>/templates/<?=$template?>/js/slide.js?version=<?=VERSION?>"></script>
<script src="<?=$_ENV['BASE_PATH']?>/js/template-base.js?version=<?=VERSION?>"></script>
<script src="<?=$_ENV['BASE_PATH']?>/js/jobs-map.js?version=<?=VERSION?>"></script>
<script src="<?=$_ENV['BASE_PATH']?>/js/add-applicant.js?version=<?=VERSION?>"></script>
<script src="<?=$_ENV['BASE_PATH']?>/js/upload-document.js?version=<?=VERSION?>"></script>
<!-- Block Google Fonts loaded by Google Maps -->
<script>
   let head = document.getElementsByTagName('head')[0];

   // Save the original method
   let insertBefore = head.insertBefore;

   // Replace it!
   head.insertBefore = function (newElement, referenceElement) {

      if (newElement.href && newElement.href.indexOf('https://fonts.googleapis.com/css?family=Roboto') === 0) {
         return;
      }

      insertBefore.call(head, newElement, referenceElement);
   };
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?=$_ENV['MAPS_API_KEY']?>"></script>
<script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js?version=<?=VERSION?>"></script>
<link rel="stylesheet" type="text/css" href="<?=$_ENV['BASE_PATH']?>/css/fa-pro-all.min.css">

