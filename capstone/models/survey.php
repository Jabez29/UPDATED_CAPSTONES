<?php

require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../core/Udf.php';

$db = new Database(); // Instantiate the Database class
$pdo = $db->pdo;      // Access the $pdo property


if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $stmt = $pdo->prepare("
            SELECT 
            
            g.id, g.first_name, g.middle_name, g.last_name,
            g.student_number, g.course, g.graduation_year, g.permanent_address, 
            g.mobile_number,  g.civil_status, g.email, g.gender, g.regions, g.provinces, g.municipalities, g.barangays,
            eb.degree, eb.college,
                pe.name_of_exam, pe.date_taken, pe.rating,
                es.employment_status, es.company_name
            FROM graduates g
            LEFT JOIN educational_background eb ON g.id = eb.graduate_id
            LEFT JOIN professional_exams pe ON g.id = pe.graduate_id
            LEFT JOIN employment_survey es ON g.id = es.graduate_id
            WHERE g.id = :id
        ");

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $graduate = $stmt->fetch();

        if ($graduate) {
            echo "
            <p><strong>Name:</strong> " . htmlspecialchars($graduate['first_name'] . ' ' . $graduate['middle_name'] . ' ' . $graduate['last_name']) . "</p>
            <p><strong>Student Number:</strong> " . htmlspecialchars($graduate['student_number']) . "</p>
            <p><strong>Course:</strong> " . htmlspecialchars($graduate['course']) . "</p>
            <p><strong>Graduation Year:</strong> " . htmlspecialchars($graduate['graduation_year']) . "</p>
            <p><strong>Permanent Address:</strong> " . htmlspecialchars($graduate['permanent_address']) . "</p>
            <p><strong>mobile Number:</strong> " . htmlspecialchars($graduate['mobile_number']) . "</p>
            <p><strong>Civil Status:</strong> " . htmlspecialchars($graduate['civil_status']) . "</p>
            <p><strong>Email:</strong> " . htmlspecialchars($graduate['email']) . "</p>
            <p><strong>Gender:</strong> " . htmlspecialchars($graduate['gender']) . "</p>
            <p><strong>Complete Address:</strong> " . htmlspecialchars($graduate['regions'] . ' ' . $graduate['provinces'] . ' ' . $graduate['municipalities'].' '. $graduate['barangays']). "</p>
            <p><strong>Degree:</strong> " . htmlspecialchars($graduate['degree']) . "</p>
            <p><strong>College:</strong> " . htmlspecialchars($graduate['college']) . "</p>
            <p><strong>Professional Exam:</strong> " . htmlspecialchars($graduate['name_of_exam']) . "</p>
            <p><strong>Date Taken:</strong> " . htmlspecialchars($graduate['date_taken']) . "</p>
            <p><strong>Rating:</strong> " . htmlspecialchars($graduate['rating']) . "</p>
            <p><strong>Employment Status:</strong> " . htmlspecialchars($graduate['employment_status']) . "</p>
            <p><strong>Company Name:</strong> " . htmlspecialchars($graduate['company_name']) . "</p>";
        
            
        } else {
            echo "<p>No details found for this record.</p>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "<p>Invalid ID provided.</p>";
}
?>