<?php
$maxEntriesPerPage = $jobs['pagination']['limit'];
$totalEntries = $jobs['pagination']['total'];
$pages = ceil($totalEntries / $maxEntriesPerPage);
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if($page < 1) $page = 1;
if($page > $pages) $page = $pages;

if($pages > 1) {
    echo '<div id="pagination" class="text-center hey_pagination" role="navigation" aria-label="Seitenanzahl Stellenanzeigen">';

    for($i = 1; $i <= $pages; $i++){
        if($i == $page){
            // Aktuelle Seite markieren
            echo '<button class="btn-outline-info active" data-rel="'.$i.'">'.$i.'</button>';
        }else{
            echo '<button class="btn-outline-info" data-rel="'.$i.'" >'.$i.'</button>';
        }
    }

    echo '</div>';
}

