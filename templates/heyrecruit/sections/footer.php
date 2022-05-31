<div class="container">
    <div class="row">
        <div class="col-12">
            <nav>
                <a href="#scope_impressum" class="primary-color scope_open_modal" data-toggle="modal"
                   data-target="#scope_impressum"><?= $language != 'de' ? 'Legal notice' : 'Impressum' ?></a>
                <a href="#scope_datenschutz" class="primary-color scope_open_modal" data-toggle="modal"
                   data-target="#scope_impressum"><?= $language != 'de' ? 'Privacy policy' : 'Datenschutz' ?></a>
                <a href="javascript:void(0)" class="primary-color" id="openCookieInfoModal"><?= $language != 'de' ? 'Cookie settings' : 'Cookie-Einstellungen' ?></a>
            </nav>
            <span>
                    Powered by<a href="https://www.heyrecruit.de/" class="primary-color" target="_blank"><img
                            src="<?= $_ENV['BASE_PATH'] ?>/templates/<?= $template ?>/img/heyrecruit_logo.svg" alt="Heyrecruit-Logo"></a>
            </span>
        </div>
    </div>
</div>

<!--<div class="container-fluid">
	<div class="row">
		<div class="col-12 col-sm-6">
			<a href="#scope_impressum" class="primary-color scope_open_modal" data-toggle="modal" data-target="#scope_impressum">Impressum</a>
			<a href="#scope_datenschutz" class="primary-color scope_open_modal" data-toggle="modal" data-target="#scope_impressum">Datenschutz</a>
		</div>
		<div class="col-12 col-sm-6">
			<a href="http://www.scope-recruiting.de" class="primary-color" target="_blank">E-Recruiting für alle mit SCOPE</a>
		</div>
	</div>
</div>-->

<script src="<?= $_ENV['BASE_PATH'] ?>/templates/<?= $template ?>/js/nav.js?version=<?= VERSION ?>"></script>
<script src="<?= $_ENV['BASE_PATH'] ?>/templates/<?= $template ?>/js/slide.js?version=<?= VERSION ?>"></script>

<script src="<?= $_ENV['BASE_PATH'] ?>/js/template-base.js?version=<?= VERSION ?>"></script>

<script src="<?= $_ENV['BASE_PATH'] ?>/templates/<?= $template ?>/js/reset-form-data.js?version=<?= VERSION ?>"></script>
<script src="<?= $_ENV['BASE_PATH'] ?>/js/jobs-map.js?version=<?= VERSION ?>"></script>
<script src="<?= $_ENV['BASE_PATH'] ?>/js/add-applicant.js?version=<?= VERSION ?>"></script>
<script src="<?= $_ENV['BASE_PATH'] ?>/templates/<?= $template ?>/js/upload-document.js?version=<?= VERSION ?>"></script>
<script src="<?= $_ENV['BASE_PATH'] ?>/templates/<?= $template ?>/js/google-translation.js?version=<?= VERSION ?>"></script>
<script src="<?= $_ENV['BASE_PATH'] ?>/js/pagination.js?version=<?= VERSION ?>"></script>

<script src="https://maps.googleapis.com/maps/api/js?key=<?= $_ENV['MAPS_API_KEY'] ?>"></script>
<script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js?version=<?= VERSION ?>"></script>
<link rel="stylesheet" type="text/css" href="<?= $_ENV['BASE_PATH'] ?>/css/fa-pro-all.min.css">

