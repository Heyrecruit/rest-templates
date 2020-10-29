<div class="customSelect">
	<select class="form-control" name="<?=$fieldName?>" id="scope_document_type" data-question-id="<?=$questionId?>">
		<option value="">Bitte wählen</option>
		<?php
			foreach(explode(";", $fieldValue) as $k => $v) {
				$optionVal = $v;

				switch($v) {
					case'Bewerbungsbild':
					case'Application image':
						$optionVal = 'picture';
						break;
					case 'Anschreiben':
					case 'Cover letter':
						$optionVal = 'covering_letter';
						break;
					case 'Lebenslauf':
					case 'CV':
						$optionVal = 'cv';
						break;
					case 'Zeugnis/Bescheinigung':
					case 'Certificate':
						$optionVal = 'certificate';
						break;
					case 'Sonstiges':
					case 'Other':
						$optionVal = 'other';
						break;
				}

				echo '<option value="' . $optionVal . '">' . $v . '</option>';
			}
		?>
	</select>
	<div class="arrow"></div>
</div>
