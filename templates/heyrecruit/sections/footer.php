<?php
	/** @var array $company */
	/** @var array $template */
?>
<div class="container">
    <div class="row">
        <div class="col-12">
            <nav>

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
                       data-target="#scope_datenschutz"><?= $company['language_id'] !== 1 ? 'Privacy policy' : 'Datenschutz' ?></a>
                <?php } else { ?>
                    <a href="<?=$company['data_protection']?>" target="_blank" class="primary-color"><?= $company['language_id'] !== 1 ? 'Privacy policy' : 'Datenschutz' ?></a>
                <?php }  ?>


                <a href="javascript:void(0)" class="primary-color" id="openCookieInfoModal">
                    <?= $company['language_id'] !== 1 ? 'Cookie settings' : 'Cookie-Einstellungen' ?>
                </a>
            </nav>
            <span>
                    Powered by<a href="https://www.heyrecruit.de/" class="primary-color" target="_blank"><img
                            src="<?= $_ENV['BASE_PATH'] ?>/templates/<?= $template ?>/img/heyrecruit_logo.svg" alt="Heyrecruit-Logo"></a>
            </span>
        </div>
    </div>
</div>

<script src="https://www.google.com/recaptcha/api.js?render=<?=HeyUtility::env('RECAPTCHA_SITE_KEY')?>"></script>
<script src="<?= $_ENV['BASE_PATH'] ?>/templates/<?= $template ?>/js/nav.js?version=<?= VERSION ?>"></script>
<script src="<?= $_ENV['BASE_PATH'] ?>/templates/<?= $template ?>/js/slide.js?version=<?= VERSION ?>"></script>
<script src="<?= $_ENV['BASE_PATH'] ?>/js/bootstrap.bundle.4.4.1.js?version=<?= VERSION ?>"></script>
<script src="<?= $_ENV['BASE_PATH'] ?>/js/bootstrap-multiselect.js?version=<?= VERSION ?>"></script>
<script src="<?= $_ENV['BASE_PATH'] ?>/js/template-base.js?version=<?= VERSION ?>"></script>
<script src="<?= $_ENV['BASE_PATH'] ?>/js/add-applicant.js?version=<?= VERSION ?>"></script>
<script src="<?=$_ENV['BASE_PATH']?>/js/upload-document.js?version=<?=VERSION?>"></script>
<script src="<?=$_ENV['BASE_PATH']?>/js/whatsapp-application.js?version=<?=VERSION?>"></script>
<!--<script src="<?= $_ENV['BASE_PATH'] ?>/js/pagination.js?version=<?= VERSION ?>"></script>-->

<?php if ($company['overview_page']['show_map']) {?>
    <!-- Block Google Fonts loaded by Google Maps -->

    <script src="<?= $_ENV['BASE_PATH'] ?>/js/jobs-map.js?version=<?= VERSION ?>"></script>

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
    <script src="https://maps.googleapis.com/maps/api/js?key=<?= $_ENV['MAPS_API_KEY'] ?>"></script>
    <script src="https://unpkg.com/@googlemaps/markerclusterer/dist/index.min.js?version=<?= VERSION ?>"></script>
<?php
}
?>
<link rel="stylesheet" type="text/css" href="<?= $_ENV['BASE_PATH'] ?>/css/fa-pro-all.min.css">