<?php

	foreach(explode(";", $fieldValue) as $key => $v) {
		$checkboxId = uniqid();
		$checked    = strpos($answer, $v) !== false ? 'checked' : '';

		?>
		<div class="customCheckbox">
			<input type="checkbox" class="form-control" id="<?=$checkboxId?>" name="<?=$fieldName?>[<?=$v?>]"
			       data-question-id="<?=$questionId?>" <?=$checked?>>
			<label class="scope_border_color" for="<?=$checkboxId?>"></label>
			<div class="label"><?=$v?></div>
		</div>
		<?php
	}
