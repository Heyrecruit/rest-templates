<?php

	$filterCount = 0;
	$colClass    = 'col-md-12';

	if(
		strpos($company['OverviewPage']['filter'], 'list') !== false ||
		strpos($company['OverviewPage']['filter'], 'location') !== false ||
		strpos($company['OverviewPage']['filter'], 'search') !== false
	) {
		$filterCount++;
	}

	if(strpos($company['OverviewPage']['filter'], 'employment') !== false) {
		$filterCount++;
	}

	if(strpos($company['OverviewPage']['filter'], 'department') !== false) {
		$filterCount++;
	}

	switch($filterCount) {
		case 1:
			$colClass = 'col-md-12';
			break;
		case 2:
			$colClass = 'col-md-6';
			break;
		case 3:
			$colClass = 'col-md-4';
			break;
	}

	if(
		strpos($company['OverviewPage']['filter'], 'location') !== false ||
		strpos($company['OverviewPage']['filter'], 'search') !== false
	) {
		?>
		<div class="col-12 <?=$colClass?>">
			<label for="standort"><?=$language !== 'de' ? 'Location' : 'Standort'?></label>
			<input id="standort" type="text" placeholder="<?=$language !== 'de' ? 'Postcode/town' : 'PLZ/Ort'?>">
		</div>
		<?php
	}

	if(strpos($company['OverviewPage']['filter'], 'list') !== false) {
		?>
		<div class="col-12 <?=$colClass?>">
			<label for="location-list"><?=$language !== 'de' ? 'Location' : 'Standort'?></label>
			<select id="location-list">
				<option value="all" selected><?=$language !== 'de' ? 'All' : 'Alle'?></option>
				<?php
					foreach($company['CompanyLocation'] as $key => $value) {
						?>
						<option value="<?=$key?>"><?=$value?></option>
						<?php
					}
				?>
			</select>
		</div>
		<?php
	}
?>

<?php
	if(strpos($company['OverviewPage']['filter'], 'employment') !== false) {
		?>
		<div class="col-12 <?=$colClass?>">
			<label for="einstellungsart"><?=$language !== 'de' ? 'Employment type' : 'Einstellungsart'?></label>
			<select id="einstellungsart">
				<option value="all" selected><?=$language !== 'de' ? 'All' : 'Alle'?></option>
				<?php
					foreach($employmentList as $key => $value) {
						?>
						<option value="<?=$key?>"><?=$value?></option>
						<?php
					}
				?>
			</select>
		</div>
		<?php
	}

	if(strpos($company['OverviewPage']['filter'], 'department') !== false) {
		?>
		<div class="col-12 <?=$colClass?>">
			<label for="fachabteilung"><?=$language !== 'de' ? 'Department' : 'Fachabteilung'?></label>
			<select id="fachabteilung">
				<option value="all" selected><?=$language !== 'de' ? 'All' : 'Alle'?></option>
				<?php
					foreach($departmentList as $key => $value) {
						?>
						<option value="<?=$value?>"><?=$value?></option>
						<?php
					}
				?>
			</select>
		</div>
		<?php
	}
?>
