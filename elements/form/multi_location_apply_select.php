<?php
	$applyOnMultiLocationsEnabled = $vars['job']['form_settings']['apply_on_multi_locations'] ?? false;
	
	if($applyOnMultiLocationsEnabled && count($activeCompanyLocationJobs) > 1) {
        
        $applyOnMultiLocationsHeadline = $language !== 'de' ? 'Apply to additional locations' : 'Bewerbung an weiteren Standorten';
        $applyOnMultiLocationsText     = $language !== 'de' ? 'Select additional location' : 'Wähle weitere Standorte aus';
        $applyOnMultiLocationsTooltip  = $language !== 'de' ? 'This job opening has been advertised at multiple locations. You can apply to additional locations with one application. Simply select your preferred locations from the menu below.' : 'Diese Stellenanzeige wurde an mehreren Standorten ausgeschrieben. Du kannst Dich mit einer Bewerbung zusätzlich an weiteren Standorten bewerben. Wähle hierfür einfach im nachfolgenden Menu Deine Wunschstandorte aus.';
?>
        <h3><?=$applyOnMultiLocationsHeadline?></h3>
        <div class="hey-form-row">
            <span class="formText">
                <?=$applyOnMultiLocationsText?>
                <span class="custom-tooltip">
                    <i class="fa fa-question-circle" aria-hidden="true"></i>
                    <span class="custom-tooltip-wrapper">
                        <?=$applyOnMultiLocationsTooltip?>
                    </span>
                </span>
            </span>
            <select class="form-control d-none" id="applyOnMoreLocations" multiple="multiple" name="apply_on_multi_locations">
                <?php
                    foreach ($activeCompanyLocationJobs as $companyLocationJob) {
                        
                        if($companyLocationJob['company_location_id'] == $locationId){
                            continue;
                        }
                ?>
                        <option value="<?=$companyLocationJob['company_location_id']?>">
                            <?=$companyLocationJob['company_location']['full_address']?>
                        </option>
                <?php
                    }
                ?>
            </select>
        </div>
<?php
	}