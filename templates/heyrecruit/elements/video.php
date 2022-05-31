<?php
$videoUrl = $jobSectionElement['text'];
$videoId = str_replace('?rel=0', '', substr($videoUrl, strrpos($videoUrl, '/') + 1));

if (strpos($videoUrl, 'vimeo')) {
   ?>
   <div class='vimeo-embed-container'>
      <iframe src="https://player.vimeo.com/video/<?= $videoId ?>?h=eb47fd664a&color=567fc7" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
   </div>
   <script src="https://player.vimeo.com/api/player.js"></script>
   <?php
} else {
   ?>
   <div class='youtube-embed-container'>
      <iframe src='https://www.youtube.com/embed/QILiHiTD3uc' allowfullscreen></iframe>
   </div>
   <?php
}