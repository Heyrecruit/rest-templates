<section id="scope-jobs-intro-section" class="row no-gutters">
	<div class="col-12">
		<div id="scope-jobs-intro-section-hl-wrap">
			<?php
				foreach($jobSection['JobSectionElement'] as $key => $value) {
					if($value['element_type'] !== 'image' && file_exists(__DIR__ . DS . '../elements' . DS . $value['element_type'] . '.php')) {
						$jobSectionElement = $value;
						ob_start();
						include __DIR__ . DS . '../elements' . DS . $value['element_type'] . '.php';
						$element = ob_get_clean();

						echo $element;
					}
				}

			?>

			<div id="scope-jobs-intro-section-hl-line"></div>

			<div id="scope-jobs-intro-section-info">

                <div id="locationWrapper" class="primary-color-hover">
                    <i class="fas fa-map-marker-alt"></i>
                    <div class="locationTrigger">
                        <span><?=$formattedJobLocation?></span>
	                    <?php
		                    if(count($cities) > 1){
		                 ?>
			                    <i class="fas fa-angle-down"></i>
	                    <?php
		                    }
	                    ?>

                    </div>
	                <?php
		                if(count($cities) > 1){
	                ?>
                    <ul id="locationList">
	                    <?php
		                    foreach($cities as $a => $b){
		                ?>
			                    <li class="locationTriggerLi" data-location-id="<?=$a?>"><?=$b?></li>
	                    <?php
		                    }
	                    ?>

                    </ul>
			        <?php
		                }
	                ?>
                </div>


				<span><i class="far fa-clock"></i> <?=$job['Job']['employment']?></span>
			</div>
			<div id="scope-jobs-intro-section-btn">
				<?php
					$text = $language != 'de' ? 'Apply now' : 'Jetzt bewerben';
				?>
				<a href="#scope-job-form-block" class="btn primary-bg primary-color-hover white-bg-hover px-3"><i class="fas fa-paper-plane mr-2"></i> <?=$text?></a>
			</div>
		</div>

      <div>
         <?php
         foreach ($jobSection['JobSectionElement'] as $key => $value) {
            if ($value['element_type'] === 'image' && file_exists(__DIR__ . DS . '../elements' . DS . $value['element_type'] . '.php')) {
               $jobSectionElement = $value;
               ob_start();
               include __DIR__ . DS . '../elements' . DS . $value['element_type'] . '.php';
               echo ob_get_clean();
            }
         }
         ?>
      </div>


	</div>
</section>
