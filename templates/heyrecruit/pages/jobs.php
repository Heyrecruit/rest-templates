<?php

if (isset($_GET['job']) && isset($_GET['applicant']) && isset($_GET['location']) && $_GET['xing']) {
    header('Location: ?page=job&id=' . $_GET['job'] . '&location=' . $_GET['location'] . '&applicant=' . $_GET['applicant'] . '&xing=1#xingSuccess');
    exit;
}

if (!isset($jobs)) {
    $jobs = $scope->getJobs($company['Company']['id']);

    if ($jobs['status_code'] == 200) {
        $jobs = $jobs['data'];
    }
}

$employmentList = $scope->getEmploymentTypeList($jobs);
$departmentList = isset($jobs['departments']) ? $jobs['departments'] : [];

$hideElements = '';

if(!isset($_GET['stand_alone_site']) || (isset($_GET['stand_alone_site']) && $_GET['stand_alone_site'])) {
	include __DIR__ . DS . '../sections' . DS . "nav.php";
}

if(isset($_GET['stand_alone_site']) && !$_GET['stand_alone_site'] && $page == 'jobs') {
	$hideElements = 'style="display:none;"';
}

$logoUrl = '';
if(!empty($company) && isset($company['Company']['logo_big'])) {
	$logoUrl = $company['Company']['logo_big'];
}
?>

<header <?=$hideElements?>>
    <?php
    $imageUrl = 'https://www.scope-recruiting.de/img/scope_default_job_header_image.png';

    if (!empty($company) && isset($company['Company']['overview_header_picture'])) {
        $imageUrl = $company['Company']['overview_header_picture'];
    }
    ?>
    <img id="cp-header-img" src="<?= $imageUrl ?>" alt="Header-Hintergrund <?= $company['Company']['name'] ?>"/>
    <div id="logo">
        <img src="<?= $logoUrl ?>" alt="<?= $company['Company']['name'] ?> Logo">
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1><?= $company['OverviewPage']['title'] ?></h1>
                <h2><?= $company['OverviewPage']['subtitle'] ?></h2>
            </div>
        </div>
    </div>
</header>

<?php
$social_links = ["website", "instagram", "xing", "linkedin", "facebook", "twitter", "kununu"];
$socialLinksContainer = false;

foreach ($social_links as $link) {
   if (!empty($company['Company'][$link])) {
      $socialLinksContainer = true;
   }
}

$dataExists = false;

if ($socialLinksContainer === true || $company['OverviewPage']['description'] || isset($companyEmployeeNumber) || $company['Company']['location_count'] || $company['Company']['business_type']) {
   $dataExists = true;
}
?>

<?php  if ($dataExists || (isset($company['OverviewPage']['show_description']) || isset($company['OverviewPage']['show_company_infos']) || isset($company['OverviewPage']['show_social_links']))) { ?>
<section id="cp-section-company-info" class="no-pt" <?= $hideElements ?>>
   <div class="container">
      <div class="row company-info">
         <div class="col-12 col-lg-8 offset-lg-2">
            <?php
            if (!empty($company['OverviewPage']['description']) && !empty($company['OverviewPage']['show_description'])) { ?>
               <div class="company-description">
                  <?php echo $company['OverviewPage']['description']; ?>
               </div>
               <?php
            }
            if ($company['OverviewPage']['show_company_infos']) {?>


               <div id="company-numbers" class="flexbox-badges">
                  <?php
                  $employeeText = $language != 'de' ? 'employees' : 'Mitarbeiter';
                  $locationTextSg = $language != 'de' ? 'location' : 'Standort';
                  $locationTextPl = $language != 'de' ? 'locations' : 'Standorte';
                  ?>
                  <?php if (isset($companyEmployeeNumber)) {
                      $companyEmployeeNumberText = $companyEmployeeNumber;
                      if($companyEmployeeNumber == 'unter 25'){
                          $companyEmployeeNumberText = $language != 'de' ? 'under 25' : 'unter 25';
                      }
                      if($companyEmployeeNumber == 'über 100'){
                          $companyEmployeeNumberText = $language != 'de' ? 'more than 100' : 'über 100';
                      }
                      ?>
                     <span><i class="fal fa-user"></i><?= $companyEmployeeNumberText . " " . $employeeText ?></span>
                  <?php }
                  if ($company['Company']['location_count']) { ?>
                     <span><i class="fal fa-map-marker-alt"></i><?= $company['Company']['location_count'] . " " . ($company['Company']['location_count'] > 1 ? $locationTextPl : $locationTextSg) ?></span>
                  <?php }
                  if ($company['Company']['business_type']) { ?>
                     <span><i class="fal fa-industry"></i><?= $company['Company']['business_type'] ?></span>
                     <?php
                  } ?>
               </div>
               <?php
            }

            if ($company['OverviewPage']['show_social_links']) {
               echo $socialLinksContainer ? "<div id='social-links'>" : "";

               $social_links_titles = [
                  "website" => "Website",
                  "instagram" => "Instagram",
                  "xing" => "Xing",
                  "linkedin" => "LinkedIn",
                  "facebook" => "Facebook",
                  "twitter" => "Twitter",
                  "kununu" => "Kununu"
               ];

               foreach ($social_links as $link) {
                  if (!empty($company['Company'][$link])) {
                     ?>
                     <button class="btn btn-primary"><a
                           href="<?= substr($company['Company'][$link], 0, 4) === "http" ? $company['Company'][$link] : "https://" . $company['Company'][$link] ?>"
                           target="_blank">
                           <?php
                           if ($link === 'website') {
                              ?>
                              <i class="fas fa-globe-europe"></i>
                              <?php
                           } else if ($link === 'kununu') {
                              ?>
                              <img src="<?= $_ENV['BASE_PATH'] ?>/templates/<?= $template ?>/img/kununu.svg">
                              <?php
                           } else {
                              ?>
                              <i class="fab fa-<?= $link ?>"></i>
                              <?php
                           } ?>
                        </a>
                     </button>
                     <?php
                  }
               }

               echo $socialLinksContainer ? "</div>" : "";
            }
            ?>
         </div>
      </div>
   </div>
</section>
<?php } ?>

<!-- KPI-Section -->
<!--<section id="cp-section-kpi">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-4">
                <h2 class="primary-color"><span class="primary-color">300</span>Lorem ipsum dolor</h2>
                <p>Fließende Deutsch- und gute Englischkenntnisse in Wort und Schrift</p>
            </div>
            <div class="col-12 col-md-4">
                <h2 class="primary-color"><span class="primary-color">8.500+</span>Lorem ipsum dolor</h2>
                <p>Fließende Deutsch- und gute Englischkenntnisse in Wort und Schrift</p>
            </div>
            <div class="col-12 col-md-4">
                <h2 class="primary-color"><span class="primary-color">29</span>Lorem ipsum dolor</h2>
                <p>Fließende Deutsch- und gute Englischkenntnisse in Wort und Schrift</p>
            </div>
        </div>
    </div>
</section>-->

<!-- Benefits-Section -->
<!--<section id="cp-section-benefits">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-8 offset-lg-2">
                <h1>Lorem Ipsum dolor sit</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-4">
                <i class="fal fa-heart primary-color"></i>
                <h2>Lorem ipsum dolor</h2>
                <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut
                    labore et dolore magna aliquyam erat, sed diam voluptua.</p>
            </div>
            <div class="col-12 col-md-4">
                <i class="fal fa-cog primary-color"></i>
                <h2>Lorem ipsum dolor</h2>
                <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut
                    labore et dolore magna aliquyam erat, sed diam voluptua.</p>
            </div>
            <div class="col-12 col-md-4">
                <i class="fal fa-heart primary-color"></i>
                <h2>Lorem ipsum dolor</h2>
                <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut
                    labore et dolore magna aliquyam erat, sed diam voluptua.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-4">
                <i class="fal fa-cog primary-color"></i>
                <h2>Lorem ipsum dolor</h2>
                <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut
                    labore et dolore magna aliquyam erat, sed diam voluptua.</p>
            </div>
            <div class="col-12 col-md-4">
                <i class="fal fa-heart primary-color"></i>
                <h2>Lorem ipsum dolor</h2>
                <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut
                    labore et dolore magna aliquyam erat, sed diam voluptua.</p>
            </div>
            <div class="col-12 col-md-4">
                <i class="fal fa-cog primary-color"></i>
                <h2>Lorem ipsum dolor</h2>
                <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut
                    labore et dolore magna aliquyam erat, sed diam voluptua.</p>
            </div>
        </div>
    </div>
</section>-->

<!-- Testimonials-Section -->
<!--<section id="cp-section-testimonials">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-8 offset-lg-2">
                <h1 class="primary-color"><?/*= $language != 'de' ? 'What our employees say' : 'Das sagen unsere Mitarbeiter' */?></h1>
                <p>
                    Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut
                    labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores
                    et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.
                    Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut
                    labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores
                    et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.
                </p>
                <img src="https://snappygoat.com/b/ecea4d95566321eccb3f6264aafed3c39a19d0ad">
                <span><strong>Max Mustermann</strong>Lagerleiter</span>
            </div>
        </div>
    </div>
</section>-->

<section id="cp-section-jobs" class="no-p">
    <?php
    if (!$company['OverviewPage']['show_map']) {
        ?>
        <h1><?= $language != 'de' ? 'Vacancies' : 'Offene Stellen' ?></h1>
        <?php
    }

    if ($company['OverviewPage']['show_map']) {
        ?>
        <div id="map-wrapper" data-map-container="true">
            <div id="map" style="height: 650px;"></div>
            <div id="map-overlay"></div>
        </div>
        <?php
    }
    ?>
    <div class="container">
	    <?php
		    $path = file_exists(ELEMENT_PATH . 'jobs_filter.php')
			    ? ELEMENT_PATH . 'jobs_filter.php'
			    : ELEMENT_PATH_ROOT . 'jobs_filter.php';
		    require($path)
	    ?>
        <div class="job-list cp-job-list" data-jobs-container="true">
            <?php
                require(__DIR__ . "/../elements/jobs_table.php")
            ?>
        </div>

    </div>
</section>
<!-- Initiativbewerbung-Section -->
<!--<section id="cp-section-initiative" class="no-p">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="initiative-tile">
                    <h2 class="primary-color"><?/*= $language != 'de' ? 'Apply on your own initiative or ask questions' : 'Initiativ bewerben oder Fragen stellen' */?></h2>
                    <p>
                        Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt
                        ut labore et dolore magna aliquyam erat
                    </p>
                    <button class="btn btn-primary">
                        <i class="fal fa-paper-plane"></i><?/*= $language != 'de' ? 'Send message' : 'Nachricht schreiben' */?>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>-->

<!-- Ansprechpartner- und Später-Bewerben-Section -->
<!--		<section id="cp-section-contact" class="no-p">
			<div class="container">
				<div class="row">
               <?php
/*               if($company['OverviewPage']['has_contact_section'] && $company['OverviewPage']['show_contact']) {
               */?>
					<div class="col-12 col-lg-7">
						<div>
							<h2 class="primary-color"><?/*= $language != 'de' ? 'Contact person' : 'Ansprechpartner' */?></h2>
							<div>
								<div class="contact-person">
									<div>
										<?php
/*											if(!empty($company['ContactPerson']['picture'])){
										*/?>
												<img src="<?/*=$company['ContactPerson']['picture']*/?>">
										<?php
/*											}else{
										*/?>
												<img src="https://snappygoat.com/b/ecea4d95566321eccb3f6264aafed3c39a19d0ad">
										<?php
/*											}
										*/?>

										<span><strong><?/*=$company['ContactPerson']['first_name']*/?> <?/*=$company['ContactPerson']['last_name']*/?></strong><?/*=$company['ContactPerson']['division']*/?></span>
									</div>
									<div>
										<a href="tel:01234567890"><i class="fal fa-phone"></i><?/*=$company['ContactPerson']['phone_number']*/?></a>
										<a href="mailto:<?/*=$company['ContactPerson']['email']*/?>"><i class="fal fa-envelope"></i><?/*=$company['ContactPerson']['email']*/?></a>
									</div>
                                </div>
                                <p><?/*= $company['ContactPerson']['contact_description'] */?></p>
                                <a href="mailto:<?/*= $company['ContactPerson']['email'] */?>">
                                    <button class="btn btn-primary"><i class="fal fa-paper-plane"></i><?/*= $language != 'de' ? 'Send message' : 'Nachricht schreiben' */?></button>
                                </a>
                            </div>
						</div>
					</div>
                  <?php
/*               }
               */?>
					<div class="col-12 col-lg-5">
						<div>
							<h2 class="primary-color"><?/*= $language != 'de' ? 'Apply later' : 'Später bewerben' */?></h2>
							<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor
								invidunt ut labore et dolore magna aliquyam erat</p>
							<form class="apply-later-form">
								<input type="email" name="email"
								       placeholder="<?/*=$language != 'de' ? 'E-mail address' : 'E-Mail-Adresse'*/?>">
								<button type="submit" class="btn btn-primary">
									<i class="fal fa-paper-plane"></i>
								</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</section>
-->