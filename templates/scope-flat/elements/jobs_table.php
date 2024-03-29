<?php

	if(!isset($scope)){
		include __DIR__ . '/../../../ini.php';
	}

	if(!isset($jobs)){
		$jobs = $scope->getJobs($company['Company']['id']);

		if($jobs['status_code'] == 200) {
			$jobs    = $jobs['data'];
		}
	}


?>
<div id="scope-jobs-table-desktop-wrap">
	<div class="row">
		<div class="col-12">
			<table id="scope-jobs-table-desktop">
				<thead>
					<tr>

						<th><?=$language !== 'de' ? 'Job' : 'Offene Stellen'?></th>
						<?php

							if(strpos($company['OverviewPage']['job_table_categories'], 'location') !== false) {
						?>
								<th><?=$language !== 'de' ? 'Location' : 'Standort'?></th>
						<?php
							}
							if(strpos($company['OverviewPage']['job_table_categories'], 'employment') !== false) {
						?>
								<th><?=$language !== 'de' ? 'Employment type' : 'Einstellungsart'?></th>
						<?php
							}

							if(strpos($company['OverviewPage']['job_table_categories'], 'department') !== false) {
						?>
								<th><?=$language !== 'de' ? 'Department' : 'Fachabteilung'?></th>
						<?php
							}
						?>
						<th></th>
					</tr>
				</thead>
				<tbody>
				<?php
					$publicationUrl = !empty($company['CompanySetting']['scope_publication_url']) ? $company['CompanySetting']['scope_publication_url'] : '';
					//$publicationUrl = $company['Company']['id'] == 587 ? 'https://gemtec.eu/karriereportal/' : $publicationUrl;
					//$publicationUrl = $company['Company']['id'] == 574 ? 'https://neylux.com/karriere/' : $publicationUrl;

					foreach($jobs as $key => $value) {

						if(!empty($value['CompanyLocationJob'])) {

							foreach($value['CompanyLocationJob'] as $k => $v) {
				?>
								<tr>
									<td>
										<a title="<?=$value['Job']['title']?>" href="<?=$publicationUrl?>?page=job&id=<?=$value['Job']['id']?>&location=<?=$v['company_location_id']?>&language=<?=$language?>" target="_blank" class="primary-color secondary-color-hover "><?=$value['Job']['title']?></a>
									</td>
									<?php
										if(strpos($company['OverviewPage']['job_table_categories'], 'location') !== false) {
									?>
											<td>
												<div>
													<i class="fas fa-map-marker-alt primary-color"></i>
													<span>
														<?php
															$formattedAddress = $scope->getFormattedAddress($v, false, true, false);

															if(empty($formattedAddress)){
																$formattedAddress = $scope->getFormattedAddress($v, true, true, true);
															}

															if($language !== 'de'){
																$formattedAddress = str_replace('Deutschland', 'Germany', $formattedAddress);
															}

															echo $formattedAddress;
														?>
													</span>
												</div>
											</td>
											<?php
										}
										if(strpos($company['OverviewPage']['job_table_categories'], 'employment') !== false) {
									?>
											<td>
												<div>
													<i class="far fa-clock primary-color"></i>
													<span>
														<?php
															if(strpos($value['Job']['employment'], ',') !== false) {
																echo implode(', ', explode(',', $value['Job']['employment']));
															} else {
																echo $value['Job']['employment'];
															}
														?>
													</span>
												</div>
											</td>
									<?php
										}

										if(strpos($company['OverviewPage']['job_table_categories'], 'department') !== false) {
									?>
											<td>
												<div>
													<span>
														<?php
															echo $value['Job']['department'];
														?>
													</span>
												</div>
											</td>
									<?php
										}
									?>
									<td>
										<a href="<?=$publicationUrl?>?page=job&id=<?=$value['Job']['id']?>&location=<?=$v['company_location_id']?>&language=<?=$language?>" target="_blank"><i class="fas fa-chevron-right primary-color"></i></a>
									</td>
								</tr>
				<?php
							}
						}
					}
				?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<div id="scope-jobs-table-mobile-wrap">
	<div class="row">
		<?php
        $rowSpan = 1;
        if(strpos($company['OverviewPage']['job_table_categories'], 'location') !== false) {
            $rowSpan +=1;
        }
        if(strpos($company['OverviewPage']['job_table_categories'], 'employment') !== false) {
            $rowSpan +=1;
        }
        if(strpos($company['OverviewPage']['job_table_categories'], 'department') !== false) {
            $rowSpan +=1;
        }
			foreach($jobs as $key => $value) {

				if(!empty($value['CompanyLocationJob'])) {

					foreach($value['CompanyLocationJob'] as $k => $v) {
		?>
					<div class="col-12 col-md-6">

						<table class="scope-jobs-table-mobile">
							<tr>
								<td>
									<a href="<?=$publicationUrl?>?page=job&id=<?=$value['Job']['id']?>&location=<?=$v['company_location_id']?>&language=<?=$language?>" target="_blank" class="primary-color"><?=$value['Job']['title']?></a>
								</td>
								<td class="scope-jobs-table-mobile-angle" rowspan="<?=$rowSpan?>">
									<a href="<?=$publicationUrl?>?page=job&id=<?=$value['Job']['id']?>&location=<?=$v['company_location_id']?>&language=<?=$language?>" target="_blank"><i class="fas fa-chevron-right primary-color"></i></a>
								</td>
							</tr>
							<?php
								if(strpos($company['OverviewPage']['job_table_categories'], 'location') !== false) {
							?>
									<tr>
										<td>
											<div>
												<i class="fas fa-map-marker-alt primary-color"></i>
												<span>
											<?php
												$formattedAddress = $scope->getFormattedAddress($v, false, true, false);

												if(empty($formattedAddress)) {
													$formattedAddress = $scope->getFormattedAddress($v, true, true, true);
												}
												echo $formattedAddress;
											?>
										</span>
											</div>
										</td>
									</tr>
							<?php
								}
								if(strpos($company['OverviewPage']['job_table_categories'], 'employment') !== false) {
							?>
									<tr>
										<td>
											<div>
												<i class="far fa-clock primary-color"></i>
												<span><?=$value['Job']['employment']?></span>
											</div>
										</td>
									</tr>
							<?php
								}

								if(strpos($company['OverviewPage']['job_table_categories'], 'department') !== false) {
							?>
									<tr>
										<td>
											<div>
												<span><?=$value['Job']['department']?></span>
											</div>
										</td>
									</tr>
							<?php
								}
							?>

						</table>
					</div>
		<?php
					}
				}
			}
		?>
	</div>
</div>
