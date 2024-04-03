<?php
    /** @var array $jobs */
    /** @var array $page */
    /** @var array $company */
    /** @var string $language */
    
	$employmentList = $jobs['employment_type_list'];
	$departmentList = $jobs['department_list'];
 
	$includeNav = !isset($_GET['stand_alone_site']) || $_GET['stand_alone_site'];
	$hideElements = isset($_GET['stand_alone_site']) && !$_GET['stand_alone_site'] && $page == 'jobs';
	
	if ($includeNav) {
		include CURRENT_SECTION_PATH . "nav.php";
	}
	
	$hideElementsAttribute = $hideElements ? 'style="display:none;"' : '';
	
	$companyEmployeeNumber = HeyUtility::getFormattedEmployeeNumber($company['employee_number'], $language);
?>

<header <?=$hideElementsAttribute?>>
    <?php
        $imageUrl = 'https://www.scope-recruiting.de/img/scope_default_job_header_image.png';
    
        if (!empty($company['overview_header_picture'])) {
            $imageUrl = $company['overview_header_picture'];
        }
    ?>
    <img id="cp-header-img" src="<?= $imageUrl ?>" alt="Header-Hintergrund <?=HeyUtility::h($company['name']) ?>"/>
    <div id="logo">
        <img src="<?=$company['logo']?>" alt="<?=$company['name']?> Logo">
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1><?=HeyUtility::h($company['overview_page']['overview_page_strings'][0]['title'])?></h1>
                <h2><?=HeyUtility::h($company['overview_page']['overview_page_strings'][0]['subtitle'])?></h2>
            </div>
        </div>
    </div>
</header>

<?php
    $social_links = ["website", "instagram", "xing", "linkedin", "facebook", "twitter", "kununu"];
    $socialLinksContainer = false;
    
    foreach ($social_links as $link) {
       if (!empty($company[$link])) {
          $socialLinksContainer = true;
       }
    }
    
    $dataExists = false;
    
    if (
        $socialLinksContainer === true ||
        $company['overview_page']['overview_page_strings'][0]['description'] ||
        count($company['company_locations']) > 0
    ) {
       $dataExists = true;
    }
    if(
        $dataExists ||
        (
            isset($company['overview_page']['show_description']) ||
            isset($company['overview_page']['show_company_infos']) ||
            isset($company['overview_page']['show_social_links'])
        )
    ) {
?>
<section id="cp-section-company-info" class="no-pt" <?= $hideElementsAttribute ?>>
   <div class="container">
      <div class="row company-info">
         <div class="col-12 col-lg-8 offset-lg-2">
            <?php
                if (
                    !empty($company['overview_page']['overview_page_strings'][0]['description']) &&
                    !empty($company['overview_page']['show_description'])
                ) {
            ?>
                    <div class="company-description">
                      <?php
                          echo strip_tags(
                              $company['overview_page']['overview_page_strings'][0]['description'],
                              ['p', 'b', 'span', 'a', 'ul', 'li', 'ol', 'a', 'u']
                          );
                      ?>
                    </div>
            <?php
                 }
                
                 if ($company['overview_page']['show_company_infos']) {
            ?>
                    <div id="company-numbers" class="flexbox-badges">
                        <?php
                            $employeeText   = $language != 'de' ? 'employees' : 'Mitarbeiter';
                            $locationTextSg = $language != 'de' ? 'location' : 'Standort';
                            $locationTextPl = $language != 'de' ? 'locations' : 'Standorte';
                        ?>
                        <span><i class="fal fa-user"></i><?= $companyEmployeeNumber . " " . $employeeText ?></span>
                        <?php
                             if (count($company['company_locations'])) {
                        ?>
                                 <span>
                                     <i class="fal fa-map-marker-alt"></i>
                                     <?=
                                         count($company['company_locations']) . " " . (
                                             count($company['company_locations']) > 1
                                                 ? $locationTextPl
                                                 : $locationTextSg
                                             )
                                     ?>
                                 </span>
                        <?php
                             }
                             
                            $industry = $language != 'de'
                                ? $company['industry']['name_en'] ?? ""
                                : $company['industry']['name_de'] ?? "";
                             
                            if ($industry) {
                        ?>
                                <span><i class="fal fa-industry"></i><?=$industry?></span>
                        <?php
                            }
                        ?>
                    </div>
            <?php
                }
    
                if ($company['overview_page']['show_social_links']) {
                   
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
                      if (!empty($company[$link])) {
            ?>
                         <button class="btn btn-primary">
                             <a href="<?= str_starts_with($company[$link], "http") ? $company[$link] : "https://" . $company[$link] ?>" target="_blank">
                                 
                                 <?php
                                     if ($link === 'website') {
                                 ?>
                                        <i class="fas fa-globe-europe"></i>
                                 <?php
                                     } else if ($link === 'kununu') {
                                 ?>
                                        <svg id="kununu-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 250 250" style="height:22px;fill:#ffffff !important;margin-top: 2px;"><defs><style>.cls-1{}</style></defs><path id="path3781" class="cls-1" d="M116.16,202.56,82,236.28a44.52,44.52,0,0,1-63.55,0L13,230.76c-17.39-17.78-17.39-46,0-63.15l31.77-31.88,1.8-1.84a12.56,12.56,0,0,1,16.79,0l4.19,4.29a11.86,11.86,0,0,1,.6,16.56L34,188.46a14.33,14.33,0,0,0,0,20.84l5.4,5.52c6,5.52,15,6.13,21,0L94.57,181.1a12.56,12.56,0,0,1,16.79,0l4.2,4.29c4.79,5.52,4.79,12.88.6,17.17Z" transform="translate(0)"/><path id="path3783" class="cls-1" d="M116.16,63.38,112,67.67c-4.8,4.3-12,4.91-16.79.62L61,34.57a15.36,15.36,0,0,0-21,0l-5.4,5.51a14.34,14.34,0,0,0,0,20.85L68.79,94.65a11.83,11.83,0,0,1,0,16.55l-4.19,4.3c-4.8,4.29-12,4.9-16.19,0L14.24,81.78c-17.39-17.17-18-46,0-63.16l5.39-5.51C37-4.67,65.2-4.06,83.18,13.11L113.76,45l1.8,1.84a11.87,11.87,0,0,1,.6,16.55Z" transform="translate(0)"/><path id="path3785" class="cls-1" d="M236.66,231.38l-5.4,5.51c-17.38,17.78-46.16,17.17-63.55,0L135.94,205l-1.8-1.84a11.31,11.31,0,0,1,0-16.55l4.2-4.29c4.79-4.3,12-4.91,16.78-.62l34.18,33.72a15.36,15.36,0,0,0,21,0l5.39-5.51c6-6.13,6-15.33,0-20.85L181.5,155.35c-4.79-4.29-4.19-12.26,0-16.55l4.2-4.3c4.79-4.29,12-4.9,16.19,0l34.17,33.72C254,185.39,254,213.6,236.66,231.38Z" transform="translate(0)"/><path id="path3787" class="cls-1" d="M236.66,81.78l-31.78,31.88-1.8,1.84a12.55,12.55,0,0,1-16.78,0l-4.2-4.3a11.87,11.87,0,0,1-.6-16.55l34.17-33.72c6-5.52,6-14.72,0-20.85l-5.39-5.51a15.36,15.36,0,0,0-21,0L155.12,68.29c-4.79,4.9-12,4.29-16.78,0l-4.2-4.3c-4.8-4.9-4.8-11.64,0-16.55l34.17-34.33c17.39-17.17,46.17-17.78,63.55,0l5.4,5.51a44.77,44.77,0,0,1-.6,63.16Z" transform="translate(0)"/></svg>

                                         <?php
                                     } else {
                                 ?>
                                        <i class="fab fa-<?= $link ?>"></i>
                                 <?php
                                     }
                                 ?>
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
<?php
    }
?>

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
                <h1 class="primary-color">$language != 'de' ? 'What our employees say' : 'Das sagen unsere Mitarbeiter' */?></h1>
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
        if (!$company['overview_page']['show_map']) {
   ?>
            <h1><?= $language != 'de' ? 'Vacancies' : 'Offene Stellen' ?></h1>
   <?php
        }

        if ($company['overview_page']['show_map']) {
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
		    $path = file_exists(CURRENT_ELEMENT_PATH . 'jobs_filter.php')
			    ? CURRENT_ELEMENT_PATH . 'jobs_filter.php'
			    : ELEMENT_PATH_ROOT . 'jobs_filter.php';
       
		    require($path)
	    ?>
        <div class="job-list cp-job-list" data-jobs-container="true">
            <?php
                require(CURRENT_ELEMENT_PATH . "jobs_table.php")
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
                    <h2 class="primary-color">$language != 'de' ? 'Apply on your own initiative or ask questions' : 'Initiativ bewerben oder Fragen stellen' */?></h2>
                    <p>
                        Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt
                        ut labore et dolore magna aliquyam erat
                    </p>
                    <button class="btn btn-primary">
                        <i class="fal fa-paper-plane"></i>$language != 'de' ? 'Send message' : 'Nachricht schreiben' */?>
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
/*               if($company['overview_page']['has_contact_section'] && $company['overview_page']['show_contact']) {
               */?>
					<div class="col-12 col-lg-7">
						<div>
							<h2 class="primary-color">$language != 'de' ? 'Contact person' : 'Ansprechpartner' */?></h2>
							<div>
								<div class="contact-person">
									<div>
										<?php
/*											if(!empty($company['ContactPerson']['picture'])){
										*/?>
												<img src="$company['ContactPerson']['picture']*/?>">
										<?php
/*											}else{
										*/?>
												<img src="https://snappygoat.com/b/ecea4d95566321eccb3f6264aafed3c39a19d0ad">
										<?php
/*											}
										*/?>

										<span><strong>$company['ContactPerson']['first_name']*/?> $company['ContactPerson']['last_name']*/?></strong>$company['ContactPerson']['division']*/?></span>
									</div>
									<div>
										<a href="tel:01234567890"><i class="fal fa-phone"></i>$company['ContactPerson']['phone_number']*/?></a>
										<a href="mailto:$company['ContactPerson']['email']*/?>"><i class="fal fa-envelope"></i>$company['ContactPerson']['email']*/?></a>
									</div>
                                </div>
                                <p> $company['ContactPerson']['contact_description'] */?></p>
                                <a href="mailto: $company['ContactPerson']['email'] */?>">
                                    <button class="btn btn-primary"><i class="fal fa-paper-plane"></i> $language != 'de' ? 'Send message' : 'Nachricht schreiben' */?></button>
                                </a>
                            </div>
						</div>
					</div>
                  <?php
/*               }
               */?>
					<div class="col-12 col-lg-5">
						<div>
							<h2 class="primary-color"> $language != 'de' ? 'Apply later' : 'Später bewerben' */?></h2>
							<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor
								invidunt ut labore et dolore magna aliquyam erat</p>
							<form class="apply-later-form">
								<input type="email" name="email"
								       placeholder="$language != 'de' ? 'E-mail address' : 'E-Mail-Adresse'*/?>">
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
