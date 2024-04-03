<section id="section<?=$jobSection['id']?>" class="scope-jobs-list-section">
	<div class="container">
		<div class="row">
			<div class="col-12 col-md-9">
				<?php
					foreach($jobSection['job_section_elements'] as $key => $value) {

						if(file_exists(__DIR__ . DS . '../elements' . DS . $value['element_type'] . '.php')) {

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