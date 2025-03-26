<?php
session_start();
require_once __DIR__ . '/../models/Users.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = new Users();
    $user->firstName = $_POST['firstName'];
    $user->middleName = $_POST['middleName'];
    $user->lastName = $_POST['lastName'];
    $user->userName = $_POST['registerUserName'];
    $user->email = $_POST['registerEmail'];
    $user->password = password_hash($_POST['registerPassword'], PASSWORD_BCRYPT);

    try {
        if ($user->save()) {
            $_SESSION['success'] = "User registered successfully!";
        } else {
            $_SESSION['error'] = "Registration failed. Please try again.";
        }
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            $errorMessages = [];
            if (strpos($e->getMessage(), 'userName') !== false) {
                $errorMessages[] = "Duplicate entry: Username is already taken.";
            }
            if (strpos($e->getMessage(), 'email') !== false) {
                $errorMessages[] = "Duplicate entry: Email is already registered.";
            }
            if (!empty($errorMessages)) {
                $_SESSION['error'] = implode(" ", $errorMessages);
            } else {
                $_SESSION['error'] = "An error occurred: " . $e->getMessage();
            }
        } else {
            $_SESSION['error'] = "An error occurred: " . $e->getMessage();
        }
    }
    header("Location: ../login.php");
    exit();
}