<?php

	$modalValue = json_decode($modalValue, true);

	$openModalHtml = '<a class="scope_open_modal primary-color" href="#modal' . $uniqueFieldId . '" data-toggle="modal" data-target="#modal' . $uniqueFieldId . '">' . $modalValue['href'] . '</a>';
	$tmpValue = str_replace($modalValue['href'], $openModalHtml, $fieldValue);
?>

<div class="customCheckbox checkbox-with-modal no-label">
	<?php
		$checked = $answer == 1 ? 'checked' : '';
	?>
	<input type="checkbox" class="form-control" id="<?=$uniqueFieldId?>" name="<?=$fieldName?>" data-question-id="<?=$questionId?>" <?=$checked?>>
	<label class="" for="<?=$uniqueFieldId?>"></label>
	<div class="label"><?=$tmpValue?></div>
</div>

<div id="modal<?=$uniqueFieldId?>" class="modal fade in">
	<div class="modal-dialog modal-info" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><?=$modalValue['title']?></h4>
				<a class="close" aria-hidden="true" data-dismiss="modal">
					<i class="fa fa-times" aria-hidden="true"></i>
				</a>
			</div>
			<div class="modal-body">
				<p><?=$modalValue['value']?></p>
			</div>
			<div class="modal-footer">
			</div>
		</div>
	</div>
</div>
