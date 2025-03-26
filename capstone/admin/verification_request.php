<?php
include(__DIR__ . "/../includes/db_connect.php");
include_once __DIR__ . '/../templates/dash.php';


if (isset($_GET['approve'])) {
    $id = $_GET['approve'];
    $stmt = $pdo->prepare("UPDATE graduates SET status = 'approved' WHERE student_number = 
                           (SELECT student_number FROM verification_requests WHERE id = ?)");
    $stmt->execute([$id]);

    $stmt = $pdo->prepare("UPDATE verification_requests SET status = 'approved' WHERE id = ?");
    $stmt->execute([$id]);

    echo "<script>alert('User approved successfully!'); window.location.href='verify.php';</script>";
}

if (isset($_GET['reject'])) {
    $id = $_GET['reject'];
    $stmt = $pdo->prepare("UPDATE graduates SET status = 'rejected' WHERE student_number = 
                           (SELECT student_number FROM verification_requests WHERE id = ?)");
    $stmt->execute([$id]);

    $stmt = $pdo->prepare("UPDATE verification_requests SET status = 'rejected' WHERE id = ?");
    $stmt->execute([$id]);

    echo "<script>alert('User rejected successfully!'); window.location.href='verify.php';</script>";
}

// Fetch verification requests from the database
$query = "SELECT * FROM verification_requests ORDER BY request_date DESC";
$stmt = $pdo->query($query);
$verificationRequests = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification Requests</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .table-container {
            overflow-x: auto;
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #004085;
            color: white;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .actions a {
            text-decoration: none;
            padding: 8px 12px;
            margin: 2px;
            display: inline-block;
            border-radius: 5px;
        }

        .approve {
            background-color: green;
            color: white;
        }

        .reject {
            background-color: red;
            color: white;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Verification Requests</h2>
    <div class="table-container">
        <table border="1">
            <tr>
                <th>Course</th>
                <th>Name</th>
                <th>Student Number</th>
                <th>Graduation Year</th>
                <th>Request Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>

            <?php foreach ($verificationRequests as $row) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['course']); ?></td>
                    <td><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['middle_name'] .' '. $row['last_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['student_number']); ?></td>
                    <td><?php echo htmlspecialchars($row['graduation_year']); ?></td>
                    <td><?php echo htmlspecialchars($row['request_date']); ?></td>
                    <td><?php echo ucfirst(htmlspecialchars($row['status'])); ?></td>
                    <td class="actions">
                        <?php if ($row['status'] === 'pending') { ?>
                            <a href="?approve=<?php echo $row['id']; ?>" class="approve" onclick="return confirm('Approve this user?');">Approve</a>
                            <a href="?reject=<?php echo $row['id']; ?>" class="reject" onclick="return confirm('Reject this user?');">Reject</a>
                        <?php } else { ?>
                            <?php echo ucfirst(htmlspecialchars($row['status'])); ?>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>

</body>
</html>
