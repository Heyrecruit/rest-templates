<!--<div>
    <?php
/*    if (strpos($jobSectionElement['html'], '<p>') !== false) {
        echo $jobSectionElement['html'];
    } else {
        echo '<span>';
        echo $jobSectionElement['html'];
        echo '</span>';
    }
    */?>
</div>-->
<?php
$text = $jobSectionElement['html'];

if (strpos($jobSectionElement['html'], '<ul>') !== false) {
    $text = str_replace('<li>', '<li><span class="fa-li"><i class="far fa-angle-right primary-color"></i></span>', $jobSectionElement['html']);
}
?>

<span class="block-span"><?= $text ?></span>