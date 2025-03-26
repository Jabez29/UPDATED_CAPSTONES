<?php

require_once __DIR__ . '/../models/Users.php';

$response = [
    'data' => [],
    'success' => false
];

try {
    $buried = new Users();
    $application = $buried->getApplication();
    if ($application) {
        $response['data'] = $application;
        $response['success'] = true;
    } else {
        $response['message'] = 'No application found.';
    }
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

echo json_encode($response);