<?php

	$filterCount = 0;
	$colClass    = 'col-md-12';

	if(
		str_contains($company['overview_page']['filter'], 'list') ||
		str_contains($company['overview_page']['filter'], 'location') ||
		str_contains($company['overview_page']['filter'], 'search')
	) {
		$filterCount++;
	}

	if(str_contains($company['overview_page']['filter'], 'employment')) {
		$filterCount++;
	}

	if(str_contains($company['overview_page']['filter'], 'department')) {
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
		str_contains($company['overview_page']['filter'], 'location') ||
		str_contains($company['overview_page']['filter'], 'search')
	) {
		?>
		<div class="col-12 location-search <?=$colClass?>">
			<label for="standort"><?=$language !== 'de' ? 'Location' : 'Standort'?></label>
			<input id="standort" type="text" placeholder="<?=$language !== 'de' ? 'Postcode/town' : 'PLZ/Ort'?>">
            <i class="fal fa-search"></i>
        </div>
		<?php
	}

	if(str_contains($company['overview_page']['filter'], 'list')) {
		?>
		<div class="col-12 <?=$colClass?>">
			<label for="location-list"><?=$language !== 'de' ? 'Location' : 'Standort'?></label>
			<select id="location-list">
                <option value="all" selected>
					<?=$company['language_id'] !== 1 ? 'All locations' : 'Alle Standorte'?>
                </option>
				<?php
					foreach ($company['company_locations'] as $key => $value) {
						?>
                        <option value="<?=HeyUtility::h($key)?>"><?=HeyUtility::h($value)?></option>
						<?php
					}
				?>
			</select>
		</div>
		<?php
	}
?>

<?php
	if(str_contains($company['overview_page']['filter'], 'employment')) {
		?>
		<div class="col-12 <?=$colClass?>">
			<label for="einstellungsart"><?=$language !== 'de' ? 'Employment type' : 'Einstellungsart'?></label>
			<select id="einstellungsart">
				<option value="all" selected><?=$language !== 'de' ? 'All' : 'Alle'?></option>
				<?php
					foreach($employmentList as $key => $value) {
						?>
                        <option value="<?=HeyUtility::h($key)?>">
                            <?php
                            if($company['language_id'] !== 1) {
                                echo HeyUtility::h($value['en']);
                            }else{
                                echo HeyUtility::h($value['de']);
                            }
                            ?>
                        </option>
						<?php
					}
				?>



			</select>
		</div>
		<?php
	}

	if(strpos($company['overview_page']['filter'], 'department') !== false) {
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
