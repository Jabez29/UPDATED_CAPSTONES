<?php
include("../includes/db_connect.php"); // Ensure the correct path

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Update request status to 'approved'
    $query = "UPDATE verification_requests SET status = 'approved' WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "<script>alert('Request Approved Successfully!'); window.location.href='verification_request.php';</script>";
    } else {
        echo "<script>alert('Approval Failed!'); window.location.href='verification_request.php';</script>";
    }
} else {
    echo "<script>alert('Invalid Request!'); window.location.href='verification_request.php';</script>";
}
?>
