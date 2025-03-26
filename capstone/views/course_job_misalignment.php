<?php
include_once '../CAPSTONE/templates/dash.php';
include_once __DIR__ . '/../includes/db_connect.php';

// Fetch available graduation years
$yearQuery = "SELECT DISTINCT graduation_year FROM graduates ORDER BY graduation_year DESC";
$yearStmt = $pdo->prepare($yearQuery);
$yearStmt->execute();
$years = $yearStmt->fetchAll(PDO::FETCH_COLUMN);

// Fetch available courses
$courseQuery = "SELECT DISTINCT course FROM graduates ORDER BY course ASC";
$courseStmt = $pdo->prepare($courseQuery);
$courseStmt->execute();
$coursesList = $courseStmt->fetchAll(PDO::FETCH_COLUMN);

// Get selected filters
$selectedYear = $_GET['year'] ?? 'All';
$selectedCourse = $_GET['course'] ?? null;

$showGraph = ($selectedYear !== 'All' || !empty($selectedYear)) && (!empty($selectedCourse));

$data = [];
$courses = [];
$totalGraduates = [];
$misalignedGraduates = [];

if ($showGraph) {
    $query = "
        SELECT 
            g.course, 
            g.graduation_year,
            COUNT(DISTINCT g.id) AS total, 
            SUM(CASE 
                   WHEN COALESCE(es.first_job_related, 'no') = 'no' THEN 1 
                   ELSE 0 
               END) AS misaligned
        FROM graduates g
        LEFT JOIN (
            SELECT es1.* 
            FROM employment_survey es1
            INNER JOIN (
                SELECT graduate_id, MAX(id) AS latest_id 
                FROM employment_survey 
                GROUP BY graduate_id
            ) es2 ON es1.graduate_id = es2.graduate_id AND es1.id = es2.latest_id
        ) es ON g.id = es.graduate_id
        WHERE 1=1
    ";

    if ($selectedYear !== 'All') {
        $query .= " AND g.graduation_year = :selectedYear";
    }
    if (!empty($selectedCourse)) {
        $query .= " AND g.course = :selectedCourse";
    }

    $query .= " GROUP BY g.course, g.graduation_year";

    $stmt = $pdo->prepare($query);

    if ($selectedYear !== 'All') {
        $stmt->bindParam(':selectedYear', $selectedYear, PDO::PARAM_INT);
    }
    if (!empty($selectedCourse)) {
        $stmt->bindParam(':selectedCourse', $selectedCourse, PDO::PARAM_STR);
    }

    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $courses = array_column($data, 'course');
    $totalGraduates = array_column($data, 'total');
    $misalignedGraduates = array_column($data, 'misaligned');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course-Job Misalignment Report</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            text-align: center;
        }
        .container {
            width: 90%;
            max-width: 900px;
            background: white;
            margin: 30px auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #333;
            margin-bottom: 20px;
        }
        select {
            padding: 10px;
            font-size: 1rem;
            margin: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
            cursor: pointer;
        }
        .clear-btn {
            padding: 10px;
            font-size: 1rem;
            margin: 10px;
            border-radius: 5px;
            border: none;
            background-color: #dc3545;
            color: white;
            cursor: pointer;
            transition: 0.3s;
        }
        .clear-btn:hover {
            background-color: #a71d2a;
        }
        .chart-container {
            width: 100%;
            height: 400px;
            display: <?= $showGraph ? 'block' : 'none' ?>;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Course-Job Misalignment Report</h2>

        <form id="filterForm">
            <label for="year">Select Year:</label>
            <select name="year" id="year">
                <option value="All" <?= $selectedYear === 'All' ? 'selected' : '' ?>>All Years</option>
                <?php foreach ($years as $year): ?>
                    <option value="<?= $year ?>" <?= $year == $selectedYear ? 'selected' : '' ?>>
                        <?= $year ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="course">Select Course:</label>
            <select name="course" id="course">
                <option value="">-- Select Course --</option>
                <?php foreach ($coursesList as $course): ?>
                    <option value="<?= htmlspecialchars($course) ?>" <?= $course == $selectedCourse ? 'selected' : '' ?>>
                        <?= htmlspecialchars($course) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="button" class="clear-btn" onclick="clearFilters()">Clear</button>
        </form>

        <div class="chart-container">
            <canvas id="misalignmentChart"></canvas>
        </div>
    </div>

    <script>
        function updateFilters() {
            const year = document.getElementById("year").value;
            const course = document.getElementById("course").value;

            if (year && course) {
                window.location.href = "?year=" + year + "&course=" + encodeURIComponent(course);
            }
        }

        function clearFilters() {
            window.location.href = window.location.pathname;
        }

        document.getElementById("year").addEventListener("change", updateFilters);
        document.getElementById("course").addEventListener("change", updateFilters);

        <?php if ($showGraph): ?>
            document.addEventListener("DOMContentLoaded", function () {
                const ctx = document.getElementById('misalignmentChart').getContext('2d');

                new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?= json_encode($courses) ?>, // Now contains Course (Year)
        datasets: [
            { 
                label: 'Total Graduates', 
                data: <?= json_encode($totalGraduates) ?>, 
                backgroundColor: 'rgba(54, 162, 235, 0.6)' 
            },
            { 
                label: 'Misaligned Graduates', 
                data: <?= json_encode($misalignedGraduates) ?>, 
                backgroundColor: 'rgba(255, 99, 132, 0.6)' 
            }
        ]
    },
    options: {
        responsive: true,
        scales: {
            x: {
                ticks: {
                    autoSkip: false, // Ensures all labels are shown
                    maxRotation: 45, // Adjust for better readability
                    minRotation: 45
                }
            }
        },
        plugins: {
            tooltip: {
                callbacks: {
                    label: function (tooltipItem) {
                        let total = <?= json_encode($totalGraduates) ?>[tooltipItem.dataIndex];
                        let misaligned = <?= json_encode($misalignedGraduates) ?>[tooltipItem.dataIndex];
                        let aligned = total - misaligned;
                        let alignedPercentage = total > 0 ? ((aligned / total) * 100).toFixed(2) : 0;

                        return [
                            'Total Graduates: ' + total,
                            'Misaligned Graduates: ' + misaligned,
                            'Aligned Graduates: ' + alignedPercentage + '%'
                        ];
                    }
                }
            }
        }
    }
});

            });
        <?php endif; ?>
    </script>

</body>
</html>
