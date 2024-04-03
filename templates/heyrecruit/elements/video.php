<?php
	/** @var array $jobSectionElement */
    
    $videoUrl = $jobSectionElement['job_section_element_strings'][0]['text'];
    
    if (strpos($videoUrl, 'vimeo')) {
	    $videoId = str_replace('?rel=0', '', substr($videoUrl, strrpos($videoUrl, '/') + 1));
?>
       <div class='vimeo-embed-container'>
          <iframe src="https://player.vimeo.com/video/<?=$videoId?>?h=eb47fd664a&color=567fc7" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
       </div>
       <script src="https://player.vimeo.com/api/player.js"></script>
<?php
} else {
	    parse_str( parse_url( $videoUrl, PHP_URL_QUERY ), $variables );
	    
        if(!empty($variables['v'])) {
         
	        $videoId = $variables['v'];
?>
            <div class='youtube-embed-container'>
                <iframe src='https://www.youtube.com/embed/<?=$videoId?>' allowfullscreen></iframe>
            </div>
<?php
        }

}
