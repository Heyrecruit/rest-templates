<?php
	if(!empty($job['contact_person'])) {
?>
		<div class="contact-person">
			<div>
				<?php
					$picture = !empty($job['contact_person']['picture'])
                        ? json_decode($job['contact_person']['picture'], true)
                        : null;
                    
					$url     = '';
					if(!empty($picture)) {
						$url = $picture['host'] . DS . $picture['rel_path'] . DS . $picture['name'];
					}
				?>
				<img src="<?=$url?>">
				<span>
                    <strong>
                        <?=HeyUtility::h($job['contact_person']['first_name'])?>
                        <?=HeyUtility::h($job['contact_person']['last_name'])?>
                    </strong>
                    <?=HeyUtility::h($job['contact_person']['division'])?>
                </span>
			</div>
			<div>
				<a href="tel:<?=$job['contact_person']['phone_number']?>">
                    <i class="fal fa-phone"></i>
                    <?=HeyUtility::h($job['contact_person']['phone_number'])?>
                </a>
				<a href="mailto:<?=$job['contact_person']['email']?>">
                    <i class="fal fa-envelope"></i>
                    <?=HeyUtility::h($job['contact_person']['email'])?>
                </a>
			</div>
		</div>

<?php
	}
?>
