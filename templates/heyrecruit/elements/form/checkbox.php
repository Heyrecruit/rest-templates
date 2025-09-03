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

		$checked    = str_contains($answer, $v) ? 'checked' : '';

?>
		<div class="modernCustomCheckbox">
			<input type="checkbox" class="form-control" id="<?=$checkboxId?>" name="<?=$fieldName?>[<?=$v?>]"
			       data-question-id="<?=$questionId?>" <?=$checked?> <?=$requiredField?>>
            <i class="far fa-check primary-color"></i>
			<label class="scope_border_color" for="<?=$checkboxId?>"><?=HeyUtility::h($v)?></label>
		</div>
<?php
	}
