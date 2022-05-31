<?php
if (!isset($scope)) {
    include __DIR__ . '/../../ini.php';
}

if ($language === "undefined") {
   $language = "de";
}

$googleTagManager = $scope->getGoogleTagCode($company['CompanySetting']['google_tag_public_id']);


if ($company['Company']['employee_number'] === 'größer 100') {
    $companyEmployeeNumber = 'über 100';
} else if ($company['Company']['employee_number'] === 'kleiner 25') {
    $companyEmployeeNumber = 'unter 25';
} else {
    $companyEmployeeNumber = str_replace('-', '–', $company['Company']['employee_number']);
}


function hex2rgba($color, $opacity = false)
{

    $default = 'rgb(0,0,0)';

    //Return default if no color provided
    if (empty($color))
        return $default;

    //Sanitize $color if "#" is provided
    if ($color[0] == '#') {
        $color = substr($color, 1);
    }

    //Check if color has 6 or 3 characters and get values
    if (strlen($color) == 6) {
        $hex = array($color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5]);
    } elseif (strlen($color) == 3) {
        $hex = array($color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]);
    } else {
        return $default;
    }

    //Convert hexadec to rgb
    $rgb = array_map('hexdec', $hex);

    //Check if opacity is set(rgba or rgb)
    if ($opacity) {
        $opacity = abs($opacity) > 1 ? 1.0 : $opacity;
        $output = 'rgba(' . implode(",", $rgb) . ',' . $opacity . ')';
    } else {
        $output = 'rgb(' . implode(",", $rgb) . ')';
    }

    //Return rgb(a) color string
    return $output;
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta name="google-site-verification" content="eI_MQb_IOqtuvB3AeFpa1W_DtqcePhYYCklaQ7yzK9U"/>
    <style>
        /* Set class to override the default template color outta scope */
        .btn,
        .btn.btn-subtle:hover,
        #lang ul li:hover a,
        .flexbox-badges span {
            color: <?=$company['CompanyTemplate']['key_color']?>;
        }

        .btn:hover,
        .btn.btn-primary,
        .dz-upload,
        body section#cp-section-jobs #pagination button.active {
            background: <?=$company['CompanyTemplate']['key_color']?>;
        }

        .initiative-tile,
        body section#cp-section-jobs #pagination button:not(.active):hover,
        .flexbox-badges span,
        body section .social-links a:hover {
            background: <?= hex2rgba($company['CompanyTemplate']['key_color'], 0.1) ?>;
        }

        .primary-bg,
        .primary-bg-hover:hover,
        .primary-bg-before:before,
        .primary-bg-before ul li:before {
            background: <?=$company['CompanyTemplate']['key_color']?> !important;
        }

        .primary-color,
        .primary-color-hover:hover,
        .primary-color-hover:hover span,
        .primary-color-hover:hover i {
            color: <?=$company['CompanyTemplate']['key_color']?> !important;
        }

        body section#jp-section-form #job-form-wrapper select:focus,
        body section#jp-section-form #job-form-wrapper select:hover,
        body section#jp-section-form #job-form-wrapper textarea:focus,
        body section#jp-section-form #job-form-wrapper textarea:hover,
        body section#jp-section-form #job-form-wrapper input[type=text]:focus,
        body section#jp-section-form #job-form-wrapper input[type=text]:hover,
        body section#jp-section-form #job-form-wrapper input[type=email]:focus,
        body section#jp-section-form #job-form-wrapper input[type=email]:hover,
        body section#jp-section-form #job-form-wrapper input[type=tel]:focus,
        body section#jp-section-form #job-form-wrapper input[type=tel]:hover,
        .dz-default.dz-message > span,
        .dz-default.dz-message > button {
            border-color: <?=$company['CompanyTemplate']['key_color']?> !important;
        }

        body #ui-datepicker-div .ui-datepicker-calendar .ui-state-default.ui-state-active {
            border: 1px solid <?=$company['CompanyTemplate']['key_color']?> !important;
            background: <?=$company['CompanyTemplate']['key_color']?> !important;
        }

        #kununu-svg {
            fill: <?=$company['CompanyTemplate']['key_color']?> !important;
        }

        .secondary-color,
        .secondary-color-hover:hover {
            color: <?=$company['CompanyTemplate']['secondary_color']?> !important;
        }

        .secondary-bg,
        .secondary-bg-hover:hover {
            background: <?=$company['CompanyTemplate']['secondary_color']?> !important;
        }
    </style>
    <?php
    //echo $googleTagManager['head'];

    if (isset($_GET['page']) && $_GET['page'] === 'job') {
        include __DIR__ . DS . "../../partials/get_job.php";
    }

    include __DIR__ . DS . 'sections' . DS . 'html_head_content.php';
    ?>
</head>
<?php
echo "<body data-base-path=\"{$_ENV['BASE_PATH']}/templates/$template\"
	            data-domain=\"{$_SERVER['SERVER_NAME']}\"
	            data-company-name=\"{$company['Company']['name']}\"
	            data-key-color=\"{$company['CompanyTemplate']['key_color']}\"
	            data-gtm-id=\"{$company['CompanySetting']['google_tag_public_id']}\"
	            data-gtm-property-id=\"_gat_{$company['CompanySetting']['google_analytics_property_id']}\"
	            data-datenschutz-url=\"#scope_datenschutz\"
	            data-datenschutz-class=\"\">";

//		echo $googleTagManager['body'];
?>

<div id="page" class="<?= $page == 'jobs' ? "careerpage" : "" ?>" data-scope-outer-container="true">
    <?php
    include __DIR__ . DS . 'pages' . DS . "$page.php";
    ?>

    <?php
    $displayFooter = '';
    if (isset($_GET['stand_alone_site']) && !$_GET['stand_alone_site'] && $page == 'jobs') {
        $displayFooter = 'style="display:none"';
    }
    ?>
    <footer <?= $displayFooter ?>>
        <?php
        include __DIR__ . DS . 'sections' . DS . 'footer.php';
        ?>
    </footer>

</div>
<?php
if($displayFooter !== 'style="display:none"') {
	include __DIR__ . DS . 'pages' . DS . "impressum.php";
}

include __DIR__ . DS . '../../partials/google_4_jobs.php';
?>
</body>
</html>
