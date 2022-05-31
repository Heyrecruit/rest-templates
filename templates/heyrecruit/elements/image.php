<?php
$images = json_decode($jobSectionElement['text'], true)['detail'];
$sliderClass = count($images) > 1 ? ' slider-wrap' : '';
?>
<div class='scope-img-wrap<?= $sliderClass ?><?= $headerImage === true ? " header-img-wrap" : "" ?><?= isset($companyInfoSection) && $companyInfoSection === true ? " company-img-wrap" : "" ?>'>
   <?php
   $bgImageSnippet = 'background-image: ';
   $imageContent = '';

   foreach ($images as $key => $value) {

      $alt = isset($value['alt']) ? $value['alt'] : '';

      $value['host'] = !empty($value['host']) ? $value['host'] : 'https://www.scope-recruiting.de';

      $imageUrl = $value['host'] . DS . $value['rel_path'] . DS . $value['name'];

      $imageContent = '<img src="' . $imageUrl . '" alt="' . $alt . '"/>';

      echo $imageContent;

   } ?>
</div>
