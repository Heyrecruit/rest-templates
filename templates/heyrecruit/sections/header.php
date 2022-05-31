<?php if ($headerImageIncluded) { ?>
   <header>
      <?php
      foreach ($jobSection['JobSectionElement'] as $key => $value) {
         if ($value['element_type'] === 'image' && file_exists(__DIR__ . DS . '../elements' . DS . $value['element_type'] . '.php')) {
            $headerImage = true;
            $jobSectionElement = $value;
            ob_start();
            include __DIR__ . DS . '../elements' . DS . $value['element_type'] . '.php';
            echo ob_get_clean();
            $headerImage = false;
         }
      }
      ?>
   </header>
<?php } else {
    foreach ($jobSection['JobSectionElement'] as $key => $value) {
        if ($value['element_type'] !== 'image' && $value['element_type'] !== 'text' && file_exists(__DIR__ . DS . '../elements' . DS . $value['element_type'] . '.php')) {
            $jobSectionElement = $value;
            ob_start();
            include __DIR__ . DS . '../elements' . DS . $value['element_type'] . '.php';
            echo ob_get_clean();
        }
    }
    ?>
   <div class="flexbox-badges">
      <span>
         <i class="fal fa-map-marker-alt"></i><?= $formattedJobLocation ?>
      </span>
      <span>
         <i class="fal fa-clock"></i><?= preg_replace('/(?<!\d),|,(?!\d{3})/', ', ', $job['Job']['employment']) ?>
      </span>
      <?php if ($job['Job']['department']) { ?>
         <span><i class="fal fa-hashtag"></i><?= $job['Job']['department'] ?></span>
      <?php } ?>
      <?php if ($job['Job']['salary_min'] && $job['Job']['salary_max']) {
         $salaryMin = number_format($job['Job']['salary_min'], 0, ',', '.');
         $salaryMax = number_format($job['Job']['salary_max'], 0, ',', '.');
         ?>
      <span><i class="fal fa-money-bill-wave"></i><?= $salaryMin ?>–<?= $salaryMax ?> €</span>
      <?php } ?>
      <?php
      if ($job['Job']['remote']) {
         $remoteString = "";

         switch ($job['Job']['remote']) {
            case "complete":
               $remoteString = $language != 'de' ? "100%" :"Komplett";
               break;
            case "sometimes":
               $remoteString = $language != 'de' ? "Sometimes" : "Teilweise";
               break;
            default:
               $remoteString = $language != 'de' ? "No" :"Nein";
         }
         ?>
         <span><i class="fal fa-house"></i>Homeoffice: <?= $remoteString ?> </span>
      <?php } ?>
   </div>
    <?php
    foreach ($jobSection['JobSectionElement'] as $key => $value) {
        if ($value['element_type'] === 'text' && file_exists(__DIR__ . DS . '../elements' . DS . $value['element_type'] . '.php')) {
            $jobSectionElement = $value;
            ob_start();
            include __DIR__ . DS . '../elements' . DS . $value['element_type'] . '.php';
            echo ob_get_clean();
        }
    }
}
?>
