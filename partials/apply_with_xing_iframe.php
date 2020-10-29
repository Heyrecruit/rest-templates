<?php

	if(isset($jobId) && isset($locationId)) {
?>
		<iframe src="<?=$_ENV['SCOPE_URL']?>applicants/xing_iframe/<?=$jobId?>/<?=$locationId?>"></iframe>
<?php
	}
