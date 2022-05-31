<div class="customSelect">
	<select class="form-control scope_document_type" name="<?=$fieldName?>" id="scope_document_type_<?=$questionId?>" data-question-id="<?=$questionId?>" data-language="<?=$language?>">
		<option value=""><?= $language !== 'de' ? 'Please select' : 'Bitte wählen'?></option>
		<?php
			foreach(explode(";", $fieldValue) as $k => $v) {
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

				echo '<option value="' . $optionVal . '">' . $v . '</option>';
			}
		?>
	</select>
	<div class="arrow"></div>
</div>
