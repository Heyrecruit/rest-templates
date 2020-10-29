<?php

	if(!empty($job) && $job['Google4Jobs']['active']) {
?>
		<script type="application/ld+json">
			<?php
				echo json_encode($job['Google4Jobs']['structured_data']);
			?>
		</script>
<?php
	}
