<?php

/** @var string $answer */
/** @var string $fieldValue */
/** @var string $fieldName */
/** @var string $questionId */
/** @var string $uniqueFieldId */

if(!empty($modalValue)){
	
	$modalValue = json_decode($modalValue, true);
	
	// Überprüfen Sie, ob das Ergebnis immer noch ein String ist.
	if (is_string($modalValue)) {
		$modalValue = json_decode($modalValue, true);
	}
	
	$privacyPoliceClass = $fieldName === 'consent_form_accepted' ? 'scope_open_modal primary-color privacy_police' : 'scope_open_modal primary-color';
	
	$openModalHtml =
		'<a class="'.$privacyPoliceClass.'"
				href="#modal' . $uniqueFieldId . '"
				data-toggle="modal"
				data-target="#modal' . $uniqueFieldId . '">' . $modalValue['href'] .
		'</a>';
	
	
	$tmpValue = str_replace($modalValue['href'], $openModalHtml, $fieldValue);
?>

	<div class="modernCustomCheckbox">
		<?php
			$checked = $answer == 1 ? 'checked' : '';
		?>
		<input type="checkbox" id="<?=$uniqueFieldId?>" name="<?=$fieldName?>" data-question-id="<?=$questionId?>" <?=$checked?>>
        <i class="far fa-check primary-color"></i>
		<label class="scope_border_color label" for="<?=$uniqueFieldId?>"><?=strip_tags($tmpValue, ['a'])?>
            <?php
            if ($title === 'Einverständniserklärung') {
                ?>
                <?=HeyUtility::h($required)?>
                <?php
            }
            ?>
        </label>
	</div>

	<div id="modal<?=$uniqueFieldId?>" class="modal fade in">
		<div class="modal-dialog modal-info" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title"><?=HeyUtility::h($modalValue['title'])?></h4>
					<a class="close" aria-hidden="true" data-dismiss="modal">
						<i class="fal fa-times" aria-hidden="true"></i>
					</a>
				</div>
				<div class="modal-body">
					<p><?=nl2br(HeyUtility::h($modalValue['value'] ?? ''))?></p>
				</div>
				<div class="modal-footer">
				</div>
			</div>
		</div>
	</div>
<?php
}
