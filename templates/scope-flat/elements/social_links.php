<?php
	foreach(json_decode($jobSectionElement['text'], true)['detail'] as $key => $value) {
?>
		<div class="col-12 col-sm-6 mb-sm-0 mb-3">
			<i class="<?=$value['icon']?> primary-color" aria-hidden="true"></i>
			<a class="primary-color secondary-color-hover" href="<?=$value['href']?>" target="_blank"><?=$value['title']?></a>
		</div>
<?php
	}
?>

