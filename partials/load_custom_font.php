<?php
	
	$companyCustomFont =  str_replace(' ', '-', strtolower($company['company_templates']['template_font']));
	
	if (file_exists(FONT_PATH_ROOT . $companyCustomFont . '/' . $companyCustomFont . '.min.css')) {
		echo '<link rel="stylesheet" type="text/css" href="' . $_ENV['BASE_PATH'] . DS . 'font' . DS . $companyCustomFont . '/' . $companyCustomFont . '.min.css' . '">';
	} else {
		echo '<link rel="stylesheet" type="text/css" href="' .   $_ENV['BASE_PATH'] . DS . 'font' . DS . 'nunito/nunito.min.css">';
	}
	
	$fonts = [
		'nunito'           => 'Nunito',
		'lato'             => 'Lato',
		'montserrat'       => 'Montserrat',
		'noto'             => 'Noto',
		'open-sans'        => 'Open Sans',
		'oswald'           => 'Oswald',
		'quicksand'        => 'Quicksand',
		'roboto'           => 'Roboto',
		'roboto-condensed' => 'Roboto-Condensed',
		'source-sans-pro'  => 'Source-Sans-Pro'
	];