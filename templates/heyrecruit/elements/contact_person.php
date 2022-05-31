<?php
	if(!empty($job['ContactPerson'])) {
?>
		<div class="contact-person">
			<div>
				<?php
					$picture = !empty($job['ContactPerson']['picture']) ? json_decode($job['ContactPerson']['picture'], true) : null;
					$url     = '';
					if(!empty($picture)) {
						$url = $picture['host'] . DS . $picture['rel_path'] . DS . $picture['name'];
					}
				?>
				<img src="<?=$url?>">
				<span><strong><?=$job['ContactPerson']['first_name']?> <?=$job['ContactPerson']['last_name']?></strong><?=$job['ContactPerson']['division']?></span>
			</div>
			<div>
				<a href="tel:<?=$job['ContactPerson']['phone_number']?>"><i class="fal fa-phone"></i><?=$job['ContactPerson']['phone_number']?></a>
				<a href="mailto:<?=$job['ContactPerson']['email']?>"><i class="fal fa-envelope"></i><?=$job['ContactPerson']['email']?></a>
			</div>
		</div>

		<?php
	}
?>
