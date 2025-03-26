<?php
session_start();
require_once '../models/Users.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userName = $_POST['userName'];
    $password = $_POST['password'];
    $rememberMe = isset($_POST['remember']) ? true : false;

    $userModel = new Users();
    $stmt = $userModel->pdo->prepare("SELECT * FROM login_systems WHERE userName = :userName");
    $stmt->bindValue(':userName', $userName);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

     if ($user) {
        if ($user['status'] == 0) {
            $_SESSION['error'] = 'Your account is blocked by the admin. Please contact support.';
            header("Location: ../login.php");
            exit();
        }

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['userName'] = $user['userName'];

            // Redirect based on user role
            $_SESSION['success'] = 'Login successful! Welcome, ' . htmlspecialchars($user['userName']) . '.';
      
            
            if ($rememberMe) {
                setcookie('userName', $userName, time() + (30 * 24 * 60 * 60), '/');
            } else {
                if (isset($_COOKIE['userName'])) {
                    setcookie('userName', '', time() - 3600, '/');
                }
            }

           
        } else {
            // Invalid password
            $_SESSION['error'] = 'Invalid credentials. Please try again.';
            header("Location: ../index.php");
            exit();
        }
    } else {
        // User not found
        $_SESSION['error'] = 'Invalid credentials. Please try again.';
        header("Location: ../index.php");
        exit();
    }
}

header("Location: ../index.php");
exit();