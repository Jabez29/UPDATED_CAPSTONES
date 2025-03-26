<?php
$conn = new mysqli("localhost", "root", "", "capstone");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT reg_code, name FROM regions ORDER BY name ASC";
$result = $conn->query($sql);

$regions = [];
while ($row = $result->fetch_assoc()) {
    $regions[] = $row;
}
echo json_encode($regions);
$conn->close();
?>
