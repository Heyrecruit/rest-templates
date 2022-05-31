<div class="formInput">
	<?php
		$requiredText = isset($requiredText) ? $requiredText : '';
	?>
	<textarea class="form-control" rows="3" name="<?=$fieldName?>" placeholder="<?=$placeholder?>" id="<?=$uniqueFieldId?>" required="<?=$requiredText?> " type="text"
	          data-question-id="<?=$questionId?>"></textarea>
</div>
