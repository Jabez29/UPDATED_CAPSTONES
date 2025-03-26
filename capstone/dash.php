<?php

ob_start();
include_once "base.php";
$layout = ob_get_clean();

ob_start();
include_once '../CAPSTONE/views/dashboard.php';
$content = ob_get_clean();

// Update script path to absolute
$layout = str_replace('{{ script }}', '<script type="text/javascript" src="assets/js/dash.js"></script>', $layout);

echo str_replace('{{ content }}', $content, $layout);