<?php
	/** @var array $company */
	/** @var array $value */
	/** @var array $v */
	/** @var string $url */
	/** @var string $language */
	/** @var HeyUtility $utility */
	
?>

<div class="row">
	<div class="col-12">
		<div class="job-tile" role="listitem">
			<div class="job-info-wrap">
				<a target="_blank" href="<?=$url?>"
				   onclick="jobClickEventListener(<?php echo htmlspecialchars(json_encode($value)); ?>)">
					<h2 class="primary-color"><?=HeyUtility::h($value['job_strings'][0]['title'])?></h2>
				</a>
				<div>
					<?php
						if (str_contains($company['overview_page']['job_table_categories'], 'location')) {
					?>
							<span>
								<?php
									$moreLocationsText = $language !== 'de' ? 'more' : ' weitere';
         
									$formattedAddress = HeyUtility::getFormattedAddress(
										$v, false, true, false, false
									);
									
									if (empty($formattedAddress)) {
										$formattedAddress = HeyUtility::getFormattedAddress($v);
									}
         
									if(count($value['company_location_jobs']) == 2){
										$formattedAddressTwo = HeyUtility::getFormattedAddress(
											$value['company_location_jobs'][1], false, true, false, false
										);
										
										if (empty($formattedAddressTwo)) {
											$formattedAddressTwo = HeyUtility::getFormattedAddress($value['company_location_jobs'][1]);
										}
										
										$formattedAddress .= ', ' . $formattedAddressTwo;
                                    
                                    }elseif(count($value['company_location_jobs']) > 2){
										$formattedAddress .= ', ' . (count($value['company_location_jobs'])-1) . ' ' .$moreLocationsText;
									}
										
									if (!empty($formattedAddress)) {
										echo '<i class="fal fa-map-marker-alt"></i>' .
											HeyUtility::h($formattedAddress);
									}
								?>
						   </span>
					<?php
						}
						if (str_contains($company['overview_page']['job_table_categories'], 'employment')) {
					?>
							<span>
								 <?php
									 if (!empty($value['job_strings'][0]['employment'])) {
										 echo '<i class="fal fa-clock"></i>' . HeyUtility::h(
												 implode(', ',
													 explode(',', $value['job_strings'][0]['employment'])
												 )
											 );
									 }
								 ?>
						    </span>
					<?php
						}
						
						if (str_contains($company['overview_page']['job_table_categories'], 'department')) {
					?>
							<span>
								<?php
									if (!empty($value['job_strings'][0]['department'])) {
										echo '<i class="fal fa-hashtag"></i>' . HeyUtility::h(
												trim($value['job_strings'][0]['department'])
											);
									}
								?>
						   </span>
					<?php
						}
					?>
				</div>
			</div>
			<a class="btn btn-primary" target="_blank" href="<?=$url?>"
			   onclick="jobClickEventListener(<?php echo htmlspecialchars(json_encode($value)); ?>)">
				<?= $language != 'de' ? 'Details' : 'Zur Stellenanzeige' ?>
			</a>
		</div>
	</div>
</div>