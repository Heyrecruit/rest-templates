
<div class="customSelect">
	<select class="form-control" name="com" id="scope-location-select" data-job-id="<?=$jobId?>">
		<option value=""><?= $language != 'de' ? 'Select location' : 'Standort wählen' ?></option>
		<?php
			foreach($vars['job']['active_company_location_jobs'] as $k => $v) {
				$formattedLocation = HeyUtility::getFormattedAddress($v);
				
				if($locationId == $v['company_location_id']) {
					echo '<option value="' . $v['company_location_id'] . '" selected>' . HeyUtility::h($formattedLocation). '</option>';
				} else {
					echo '<option value="' . $v['company_location_id'] . '">' . HeyUtility::h($formattedLocation) . '</option>';
				}
			}
		?>
	</select>
	<div class="arrow"></div>
</div>
