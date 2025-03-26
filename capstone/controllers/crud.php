<?php

require_once '../models/Users.php';
require_once '../models/Graduate.php';

$action = isset($_POST['action']) ? $_POST['action'] : false;

$response = [
    'message' => '',
    'success' => false,
];

$model = null;

switch ($action) {
    case "create-user":
    case "update-user":
    case "delete-user":
        $model = new Users();
        break;
    case "create-graduate":
    case "update-graduate":
    case "delete-graduate":
        $model = new Graduates();
        break;
}

if ($model) {
    if (in_array($action, ["create-user", "create-graduate"])) {
        foreach ($_POST as $key => $value) {
            if (in_array($key, $model->fields)) {
                $model->{$key} = $value;
            }
        }
        if ($model->save()) {
            $response['success'] = true;
            $response['message'] = 'New record has been added with ID: ' . $model->lastInsertId;
        }
    } elseif (in_array($action, ["update-user", "update-graduate"])) {
        $model->id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        foreach ($_POST as $key => $value) {
            if (in_array($key, $model->fields)) {
                $model->{$key} = $value;
            }
        }
        if ($model->id != 0) {
            $model->condition = " WHERE id=" . $model->id;
            if ($model->update()) {
                $response['success'] = true;
                $response['message'] = 'Record has been updated!';
            }
        }
    } elseif (in_array($action, ["delete-user", "delete-graduate"])) {
        $model->id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        if ($model->id != 0) {
            $model->condition = " WHERE id=" . $model->id;
            if ($model->delete()) {
                $response['success'] = true;
                $response['message'] = 'Record has been deleted!';
            } else {
                $response['message'] = 'No changes have been made!';
            }
        }
    }
} else {
    $response['message'] = "Action not found.";
}

echo json_encode($response);