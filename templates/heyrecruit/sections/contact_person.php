<section id="jp-section-contact">
	<div class="row">
		<div class="col-12">
			<div id="contact-tile">


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

				<?php
					if(!empty($job['ContactPerson'])){
				?>
						<div>

							<button class="btn btn-primary" onclick="location.href='mailto:<?=$job['ContactPerson']['email']?>'">
								<i class="fas fa-paper-plane"></i><?= $language != 'de' ? 'Send message' : 'Nachricht schreiben'?>
							</button>
						</div>
				<?php
					}
				?>

			</div>
		</div>
	</div>
</section>
