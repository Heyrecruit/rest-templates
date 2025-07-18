<?php
if(!empty($modalValue)){
	
	    $modalValue = HeyUtility::decodeJsonString($modalValue);
      
        if ($modalValue !== null) {
            
            $privacyPoliceClass = $fieldName === 'consent_form_accepted' ? 'scope_open_modal primary-color privacy_police' : 'scope_open_modal primary-color';
	
	        $openModalHtml =
		        '<a class="'.$privacyPoliceClass.'"
				href="#modal' . $uniqueFieldId . '"
				data-toggle="modal"
				data-target="#modal' . $uniqueFieldId . '">' . $modalValue['href'] .
		        '</a>';
	
	        $tmpValue = str_replace($modalValue['href'], $openModalHtml, $fieldValue);
?>

            <div class="customCheckbox no-label">
		        <?php
			        $checked = $answer == 1 ? 'checked' : '';
		        ?>
                <input type="checkbox" id="<?=$uniqueFieldId?>" name="<?=$fieldName?>" data-question-id="<?=$questionId?>" <?=$checked?>>
                <label class="scope_border_color" for="<?=$uniqueFieldId?>"></label>
                <div class="label"><?=strip_tags($tmpValue, ['a'])?></div>
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
                            <p><?=nl2br($modalValue['value'])?></p>
                        </div>
                        <div class="modal-footer">
                        </div>
                    </div>
                </div>
            </div>
<?php
        }
}
