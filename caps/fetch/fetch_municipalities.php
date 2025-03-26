<?php
$conn = new mysqli("localhost", "root", "", "capstone");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$prv_code = $_GET['prv_code'] ?? '';

$sql = "SELECT mun_code, name FROM municipalities WHERE prv_code = '$prv_code' ORDER BY name ASC";
$result = $conn->query($sql);

$municipalities = [];
while ($row = $result->fetch_assoc()) {
    $municipalities[] = $row;
}
echo json_encode($municipalities);
$conn->close();
?>
