<?php



ob_start();
include_once "base.php";
$layout = ob_get_clean();

ob_start();
// include_once 'templates/form-sample.php';
include_once '../capstone/admin/verification_request.php';
$content = ob_get_clean();

$layout = str_replace('{{ script }}', '<script type="text/javascript" src="assets/js/user.js"></script>', $layout);

echo str_replace('{{ content }}', $content, $layout);
