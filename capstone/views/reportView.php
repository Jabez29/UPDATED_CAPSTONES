<?php 
include_once '../CAPSTONE/templates/dash.php';
include __DIR__ . '/../models/fetch.php';

$employmentData = getEmploymentData($pdo);

$courses = [];
$years = [];
$employmentDataByYear = [];
$statuses = ['Regular', 'Contractual', 'Temporary', 'Self-Employed', 'Casual', 'Never Employed', 'Unemployed'];

// Ensure all statuses have a total count
$totalCounts = array_fill_keys($statuses, 0);

$selectedCourse = $_GET['course'] ?? 'BSIT';
$selectedYear = $_GET['year'] ?? 'All';
$selectedStatus = $_GET['status'] ?? 'All';

foreach ($employmentData as $data) {
    $course = trim($data['course']);
    $year = $data['graduation_year'];
    $status = ucwords(strtolower(trim($data['employment_status']))) ?: 'Unknown';

    // Ensure database has correct format
    if ($status === "Self-employed") {
        $status = "Self-Employed"; // Standardized format
    }

    if (!in_array($course, $courses)) {
        $courses[] = $course;
    }
    if (!in_array($year, $years)) {
        $years[] = $year;
    }

    // Apply filtering for dropdown selections
    if (($selectedCourse === 'All' || $course === $selectedCourse) && 
        ($selectedYear === 'All' || $year == $selectedYear) &&
        ($selectedStatus === 'All' || $status === $selectedStatus)) {
        
        if (!isset($employmentDataByYear[$year])) {
            $employmentDataByYear[$year] = array_fill_keys($statuses, 0);
        }

        $employmentDataByYear[$year][$status] += (int)$data['total'];

        if (isset($totalCounts[$status])) {
            $totalCounts[$status] += (int)$data['total'];
        }
    }
}

// Sort years in descending order and add "All" option
rsort($years);
$years = array_merge(['All'], $years);

$yearsLabels = array_keys($employmentDataByYear);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Employment Statistics</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #f3f3f3, #c9d6ff);
            margin: 0;
            padding: 20px;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            padding: 20px;
            text-align: center;
        }

        h2 {
            color: #4CAF50;
        }

        select {
            padding: 8px;
            font-size: 1rem;
            border-radius: 5px;
            margin: 10px 5px;
        }

        .total-card {
            background: #4CAF50;
            color: #fff;
            padding: 15px;
            border-radius: 8px;
            font-size: 1.2rem;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
        }

        .chart-container {
            position: relative;
            width: 100%;
            height: 500px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Employment Statistics</h2>
        <form method="GET">
            <label for="course">Select Course:</label>
            <select name="course" onchange="this.form.submit()">
                <option value="All">All Courses</option>
                <?php foreach ($courses as $course): ?>
                <option value="<?= $course ?>" <?= $course === $selectedCourse ? 'selected' : '' ?>>
                    <?= $course ?>
                </option>
                <?php endforeach; ?>
            </select>
            
            <label for="year">Select Year:</label>
            <select name="year" onchange="this.form.submit()">
                <?php foreach ($years as $year): ?>
                <option value="<?= $year ?>" <?= $year == $selectedYear ? 'selected' : '' ?>>
                    <?= $year ?>
                </option>
                <?php endforeach; ?>
            </select>

            <label for="status">Employment Status:</label>
            <select name="status" onchange="this.form.submit()">
                <option value="All">All Statuses</option>
                <?php foreach ($statuses as $status): ?>
                <option value="<?= $status ?>" <?= $status === $selectedStatus ? 'selected' : '' ?>>
                    <?= $status ?>
                </option>
                <?php endforeach; ?>
            </select>
        </form>

        <div class="total-card">
            <?php foreach ($totalCounts as $status => $count): ?>
                <?= $status ?>: <?= $count ?> |
            <?php endforeach; ?>
        </div>
        
        <div class="chart-container">
            <canvas id="employmentChart"></canvas>
        </div>
    </div>

    <script>
const ctx = document.getElementById('employmentChart').getContext('2d');

const statusColors = {
    "Regular": "rgba(75, 192, 192, 0.8)",
    "Contractual": "rgba(255, 99, 132, 0.8)",
    "Temporary": "rgba(255, 206, 86, 0.8)",
    "Self-Employed": "rgba(54, 162, 235, 0.8)",
    "Casual": "rgba(153, 102, 255, 0.8)",
    "Never Employed": "rgba(255, 159, 64, 0.8)",
    "Unemployed": "rgba(201, 203, 207, 0.8)"
};

let chartData = {
    labels: <?= json_encode($yearsLabels) ?>,
    datasets: [
        <?php foreach ($statuses as $status): ?>
        {
            label: '<?= $status ?>',
            data: <?= json_encode(array_map(fn($year) => $employmentDataByYear[$year][$status] ?? 0, $yearsLabels)) ?>,
            backgroundColor: statusColors["<?= $status ?>"] ?? "rgba(0, 0, 0, 0.8)",
            borderColor: statusColors["<?= $status ?>"] ?? "rgba(0, 0, 0, 1)",
            borderWidth: 2
        },
        <?php endforeach; ?>
    ]
};

new Chart(ctx, {
    type: 'bar',
    data: chartData,
    options: {
        responsive: true,
        plugins: { legend: { position: 'top' } },
        scales: { x: { stacked: false }, y: { stacked: false, beginAtZero: true } }
    }
});
</script>

</body>
</html>
