<?php
$conn = new mysqli("localhost", "root", "", "capstone");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$reg_code = $_GET['reg_code'] ?? '';

$sql = "SELECT prv_code, name FROM provinces WHERE reg_code = '$reg_code' ORDER BY name ASC";
$result = $conn->query($sql);

$provinces = [];
while ($row = $result->fetch_assoc()) {
    $provinces[] = $row;
}
echo json_encode($provinces);
$conn->close();
?>
