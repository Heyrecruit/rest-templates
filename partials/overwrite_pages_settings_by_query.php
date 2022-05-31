<?php
	parse_str($_SERVER["QUERY_STRING"], $queryPageSettings);

	if(!empty($queryPageSettings) && isset($company)){
		foreach($queryPageSettings as $key => $value) {

			if(isset($company['OverviewPage'][$key])) {
				$company['OverviewPage'][$key] = $value;
			}
		}
	}

