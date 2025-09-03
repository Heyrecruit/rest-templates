<?php
/** @var string $answer */
/** @var string $fieldValue */
/** @var string $fieldName */
/** @var string $questionId */
/** @var string $uniqueFieldId */
/** @var string $language */
/** @var string $requiredField */
?>
<div class="formInput">
    <input value="<?=$answer?>"
           class="form-control"
           name="<?=$fieldName?>"
           placeholder="<?=$placeholder?>"
           id="<?=$uniqueFieldId?>"
           type="text"
           data-question-id="<?=$questionId?>"
           aria-describedby="Formularfeld <?=$fieldName?>" <?=$requiredField?>>
</div>
