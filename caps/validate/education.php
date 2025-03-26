<?php
session_start(); // Ensure session is started
include '../includes/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $pdo->beginTransaction(); 

        // Get graduate_id from session
        $graduate_id = $_SESSION['graduate_id'] ?? null;

        if (!$graduate_id) {
            throw new Exception("Error: Graduate ID is missing. Please log in again.");
        }

        // Insert into educational_background
        $stmt = $pdo->prepare("INSERT INTO educational_background (graduate_id, degree, college, year_graduated, honors) 
                               VALUES (:graduate_id, :degree, :college, :year_graduated, :honors)");
        $stmt->execute([
            ':graduate_id' => $graduate_id,
            ':degree' => $_POST['degree'],
            ':college' => $_POST['college'],
            ':year_graduated' => $_POST['year'],
            ':honors' => $_POST['honors']
        ]);

        // Insert into professional_exams if an exam is provided
        $date_taken = !empty($_POST['exam_date']) ? date("Y-m-d", strtotime($_POST['exam_date'])) : null;
        if (!empty($_POST['exam_name'])) {
            $stmtExam = $pdo->prepare("INSERT INTO professional_exams (graduate_id, name_of_exam, date_taken, rating) 
                                       VALUES (:graduate_id, :name_of_exam, :date_taken, :rating)");
            $stmtExam->execute([
                ':graduate_id' => $graduate_id,
                ':name_of_exam' => $_POST['exam_name'],
                ':date_taken' => $date_taken, 
                ':rating' => $_POST['exam_rating']
            ]);
        }

        // Insert into course_reasons
        if (!empty($_POST['reason']) && is_array($_POST['reason'])) {
            $stmtReason = $pdo->prepare("INSERT INTO course_reasons (graduate_id, reason, category) VALUES (:graduate_id, :reason, :category)");
            foreach ($_POST['reason'] as $key => $values) {
                if (is_array($values)) {
                    foreach ($values as $category) {
                        $stmtReason->execute([
                            ':graduate_id' => $graduate_id,
                            ':reason' => $key,
                            ':category' => $category
                        ]);
                    }
                } else {
                    // Handle single values (in case it's not an array)
                    $stmtReason->execute([
                        ':graduate_id' => $graduate_id,
                        ':reason' => $key,
                        ':category' => $values
                    ]);
                }
            }
        }

        $pdo->commit();

        // Success message with redirect
        echo "<script>
                alert('Data submitted successfully!');
                window.location.href = 'http://localhost/caps/training.php';
              </script>";
        exit();
    } catch (Exception $e) {
        $pdo->rollBack();
        echo "<script>
                alert('Error: " . addslashes($e->getMessage()) . "');
                window.history.back();
              </script>";
        exit();
    }
} else {
    echo "<script>
            alert('Invalid request.');
            window.history.back();
          </script>";
    exit();
}
?>
