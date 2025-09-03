<?php
    /** @var string $answer */
    /** @var string $fieldValue */
    /** @var string $fieldName */
    /** @var string $questionId */
    /** @var string $requiredField */

	$fieldValues = strpos($fieldValue, ';')
		? explode(";", $fieldValue)
		: explode(",", $fieldValue);
  
	foreach($fieldValues as $key => $v) {
		$checkboxId = uniqid();
		$checked    = strpos($answer, $v) !== false ? 'checked' : '';

		?>
		<div class="customCheckbox">
			<input type="checkbox" id="<?=$checkboxId?>" name="<?=$fieldName?>[<?=$v?>]"
			       data-question-id="<?=$questionId?>" <?=$checked?> <?=$requiredField?>>
			<label class="scope_border_color label" for="<?=$checkboxId?>"><?=HeyUtility::h($v)?></label>
		</div>
		<?php
	}
