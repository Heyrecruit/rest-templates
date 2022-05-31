<?php

	foreach(explode(";", $fieldValue) as $key => $v) {
		$checkboxId = uniqid();
		$checked    = strpos($answer, $v) !== false ? 'checked' : '';

		?>
		<div class="modernCustomCheckbox">
			<input type="checkbox" class="form-control" id="<?=$checkboxId?>" name="<?=$fieldName?>[<?=$v?>]"
			       data-question-id="<?=$questionId?>" <?=$checked?>>
            <i class="far fa-check primary-color"></i>
			<label class="scope_border_color" for="<?=$checkboxId?>"><?=$v?></label>
		</div>
		<?php
	}
