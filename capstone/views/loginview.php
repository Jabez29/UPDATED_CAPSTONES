<?php
session_start();
?>
<!-- Header Section -->
<nav class="navbar fixed-top" style="background-color: #1d8348;">
    <a class="navbar-brand d-flex align-items-center" href="#">
        <img src="assets/img/actscc_logo.png" width="50" height="50" class="d-inline-block align-top" alt="Logo"
            style="margin-right: 10px;">
        <span id="alumniText" class="ml-2"
            style="font-family: 'Arial', sans-serif; font-weight: bold; margin-left: 10px;">
            ALUMNI TRACER SYSTEM
        </span>
    </a>
</nav>

<body
    style="background-image: url('assets/img/1.jpg'); background-size: cover; background-position: center; background-attachment: fixed;">
    <div class="background-div"
        style="position: relative; width: 100%; height: 100vh; display: flex; justify-content: center; align-items: center;">

        <form action="http://localhost/capstone/controllers/loginController.php" method="POST">
            <?php include_once __DIR__ . '/../templates/loginalert.php'; ?>

            <!-- Display Logout Message -->
            <?php if (isset($_GET['logout']) && $_GET['logout'] === 'success'): ?>
            <div class="alert alert-success">You have successfully logged out.</div>
            <?php endif; ?>

            <header style="text-align: center; margin-bottom: 20px;">
                <h2>Login to Alumni Tracer System</h2>
            </header>

            <div class="mb-3">
                <label for="userName" class="form-label">Username</label>
                <input type="text" class="form-control" id="userName" name="userName"
                    value="<?= isset($_COOKIE['userName']) ? htmlspecialchars($_COOKIE['userName']) : ''; ?>" required>
            </div>

            <div class="mb-3 position-relative">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="password" name="password"
                        placeholder="Enter password" required>
                    <span class="input-group-text" style="cursor: pointer;"
                        onclick="togglePasswordVisibility('password', 'toggleIcon')">
                        <i class="bi bi-eye" id="toggleIcon"></i>
                    </span>
                </div>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember"
                    <?= isset($_COOKIE['userName']) ? 'checked' : ''; ?>>
                <label class="form-check-label" for="remember">Remember me</label>
            </div>

            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>
</body>