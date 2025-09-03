<?php
	$hasCompanyImage = false;
	foreach($jobSection['job_section_elements'] as $key => $value) {
		if($value['element_type'] === 'image'){
			$hasCompanyImage = true;
			break;
		}
	}

	$imageClass = $hasCompanyImage ? 'col-lg-6' : '';
	$imageClass2 = $hasCompanyImage ? 'col-12' : 'col-md-9';
	$containerClass = $hasCompanyImage ? 'half-container' : 'container';
	$paddingClass = $hasCompanyImage ? 'pl-lg-5 ' : '';

    $ariaLabel = $language != 'de' ? 'Company information' : 'Unternehmensinformationen';

?>

<section id="section<?=$jobSection['id']?>" class="scope-job-about-section" aria-label="<?=$ariaLabel?>">
	<div class="row no-gutters">
		<div class="col-12 <?=$imageClass?> order-first order-lg-last">
			<div class="<?=$containerClass?>">
				<div class="row no-gutters">
					<div class="<?=$imageClass2?>">
						<div class="pt-5 pr-0 pr-lg-3 pl-0 <?=$paddingClass?> pb-5">
							<?php
								foreach($jobSection['job_section_elements'] as $key => $value) {

									if($value['element_type'] !== 'image' && file_exists(__DIR__ . DS . '../elements' . DS . $value['element_type'] . '.php')) {
										$jobSectionElement = $value;
										ob_start();
										include __DIR__ . DS . '../elements' . DS . $value['element_type'] . '.php';
										$element = ob_get_clean();

										if($jobSectionElement['element_type'] === 'social_links') {
							?>
											<div id="scope-job-about-section-social" class="my-5">
												<div class="row">
													<?php
														echo $element;
													?>
												</div>
											</div>
							<?php
										} else {
											echo $element;
										}
									}
								}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>

		<?php
			if($hasCompanyImage){
		?>
				<div class="col-12 col-lg-6 order-last order-lg-first">
					<?php
						foreach($jobSection['job_section_elements'] as $key => $value) {
							if($value['element_type'] === 'image' && file_exists(__DIR__ . DS . '../elements' . DS . $value['element_type'] . '.php')) {
								$jobSectionElement = $value;
								ob_start();
								include __DIR__ . DS . '../elements' . DS . $value['element_type'] . '.php';
								echo ob_get_clean();
							}
						}
					?>
				</div>
		<?php
			}
		?>
	</div>
</section>
