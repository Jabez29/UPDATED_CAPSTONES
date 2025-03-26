<?php
session_start();
if (!isset($_SESSION['alumni_data']) || !isset($_SESSION['student_number'])) {
    header("Location: http://localhost/Caps/validate/graduate.php");
    exit();
}

$alumniData = $_SESSION['alumni_data'];
$student_number = $_SESSION['student_number'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require '../includes/config.php';

    $email = $_POST['email'];
    $permanent_address = $_POST['address'];
    $mobile_number = $_POST['mobile'];
    $civil_status = $_POST['civilstatus'];
    $gender = $_POST['gender'];
    $region_id = $_POST['region_id'];
    $province_id = $_POST['province_id'];
    $municipality_id = $_POST['city_id'];
    $barangay_id = $_POST['barangay_id'];

    function getNameFromId($pdo, $table, $column, $id) {
        $stmt = $pdo->prepare("SELECT name FROM $table WHERE $column = ?");
        $stmt->execute([$id]);
        return $stmt->fetchColumn() ?: 'Unknown';  
    }

    $region_name = getNameFromId($pdo, 'regions', 'reg_code', $region_id);
    $province_name = getNameFromId($pdo, 'provinces', 'prv_code', $province_id);
    $municipality_name = getNameFromId($pdo, 'municipalities', 'mun_code', $municipality_id);
    $barangay_name = getNameFromId($pdo, 'barangays', 'bgy_code', $barangay_id);

    try {
        $stmt = $pdo->prepare("UPDATE graduates 
            SET email = ?, 
                permanent_address = ?, 
                mobile_number = ?, 
                civil_status = ?, 
                gender = ?, 
                regions = ?, 
                provinces = ?, 
                municipalities = ?, 
                barangays = ?, 
                updated_at = NOW()
            WHERE student_number = ?");

        $stmt->execute([
            $email,
            $permanent_address,
            $mobile_number,
            $civil_status,
            $gender,
            $region_name,
            $province_name,
            $municipality_name,
            $barangay_name,
            $student_number
        ]);

        // Store data in session
        $_SESSION['alumni_data'] = [
            'email' => $email,
            'permanent_address' => $permanent_address,
            'mobile_number' => $mobile_number,
            'civil_status' => $civil_status,
            'gender' => $gender,
            'regions' => $region_name,
            'provinces' => $province_name,
            'municipalities' => $municipality_name,
            'barangays' => $barangay_name
        ];

        $_SESSION['graduate_id'] = $student_number;

        echo "<script>alert('Data updated successfully!');</script>";
        header("Location: http://localhost/caps/educationbackground.php");
        exit();

    } catch (PDOException $e) {
        echo "<p style='color: red;'>Database error: " . $e->getMessage() . "</p>";
    }
}
?>