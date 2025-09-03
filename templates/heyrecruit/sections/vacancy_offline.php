<?php if(!$job['company_location_jobs'][0]['active'] && (empty($_GET['preview']))) {?>
    <div class="col-12">
        <div class="alert alert-info mt-4 mb-n2 vacancy-empty" role="alert" aria-label="Wichtiger Hinweis zu dieser Stellenanzeige">
            <?=('Diese Stellenanzeige ist nicht länger vakant.')?> <a href="/jobs" class="alert-link"><?=(' Hier geht es zur Stellenübersicht')?> <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>
<?php } ?>