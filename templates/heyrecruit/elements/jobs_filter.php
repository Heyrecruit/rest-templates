<?php
   if (empty($company['OverviewPage']['filter'])) {
      $filterCount = 0;
   } else {
      $filterCount = substr_count($company['OverviewPage']['filter'], ';') + 1;
   }

	$noMap       = "";
   $filterClass = "";

   ?><!--<pre><?/*= $company['OverviewPage']['filter'] */?></pre>--><?php

	if(!$company['OverviewPage']['show_map']) {
		$noMap = ' no-map';
	}

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

<div class="row <?= $filterClass ?><?=$noMap?>" id="job-filters">
	<?php
		if(
			strpos($company['OverviewPage']['filter'], 'location') !== false ||
			strpos($company['OverviewPage']['filter'], 'search') !== false
		){
	?>
			<div class="col-12 col-md-4">
            <div class="select-container">
					<input id="standort" type="text"
					       placeholder="<?=$language != 'de' ? 'Search for ZIP code/location' : 'Nach PLZ/Ort suchen'?>">
					<i class="fal fa-search"></i>
				</div>
			</div>
	<?php
      }

   if (strpos($company['OverviewPage']['filter'], 'list') !== false) {
      ?>
      <div class="col-12 col-md-4">
         <div class="select-container">
            <select id="location-list">
               <option value="all" selected><?= $language !== 'de' ? 'All locations' : 'Alle Standorte' ?></option>
               <?php
               foreach ($company['CompanyLocation'] as $key => $value) {
                  ?>
                  <option value="<?= $key ?>"><?= $value ?></option>
                  <?php
               }
               ?>
            </select> <i class="far fa-angle-down"></i>
         </div>
      </div>
      <?php
   }
   ?>

	<?php
		if(strpos($company['OverviewPage']['filter'], 'employment') !== false) {
			?>
			<div class="col-12 col-md-4">
				<div class="select-container">
					<select id="einstellungsart">
						<option value="all"
						        selected><?=$language != 'de' ? 'All types of employment' : 'Alle Einstellungsarten'?></option>
						<?php
							foreach($employmentList as $key => $value) {
								?>
								<option value="<?=$key?>"><?=$value?></option>
								<?php
							}
						?>
					</select>
					<i class="far fa-angle-down"></i>
				</div>
			</div>
			<?php
		}

		if(strpos($company['OverviewPage']['filter'], 'department') !== false) {
			?>
			<div class="col-12 col-md-4">
            <div class="select-container">
					<select id="fachabteilung">
						<option value="all"
						        selected><?=$language != 'de' ? 'All departments' : 'Alle Fachbereiche'?></option>
						<?php
							foreach($departmentList as $key => $value) {
								?>
								<option value="<?=$value?>"><?=$value?></option>
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
