<div class="container-fluid">
	<div class="row">
		<div class="col-12 col-sm-6">
			<?php
				$imprint = $language === 'de' ? 'Impressum' : 'Legal notice';
				$privacy = $language === 'de' ? 'Datenschutz' : 'Privacy';
			?>
			<a href="#scope_impressum" class="primary-color scope_open_modal" data-toggle="modal" data-target="#scope_impressum"><?=$imprint?></a>
			<a href="#scope_datenschutz" class="primary-color scope_open_modal" data-toggle="modal" data-target="#scope_impressum"><?=$privacy?></a>
		</div>
		<div class="col-12 col-sm-6">
			<?php
				$scopeFooterTxt = $language === 'de' ? 'Heyrecruit – die All-in-one-Bewerbermanagement-Software' : 'Heyrecruit – the all-in-one applicant management software';
			?>
			<a href="http://www.scope-recruiting.de" class="primary-color" target="_blank"><?=$scopeFooterTxt?></a>
		</div>
	</div>
</div>

<script src="<?=$_ENV['BASE_PATH']?>/templates/<?=$template?>/js/nav.js?version=<?=VERSION?>"></script>
<script src="<?=$_ENV['BASE_PATH']?>/templates/<?=$template?>/js/slide.js?version=<?=VERSION?>"></script>

<script src="<?=$_ENV['BASE_PATH']?>/js/template-base.js?version=<?=VERSION?>"></script>

<script src="<?=$_ENV['BASE_PATH']?>/templates/<?=$template?>/js/reset-form-data.js?version=<?=VERSION?>"></script>
<script src="<?=$_ENV['BASE_PATH']?>/js/jobs-map.js?version=<?=VERSION?>"></script>
<script src="<?=$_ENV['BASE_PATH']?>/js/add-applicant.js?version=<?=VERSION?>"></script>
<script src="<?=$_ENV['BASE_PATH']?>/js/upload-document.js?version=<?=VERSION?>"></script>
<script src="<?=$_ENV['BASE_PATH']?>/templates/<?=$template?>/js/google-translation.js?version=<?=VERSION?>"></script>

<script src="https://maps.googleapis.com/maps/api/js?key=<?=$_ENV['MAPS_API_KEY']?>"></script>
<script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js?version=<?=VERSION?>"></script>
<link rel="stylesheet" type="text/css" href="<?=$_ENV['BASE_PATH']?>/css/fa-pro-all.min.css">

