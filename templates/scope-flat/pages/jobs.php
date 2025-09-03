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
	
	
	$companyEmployeeNumber = HeyUtility::getFormattedEmployeeNumber($company['employee_number']);


    $ariaLabelIntro = $language != 'de' ? 'Career page intro' : 'Karriereseite Intro';
    $ariaLabelCompanyDesc = $language != 'de' ? 'Company description' : 'Unternehmensbeschreibung';
    $ariaLabelCompanyJobsFilter = $language != 'de' ? 'Filter jobs' : 'Filter Stellenanzeigen';


?>


<section id="scope-jobs-intro-section" class="row no-gutters mb-3" <?=$hideElementsAttribute?> aria-labelledby="introHeadline">
	<div class="col-12">
		<div id="scope-jobs-intro-section-hl-wrap">
			<h2 id="introHeadline"><?=HeyUtility::h($company['overview_page']['overview_page_strings'][0]['title'])?></h2>
			<div id="scope-jobs-intro-section-hl-line"></div>
			<h1><?=HeyUtility::h($company['overview_page']['overview_page_strings'][0]['subtitle'])?></h1>
		</div>


		<?php
			$imageUrl = 'https://www.scope-recruiting.de/img/scope_default_job_header_image.png';

			if(!empty($company) && isset($company['overview_header_picture'])) {
				$imageUrl = $company['overview_header_picture'];
			}
		?>
		<div id="scope-jobs-intro-section-overlay"></div>
		<div class="scope-img-wrap">
			<img src="<?=$imageUrl?>" alt="Head Hintergrund  <?=HeyUtility::h($company['name'])?>" />
		</div>
	</div>
</section>
<?php
	if($company['overview_page']['show_description']) {

?>
		<section id="scope-jobs-table-description-section" class="mb-3" aria-label="<?=$ariaLabelCompanyDesc?>">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<h2 class="mt-5 mb-2 primary-color"><?=HeyUtility::h($company['name'])?></h2>
						<?php
							echo $company['overview_page']['overview_page_strings'][0]['description'];
						?>
					</div>
				</div>
			</div>
		</section>
<?php
	}
?>



<section id="scope-jobs-table-intro-section" class="mb-3">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<?php
					$title = $language !== 'de' ? 'Vacancies' : 'Offene Stellen';
				?>
				<h2 class="mt-5 mb-2 primary-color"><?=$title?></h2>
			</div>
		</div>
	</div>
</section>

<?php
	if($company['overview_page']['show_map']) {

?>
<section id="scope-jobs-map-section" class="mb-3" data-map-container="true">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div id="map"></div>
			</div>
		</div>
	</div>
</section>
<?php
	}
?>
<section id="scope-jobs-list-section" class="">
	<div class="container">
		<div class="row" id="scope-jobs-list-section-filter" role="region" aria-label="<?=$ariaLabelCompanyJobsFilter?>">
			<?php
				$path = file_exists(CURRENT_ELEMENT_PATH . 'jobs_filter.php')
					? CURRENT_ELEMENT_PATH . 'jobs_filter.php'
					: ELEMENT_PATH_ROOT . 'jobs_filter.php';
				require($path)
			?>
		</div>
		<div id="scope-jobs-list" data-jobs-container="true">
			<?php
				require(__DIR__ . "/../elements/jobs_table.php")
			?>
		</div>

	</div>
</section>
