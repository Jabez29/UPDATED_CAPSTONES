<?php
include '../includes/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Get form inputs
        $training_title = trim($_POST['training_title'] ?? '');
        $duration = trim($_POST['duration'] ?? '');
        $institution = trim($_POST['institution'] ?? '');

        // Validate input fields
        if (empty($training_title) || empty($duration) || empty($institution)) {
            echo "<script>
                    alert('All fields are required.');
                    window.history.back();
                  </script>";
            exit();
        }

        // Start transaction
        if ($pdo->inTransaction() === false) {
            $pdo->beginTransaction();
        }

        // Prepare SQL statement
        $stmt = $pdo->prepare("INSERT INTO trainings (training_title, duration, institution) 
                               VALUES (:training_title, :duration, :institution)");
        $stmt->bindParam(':training_title', $training_title);
        $stmt->bindParam(':duration', $duration);
        $stmt->bindParam(':institution', $institution);

        // Execute the query
        if ($stmt->execute()) {
            $pdo->commit();
            echo "<script>
                    alert('Data submitted successfully!');
                    window.location.href = 'http://localhost/caps/employment.php';
                  </script>";
            exit();
        } else {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            echo "<script>
                    alert('Error: Unable to save data.');
                    window.history.back();
                  </script>";
            exit();
        }
    } catch (PDOException $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        echo "<script>
                alert('Database error: " . addslashes($e->getMessage()) . "');
                window.history.back();
              </script>";
        exit();
    }
} else {
    echo "<script>
            alert('Invalid request method.');
            window.history.back();
          </script>";
    exit();
}