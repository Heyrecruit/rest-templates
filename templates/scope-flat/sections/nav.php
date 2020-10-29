<?php

	$logoUrl = '';
	if(!empty($company) && isset($company['Company']['logo'])) {
		$logoUrl = $company['Company']['logo'];
	}

?>
<header class="row no-gutters">
	<div class="col-12">
		<a href="#scope-jobs-intro-section-hl-wrap"><img id="logo" class="float-left" src="<?=$logoUrl?>" alt="<?=$company['Company']['name']?> Logo"></a>

		<nav class="float-right">
			<i id="mobile-nav-trigger" class="fas fa-bars"></i>
			<ul id="nav">
				<?php
					if($page == 'job') {

						if(!empty($job) && isset($job['Navigation'])){

							foreach($job['Navigation'] as $key => $value){
				?>
								<li>
									<a class="primary-color-hover scope-navigation" href="#section<?=$key?>"><?=$value['name']?></a>
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
			<div id="lang">
				<i  class="fas fa-globe-americas primary-color-hover"></i>
				<ul>
					<li>
						<a class="primary-bg-hover" data-language="de">Deutsch</a>
					</li>
				</ul>
			</div>
		</nav>
	</div>
</header>


