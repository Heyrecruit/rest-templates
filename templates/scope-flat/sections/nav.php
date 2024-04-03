<?php
	/** @var array $company */
	/** @var string $logoUrl */
	/** @var string $page */
	
	$language = empty($language) ? 'de' : $language;
	
	$languageTitles = isset($job) ? $job['languages']['titles'] : $company['languages']['titles'];
	$languageShortCodes = isset($job) ? $job['languages']['shortcodes'] : $company['languages']['shortcodes'];
	
	if(!in_array($language, $languageShortCodes)) {
		$language = 'de';
	}
 
	$logoUrl = $company['logo'];
	
	$languageId = array_search($language, $languageShortCodes);
?>

<header class="row no-gutters">
	<div class="col-12">
		<a href="#scope-jobs-intro-section-hl-wrap">
            <img id="logo" class="float-left" src="<?=$logoUrl?>" alt="<?=HeyUtility::h($company['name'])?> Logo">
        </a>

		<nav class="float-right">
			<i id="mobile-nav-trigger" class="fas fa-bars"></i>
			<ul id="nav">
				<?php
					if($page == 'job') {
						if(!empty($job) && isset($job['navigation'])){
							foreach($job['navigation'] as $key => $value){
				?>
								<li>
									<a class="primary-color-hover scope-navigation" href="#section<?=$key?>">
                                        <?=HeyUtility::h($value['name'])?>
                                    </a>
								</li>
				<?php
							}
						}
				?>
						<li class="border-left">
							<a class="primary-color-hover" href="/"><i class="fas fa-home"></i></a>
						</li>
				<?php
					}
				?>
			</ul>
            <?php
                if (count($languageTitles) > 1) {
            ?>
			<div id="lang">
				<i  class="fas fa-globe-americas primary-color-hover"></i>
				<ul>
				
					<?php
						foreach ($languageTitles as $key => $value) {
					?>
                            <li>
                                <a class="primary-bg-hover" data-language="<?= HeyUtility::h($languageShortCodes[$key]) ?>">
									<?= HeyUtility::h($value) ?>
                                </a>
                            </li>
					<?php
						}
					?>

				</ul>
			</div>
            <?php
                }
            ?>
		</nav>
	</div>
</header>


