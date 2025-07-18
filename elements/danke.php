<?php
	include __DIR__ . DS . '../templates/' . $template .'/sections' . DS . "nav.php";
?>
<section id="scope-jobs-intro-section" class="row no-gutters mb-3" style="min-height: 500px;">
	<div class="col-12">
		<div id="scope-jobs-intro-section-hl-wrap">
			<h2>Vielen Dank für Ihr Vertrauen!</h2>
			<div id="scope-jobs-intro-section-hl-line"></div>
			<h1 class="uppercase">Wir haben Ihre Bewerbung erhalten und werden uns in Kürze bei Ihnen melden.</h1>
			<div id="scope-jobs-intro-section-btn" style="margin-top:20px">
				<a href="?page=jobs" class="btn primary-bg primary-color-hover white-bg-hover px-3"><i
							class="fas fa-paper-plane mr-2"></i> Zurück</a>
			</div>
		</div>


		<?php
			$imageUrl = 'https://www.scope-recruiting.de/img/scope_default_job_header_image.png';


			if(!empty($company) && isset($company['overview_header_picture'])) {
				$imageUrl = $company['overview_header_picture'];
			}
		?>
		<div id="scope-jobs-intro-section-overlay"></div>
		<div class="scope-img-wrap">
			<img src="<?=$imageUrl?>" alt="Head Hintergrund  <?=$company['name']?>"/>
		</div>

	</div>
</section>
