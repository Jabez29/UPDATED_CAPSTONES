<?php
ob_start();
include_once "base.php";
$layout = ob_get_clean();

ob_start();
include_once 'views/course_job_misalignment.php';
$content = ob_get_clean();

echo str_replace('{{ content }}', $content, $layout);
?>
