<div class="customSelect">
	<select class="form-control" name="<?=$fieldName?>" id="<?=$uniqueFieldId?>" data-question-id="<?=$questionId?>">
		<option value=""><?= $language != 'de' ? 'Please select' : 'Bitte wählen' ?></option>
		<?php
			foreach(explode(";", $fieldValue) as $k => $v) {
				$optionVal = $v;

				if($answer == $v) {
					echo '<option value="' . $optionVal . '" selected>' . $v. '</option>';
				} else {
					echo '<option value="' . $optionVal . '">' . $v . '</option>';
				}
			}
		?>
	</select>
	<div class="arrow"></div>
</div>
