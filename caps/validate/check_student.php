<?php
require_once '../includes/config.php'; // Ensure correct DB connection

if (isset($_POST['student_number'])) {
    $student_number = trim($_POST['student_number']);

    // Check if student number exists in graduates OR verification_requests table
    $sql = "SELECT COUNT(*) FROM graduates WHERE student_number = :student_number
            UNION ALL
            SELECT COUNT(*) FROM verification_requests WHERE student_number = :student_number";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([':student_number' => $student_number]);

    $exists = array_sum($stmt->fetchAll(PDO::FETCH_COLUMN));

    if ($exists > 0) {
        echo "exists"; // Student number already exists
    } else {
        echo "available"; // Student number is available
    }
}
?>
