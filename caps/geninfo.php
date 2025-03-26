<?php



ob_start();
include_once "base.php";
$layout = ob_get_clean();

ob_start();
// include_once 'templates/form-sample.php';
 include_once '../Caps/view/geninfoView.php';
$content = ob_get_clean();

$layout = str_replace('{{ script }}', '<script type="text/javascript" src="Assets/js/geninfo.js"></script>', $layout);

echo str_replace('{{ content }}', $content, $layout);