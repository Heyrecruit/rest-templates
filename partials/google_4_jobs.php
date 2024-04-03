<?php
	if(isset($job)){
		
		if(!empty($job) && $job['google_for_jobs']['active']) {
?>
			<script type="application/ld+json">
				<?php
					echo json_encode($job['google_for_jobs']['structured_data']);
				?>
			</script>
<?php
		}
	}
