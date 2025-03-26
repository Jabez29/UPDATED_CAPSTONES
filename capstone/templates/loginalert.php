<!-- <div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="border border-success bg-white p-4 rounded w-50"> -->
<div id="form-container">
    <div id="login-form">
        <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?= $_SESSION['success']; ?>
        </div>
        <script>
        setTimeout(function() {
            window.location.href = 'dash.php';
        }, 2000);
        </script>
        <?php unset($_SESSION['success']);
        endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger mt-3">
            <?= $_SESSION['error']; ?>
        </div>
        <?php unset($_SESSION['error']);
        endif; ?>