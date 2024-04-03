<?php
	/** @var array $jobSectionElement */
	
	$images = json_decode($jobSectionElement['job_section_element_strings'][0]['text'], true);
	$sliderClass = count($images) > 1 ? ' slider-wrap' : '';
?>
<div class='scope-img-wrap<?= $sliderClass ?>

<?= isset($headerImage) && $headerImage === true ? " header-img-wrap" : "" ?>

<?= isset($companyInfoSection) && $companyInfoSection === true ? " company-img-wrap" : "" ?>'>
	<?php
		$bgImageSnippet = 'background-image: ';
		$imageContent = '';
		
		foreach ($images as $imageUrl) {
			echo '<img src="' . $imageUrl . '" />';
		}
	?>
</div>
