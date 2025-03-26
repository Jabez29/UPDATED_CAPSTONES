<?php
require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../core/Udf.php';

$db = new Database();
$pdo = $db->pdo;

function getEmploymentData($pdo) {
    $stmt = $pdo->prepare("
        SELECT 
            g.course,
            g.graduation_year,
            COALESCE(e.employment_status, 'Unknown') AS employment_status,
            COUNT(*) AS total
        FROM graduates g
        LEFT JOIN employment_survey e ON g.id = e.graduate_id
        WHERE e.employment_status IS NOT NULL  -- Ensures only relevant data is fetched
        GROUP BY g.course, g.graduation_year, e.employment_status
        ORDER BY g.graduation_year DESC
    ");

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
