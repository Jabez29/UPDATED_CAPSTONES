<?php
$conn = new mysqli("localhost", "root", "", "capstone");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$mun_code = $_GET['mun_code'] ?? '';

$sql = "SELECT bgy_code, name FROM barangays WHERE mun_code = '$mun_code' ORDER BY name ASC";
$result = $conn->query($sql);

$barangays = [];
while ($row = $result->fetch_assoc()) {
    $barangays[] = $row;
}
echo json_encode($barangays);
$conn->close();
?>
