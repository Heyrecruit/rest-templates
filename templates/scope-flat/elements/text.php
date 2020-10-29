<div class="output primary-bg-before">
	<?php
		if(strpos($jobSectionElement['html'], '<p>') !== false) {
			echo $jobSectionElement['html'];
		} else {
			?>
			<p><?=$jobSectionElement['html']?></p>
			<?php
		}
	?>
</div>
