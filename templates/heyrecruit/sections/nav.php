<?php
	/** @var array $company */
 
	$language = empty($language) ? 'de' : $language;
 
	$languageTitles = isset($job) ? $job['languages']['titles'] : $company['languages']['titles'];
	$languageShortCodes = isset($job) ? $job['languages']['shortcodes'] : $company['languages']['shortcodes'];
 
	if(!in_array($language, $languageShortCodes)) {
		$language = 'de';
	}
	
	$languageId = array_search($language, $languageShortCodes);
 
?>
<nav>
<?php
    if (count($languageTitles) > 1) {
?>
    <div id="lang">
        <button class="btn btn-subtle">
            <?= HeyUtility::h($languageTitles[$languageId] ?? '') ?>
            <i class="far fa-angle-down"></i>
        </button>
        <ul>
            <?php
                foreach ($languageTitles as $key => $value) {
            ?>
                    <li>
                        <a data-language="<?= HeyUtility::h($languageShortCodes[$key]) ?>">
                            <?= HeyUtility::h($value) ?>
                        </a>
                    </li>
            <?php
                }
            ?>
        </ul>
    </div>
<?php
    }
?>
</nav>