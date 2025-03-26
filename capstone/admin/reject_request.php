<?php
include("../includes/db_connect.php"); // Ensure the correct path

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Update request status to 'rejected'
    $query = "UPDATE verification_requests SET status = 'rejected' WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "<script>alert('Request Rejected Successfully!'); window.location.href='verification_request.php';</script>";
    } else {
        echo "<script>alert('Rejection Failed!'); window.location.href='verification_request.php';</script>";
    }
} else {
    echo "<script>alert('Invalid Request!'); window.location.href='verification_request.php';</script>";
}
?>
