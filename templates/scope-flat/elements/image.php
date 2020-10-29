<?php

	$bgImageSnippet = 'background-image: ';
	$imageContent = '';
	$images = json_decode($jobSectionElement['text'], true)['detail'];

	foreach($images as $key => $value){

		$alt      = isset($value['alt']) ? $value['alt'] : '';

		$value['host'] = !empty($value['host']) ? $value['host'] : 'https://www.scope-recruiting.de';

		$imageUrl = $value['host'] .  DS . $value['rel_path']. DS . $value['name'];

		$imageContent = '<img src="' . $imageUrl . '" alt="'. $alt.'"/>';

		echo $imageContent;

	}
