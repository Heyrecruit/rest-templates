<?php

	if(isset($_GET['job']) && isset($_GET['applicant']) && isset($_GET['location']) && $_GET['xing']){
		header('Location: ?page=job&id='. $_GET['job'] .'&location=' . $_GET['location'] . '&applicant=' . $_GET['applicant'] . '&xing=1#xingSuccess');
		exit;
	}

	if(!isset($jobs)) {
		$jobs = $scope->getJobs($company['Company']['id']);

		if($jobs['status_code'] == 200) {
			$jobs    = $jobs['data'];
		}
	}

	$employmentList = $scope->getEmploymentTypeList($jobs);
	$departmentList = isset($jobs['departments']) ? $jobs['departments'] : [];

	$hideElements = '';

	if(!isset($_GET['stand_alone_site']) || (isset($_GET['stand_alone_site']) && $_GET['stand_alone_site'])){
		include __DIR__ . DS . '../sections' . DS . "nav.php";
	}

	if(isset($_GET['stand_alone_site']) && !$_GET['stand_alone_site'] && $page == 'jobs') {
		$hideElements = 'style="display:none;"';
	}

?>


<section id="scope-jobs-intro-section" class="row no-gutters mb-3" <?=$hideElements?>>
	<div class="col-12">
		<div id="scope-jobs-intro-section-hl-wrap">
			<h2><?=$company['OverviewPage']['title']?></h2>
			<div id="scope-jobs-intro-section-hl-line"></div>
			<h1><?=$company['OverviewPage']['subtitle']?></h1>
		</div>


		<?php
			$imageUrl = 'https://www.scope-recruiting.de/img/scope_default_job_header_image.png';

			if(!empty($company) && isset($company['Company']['overview_header_picture'])) {
				$imageUrl = $company['Company']['overview_header_picture'];
			}
		?>
		<div id="scope-jobs-intro-section-overlay"></div>
		<div class="scope-img-wrap">
			<img src="<?=$imageUrl?>" alt="Head Hintergrund  <?=$company['Company']['name']?>" />
		</div>
	</div>
</section>
<?php
	if($company['OverviewPage']['show_description']) {

?>
		<section id="scope-jobs-table-description-section" class="mb-3">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<h2 class="mt-5 mb-2 primary-color"><?=$company['Company']['name']?></h2>
						<?php
							echo $company['OverviewPage']['description'];
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
	if($company['OverviewPage']['show_map']) {

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
		<div class="row" id="scope-jobs-list-section-filter">
			<?php
				$path = file_exists(ELEMENT_PATH . 'jobs_filter.php')
					? ELEMENT_PATH . 'jobs_filter.php'
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
