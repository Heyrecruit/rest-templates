<?php
/** @var string $answer */
/** @var string $fieldValue */
/** @var string $fieldName */
/** @var string $questionId */
/** @var string $uniqueFieldId */
/** @var string $language */
/** @var string $requiredField */
?>

<div class="customSelect">
	<select class="form-control" name="<?=$fieldName?>" id="<?=$uniqueFieldId?>" data-question-id="<?=$questionId?>" <?=$requiredField?>>
		<option value=""><?= $language != 'de' ? 'Please select' : 'Bitte wählen' ?></option>
		<?php
            $fieldValues = strpos($fieldValue, ';')
                ? explode(";", $fieldValue)
                : explode(",", $fieldValue);
           
			foreach($fieldValues as $k => $v) {
				$optionVal = $v;

				if($answer == $v) {
					echo '<option value="' . $optionVal . '" selected>' . HeyUtility::h($v). '</option>';
				} else {
					echo '<option value="' . $optionVal . '">' . HeyUtility::h($v) . '</option>';
				}
			}
		?>
	</select>
	<div class="arrow"></div>
</div>
