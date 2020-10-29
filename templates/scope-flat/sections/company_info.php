<section id="scope-job-about-section">
	<div class="row no-gutters">
		<div class="col-12 col-lg-6 order-first order-lg-last">
			<div class="half-container">
				<div class="row no-gutters">
					<div class="col-12">
						<div class="pt-5 pr-0 pr-lg-3 pl-0 pl-lg-5 pb-5">
							<?php
								foreach($jobSection['JobSectionElement'] as $key => $value) {

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
		<div class="col-12 col-lg-6 order-last order-lg-first">
			<div class="scope-img-wrap">
				<?php
					foreach($jobSection['JobSectionElement'] as $key => $value) {
						if($value['element_type'] === 'image' && file_exists(__DIR__ . DS . '../elements' . DS . $value['element_type'] . '.php')) {
							$jobSectionElement = $value;
							ob_start();
							include __DIR__ . DS . '../elements' . DS . $value['element_type'] . '.php';
							echo ob_get_clean();
						}
					}
				?>
			</div>
		</div>
	</div>
</section>
