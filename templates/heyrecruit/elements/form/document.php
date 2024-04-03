<?php
/** @var string $answer */
/** @var string $fieldValue */
/** @var string $fieldName */
/** @var string $questionId */
/** @var string $uniqueFieldId */
/** @var string $language */
?>

<div class="customSelect">
	<select class="form-control scope_document_type" name="<?=$fieldName?>" id="scope_document_type_<?=$questionId?>" data-question-id="<?=$questionId?>">
        <option value=""><?=$language != 'de' ? 'Please select' : 'Bitte wählen'?></option>
		<?php
			
			$fieldValues = str_contains($fieldValue, ';')
				? explode(";", $fieldValue)
				: explode(",", $fieldValue);
    
			foreach($fieldValues as $k => $v) {
				$optionVal = $v;

				switch($v) {
					case'Bewerbungsbild':
						$optionVal = 'picture';
						break;
					case 'Anschreiben':
						$optionVal = 'covering_letter';
						break;
					case 'Lebenslauf':
						$optionVal = 'cv';
						break;
					case 'Zeugnis/Bescheinigung':
						$optionVal = 'certificate';
						break;
					case 'Sonstiges':
						$optionVal = 'other';
						break;
				}

				echo '<option value="' . $optionVal . '">' . HeyUtility::h($v) . '</option>';
			}
		?>
	</select>
    <i class="far fa-angle-down"></i>
</div>
