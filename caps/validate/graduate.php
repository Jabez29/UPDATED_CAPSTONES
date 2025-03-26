<?php
session_start();
require_once '../includes/config.php';

$first_name = trim($_POST['first_name'] ?? '');
$middle_name = trim($_POST['middle_name'] ?? '');
$last_name = trim($_POST['last_name'] ?? '');
$student_number = trim($_POST['student_number'] ?? '');
$graduation_year = trim($_POST['graduation_year'] ?? '');
$course = trim($_POST['course'] ?? '');
$request_date = date("Y-m-d H:i:s");

if (!empty($first_name) && !empty($last_name) && !empty($student_number) && !empty($graduation_year) && !empty($course)) {
    try {
        $pdo->beginTransaction();

        // Check if student already exists in graduates table
        $check_sql = "SELECT id, status FROM graduates WHERE student_number = :student_number LIMIT 1";
        $check_stmt = $pdo->prepare($check_sql);
        $check_stmt->execute([':student_number' => $student_number]);
        $graduate = $check_stmt->fetch(PDO::FETCH_ASSOC);

        if ($graduate) {
            if ($graduate['status'] === 'approved') {
                // Store alumni data in session
                $_SESSION['student_number'] = $student_number;
                $_SESSION['alumni_data'] = [
                    'first_name' => $first_name,
                    'middle_name' => $middle_name,
                    'last_name' => $last_name,
                    'student_number' => $student_number,
                    'course' => $course,
                    'graduation_year' => $graduation_year,
                    'graduate_id' => $graduate['id']
                ];

                session_write_close(); // Save session before redirecting
                echo "<script>
                        alert('Verification successful! Please proceed to the Graduate Tracer Survey.');
                        window.location.href = '../geninfo.php';
                      </script>";
                exit();
            } elseif ($graduate['status'] === 'pending') {
                echo "<script>
                        alert('Your request is still pending approval.');
                        window.location.href = '../index.php';
                      </script>";
                exit();
            } elseif ($graduate['status'] === 'rejected') {
                echo "<script>
                        alert('Your request was rejected. Please contact support.');
                        window.location.href = '../index.php';
                      </script>";
                exit();
            }
        }

        // Check if student already requested verification
        $check_verification_sql = "SELECT COUNT(*) FROM verification_requests WHERE student_number = :student_number";
        $check_verification_stmt = $pdo->prepare($check_verification_sql);
        $check_verification_stmt->execute([':student_number' => $student_number]);
        $verification_exists = $check_verification_stmt->fetchColumn();

        if ($verification_exists > 0) {
            echo "<script>
                    alert('Your request is already under verification.');
                    window.location.href = '../index.php';
                  </script>";
            exit();
        }

        // Insert into graduates table
        $sql1 = "INSERT INTO graduates (first_name, middle_name, last_name, student_number, course, graduation_year, status)
                 VALUES (:first_name, :middle_name, :last_name, :student_number, :course, :graduation_year, :status)";
        $stmt1 = $pdo->prepare($sql1);
        $stmt1->execute([
            ':first_name' => $first_name,
            ':middle_name' => $middle_name,
            ':last_name' => $last_name,
            ':student_number' => $student_number,
            ':course' => $course,
            ':graduation_year' => $graduation_year,
            ':status' => 'pending'
        ]);

        // Insert into verification_requests table
        $sql2 = "INSERT INTO verification_requests (first_name, middle_name, last_name, student_number, course, graduation_year, request_date, status)
                 VALUES (:first_name, :middle_name, :last_name, :student_number, :course, :graduation_year, :request_date, :status)";
        $stmt2 = $pdo->prepare($sql2);
        $stmt2->execute([
            ':first_name' => $first_name,
            ':middle_name' => $middle_name,
            ':last_name' => $last_name,
            ':student_number' => $student_number,
            ':course' => $course,
            ':graduation_year' => $graduation_year,
            ':request_date' => $request_date,
            ':status' => 'pending'
        ]);

        $pdo->commit();

        echo "<script>
                alert('Your request has been submitted for verification.');
                window.location.href = '../index.php';
              </script>";

    } catch (PDOException $e) {
        $pdo->rollBack();
        die("Error: " . $e->getMessage());
    }
} else {
    echo "<script>
            alert('All fields are required.');
            window.location.href = '../index.php';
          </script>";
}
?>
