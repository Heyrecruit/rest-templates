<?php
    $applyWithWhatsappEnabled = $vars['job']['form_settings']['apply_with_whatsapp'] ?? false;
	
    if($applyWithWhatsappEnabled) {
	    
	    $number = $vars['job']['form_settings']['whatsapp_number'] ?? HeyUtility::env('DEFAULT_WHATSAPP_NUMBER');
        $numberNoBlanks = str_replace(' ', '', $number);

        if($number !== false) {
	        
	        $text = 'Bewerbung starten: '. $jobId . '_' . $locationId;
	        $url = "https://wa.me/$numberNoBlanks?text=$text";
?>

            <a id="whatsapp_apply_btn_mobile" href="<?=$url?>" class="whatsapp_apply_btn d-none" target="_blank" aria-label="Bewerben mit WhatsApp">
                <!--Button only on mobile devices-->
                <i class="fab fa-whatsapp"></i>
		        <?= $vars['language'] != 'de' ? 'Apply with WhatsApp' : 'Bewirb Dich jetzt mit WhatsApp' ?>
            </a>

            <div class="whatsapp_apply_btn" id="whatsapp_toggle_button">
                <!--Button only on desktop devices-->
                <span class="wa-show" role="button" aria-label="Bewerben mit WhatsApp">
                    <i class="fab fa-whatsapp"></i>
                    <?= $vars['language'] != 'de' ? 'Apply with WhatsApp' : 'Bewirb Dich mit WhatsApp' ?>
                </span>
                <div class="bt-show d-none" role="button" aria-label="Zurück zum Bewerbungsformular">
                    <i class="far fa-angle-left mr-1"></i>
			        <?= $vars['language'] != 'de' ? 'Back to form' : 'Zurück zum Formular' ?>
                </div>
            </div>


            <div class="wa-divide mt-4">
                <span class="line"></span>
                <span class="wording"><?= $vars['language'] != 'de' ? 'or' : 'oder' ?></span>
                <span class="line"></span>
            </div>
            
            <div class="wa-link-container mt-4 d-none">
                <div class="col-12 qr" role="img" aria-label="QR-Code zum Starten einer Bewerbung über WhatsApp">
			        <?= $vars['language'] != 'de' ? 'If you would like to apply via mobile, simply use the QR code:' : 'Wenn Du Dich mit Deinem mobilen Gerät bewerben möchtest, dann verwende doch einfach den QR-Code:' ?>
                    <img id="qrcode" src="https://quickchart.io/qr?text=<?=urlencode($url)?>" width="200" />
                </div>
                <div class="col-12 link">
			        
			        
			        <?= $vars['language'] != 'de' ? 'Would you like to apply with this device? Then click the button below:' : 'Du möchtest Dich mit diesem Gerät bewerben? Dann klicke auf den nachfolgenden Button:' ?>
                    <a href="<?=$url?>" class="whatsapp_apply_btn mt-3" id="whatsapp_apply_btn_event" target="_blank" aria-label="Bewerben mit WhatsApp">
                        <i class="fab fa-whatsapp"></i>
				        <?= $vars['language'] != 'de' ? 'Apply with WhatsApp' : 'Bewirb Dich jetzt mit WhatsApp' ?>
                    </a>
                </div>
            </div>
<?php
        }
        
    }
