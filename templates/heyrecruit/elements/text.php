<?php
    /** @var array $jobSectionElement */
    
    $text = $jobSectionElement['job_section_element_strings'][0]['html'] ?? '';

    
    if (str_contains($text ?? '', '<ul>')) {
        $text = str_replace('<li>',
            '<li><span class="fa-li"><i class="far fa-angle-right primary-color"></i></span>',
            $jobSectionElement['job_section_element_strings'][0]['html']
        );
    }
?>

<span class="block-span"><?= $text ?></span>