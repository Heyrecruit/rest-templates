<section class="scope-media-section">
	<div class="container">
		<div class="row">
			<div class="col-12 col-lg-9">
				<?php
					foreach($jobSection['JobSectionElement'] as $key => $value) {
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