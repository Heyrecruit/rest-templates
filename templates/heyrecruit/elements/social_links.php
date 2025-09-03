<?php

/** @var array $jobSectionElement */

foreach (json_decode($jobSectionElement['job_section_element_strings'][0]['text'], true)['detail'] as $key => $value) {
	
	if(!isset($value['title']) || !isset($value['href'])) {
		continue;
	}
    
    if ($value['title'] === 'Kununu') {
        ?>
        <a href="<?= $value['href'] ?>" class="social-link-a primary-color" target="_blank" aria-label="kununu">
            <svg id="kununu-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 250 250"><defs><style>.cls-1{}</style></defs><path id="path3781" class="cls-1" d="M116.16,202.56,82,236.28a44.52,44.52,0,0,1-63.55,0L13,230.76c-17.39-17.78-17.39-46,0-63.15l31.77-31.88,1.8-1.84a12.56,12.56,0,0,1,16.79,0l4.19,4.29a11.86,11.86,0,0,1,.6,16.56L34,188.46a14.33,14.33,0,0,0,0,20.84l5.4,5.52c6,5.52,15,6.13,21,0L94.57,181.1a12.56,12.56,0,0,1,16.79,0l4.2,4.29c4.79,5.52,4.79,12.88.6,17.17Z" transform="translate(0)"/><path id="path3783" class="cls-1" d="M116.16,63.38,112,67.67c-4.8,4.3-12,4.91-16.79.62L61,34.57a15.36,15.36,0,0,0-21,0l-5.4,5.51a14.34,14.34,0,0,0,0,20.85L68.79,94.65a11.83,11.83,0,0,1,0,16.55l-4.19,4.3c-4.8,4.29-12,4.9-16.19,0L14.24,81.78c-17.39-17.17-18-46,0-63.16l5.39-5.51C37-4.67,65.2-4.06,83.18,13.11L113.76,45l1.8,1.84a11.87,11.87,0,0,1,.6,16.55Z" transform="translate(0)"/><path id="path3785" class="cls-1" d="M236.66,231.38l-5.4,5.51c-17.38,17.78-46.16,17.17-63.55,0L135.94,205l-1.8-1.84a11.31,11.31,0,0,1,0-16.55l4.2-4.29c4.79-4.3,12-4.91,16.78-.62l34.18,33.72a15.36,15.36,0,0,0,21,0l5.39-5.51c6-6.13,6-15.33,0-20.85L181.5,155.35c-4.79-4.29-4.19-12.26,0-16.55l4.2-4.3c4.79-4.29,12-4.9,16.19,0l34.17,33.72C254,185.39,254,213.6,236.66,231.38Z" transform="translate(0)"/><path id="path3787" class="cls-1" d="M236.66,81.78l-31.78,31.88-1.8,1.84a12.55,12.55,0,0,1-16.78,0l-4.2-4.3a11.87,11.87,0,0,1-.6-16.55l34.17-33.72c6-5.52,6-14.72,0-20.85l-5.39-5.51a15.36,15.36,0,0,0-21,0L155.12,68.29c-4.79,4.9-12,4.29-16.78,0l-4.2-4.3c-4.8-4.9-4.8-11.64,0-16.55l34.17-34.33c17.39-17.17,46.17-17.78,63.55,0l5.4,5.51a44.77,44.77,0,0,1-.6,63.16Z" transform="translate(0)"/></svg>
        </a>
        <?php
    } else if ($value['title'] === 'Website') {
        ?>
        <a class="primary-color social-link-a" href="<?= $value['href'] ?>" target="_blank" aria-label="Website">
            <i class="fas fa-globe-europe primary-color" aria-hidden="true"></i>
        </a>
        <?php
    } else if ($value['title'] === 'Facebook') {
        ?>
        <a class="primary-color social-link-a" href="<?= $value['href'] ?>" target="_blank" aria-label="Facebook">
            <i class="fab fa-facebook primary-color" aria-hidden="true"></i>
        </a>
        <?php
    } else if ($value['title'] === 'Twitter') {
        ?>
        <a class="primary-color social-link-a" href="<?= $value['href'] ?>" target="_blank" aria-label="X">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
                <path d="M453.2 112L523.8 112L369.6 288.2L551 528L409 528L297.7 382.6L170.5 528L99.8 528L264.7 339.5L90.8 112L236.4 112L336.9 244.9L453.2 112zM428.4 485.8L467.5 485.8L215.1 152L173.1 152L428.4 485.8z"/>
            </svg>
        </a>
        <?php
    } else if ($value['title'] === 'Xing') {
        ?>
        <a class="primary-color social-link-a" href="<?= $value['href'] ?>" target="_blank" aria-label="Xing">
            <i class="fab fa-xing primary-color" aria-hidden="true"></i>
        </a>
        <?php
    } else {
        ?>
        <a class="primary-color social-link-a" href="<?= $value['href'] ?>" target="_blank" aria-label="<?=$value['title']?>">
            <i class="<?= $value['icon'] ?> primary-color" aria-hidden="true"></i>
        </a>
        <?php
    }
}
?>

