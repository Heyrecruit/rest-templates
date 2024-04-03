<?php
	/** @var array $company */
	/** @var string $language */
	/** @var array $employmentList */
 
    if(empty($company['overview_page']['filter'])){
	    $filterCount = 0;
    }else{
	    $filterCount = substr_count($company['overview_page']['filter'], ';') + 1;
    }
    
	$noMap = !$company['overview_page']['show_map'] ? ' no-map' : '';
	
	$filterClass = '';
	switch ($filterCount) {
		case 1:
			$filterClass = 'one-filter';
			break;
		case 2:
			$filterClass = 'two-filters';
			break;
		case 3:
			$filterClass = 'three-filters';
			break;
		default:
			$filterClass = 'no-filter';
			break;
	}
?>

<div class="row <?=$filterClass?><?=$noMap?>" id="job-filters">
	<?php
		if(
			str_contains($company['overview_page']['filter'], 'location') ||
			str_contains($company['overview_page']['filter'], 'search')
		){
	?>
			<div class="col-12 col-md-4">
            <div class="select-container">
					<input id="standort" type="text"
                           placeholder="<?=$company['language_id'] !== 1 ? 'Search for ZIP code/location' : 'Nach PLZ/Ort suchen'?>">
					<i class="fal fa-search"></i>
				</div>
			</div>
    <?php
        }

        if (str_contains($company['overview_page']['filter'], 'list')) {
    ?>
            <div class="col-12 col-md-4">
                <div class="select-container">
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
                    <i class="far fa-angle-down"></i>
                </div>
            </div>
   <?php
   }
   ?>

	<?php
  
		if(str_contains($company['overview_page']['filter'], 'employment')) {
			?>
			<div class="col-12 col-md-4">
				<div class="select-container">
					<select id="einstellungsart">
						<option value="all"
						        selected><?=$company['language_id'] !== 1 ? 'All types of employment' : 'Alle Einstellungsarten'?></option>
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
					<i class="far fa-angle-down"></i>
				</div>
			</div>
			<?php
		}
  
		if(str_contains($company['overview_page']['filter'], 'department')) {
			?>
			<div class="col-12 col-md-4">
            <div class="select-container">
					<select id="fachabteilung">
						<option value="all" selected><?=$company['language_id'] !== 1 ? 'All departments' : 'Alle Fachbereiche'?></option>
						<?php
							foreach($departmentList as $key => $value) {
						?>
								<option value="<?=HeyUtility::h($value)?>"><?=HeyUtility::h($value)?></option>
						<?php
							}
						?>
					</select>
					<i class="far fa-angle-down"></i>
				</div>
			</div>
			<?php
		}
	?>
</div>
