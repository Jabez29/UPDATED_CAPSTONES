<?php

include_once '../CAPSTONE/templates/dash.php';
include_once '../CAPSTONE/models/graduate.php';

$graduateModel = new Graduates();
$graduates = $graduateModel->list(); // Ensure this assignment exists
?>


<div class="container-fluid mt-4">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    Alumni Managements
                </div>
                <table id="user-table" class="table table-striped table-success">
                    <thead class="table-dark">
                        <tr>
                            <th>Name</th>
                            <th>Student Number</th>
                            <th>Course</th>
                            <th>Graduation Year</th>
                            <th>Permanent Address</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($graduates as $graduate): ?>
                        <tr>
                            <td><?= htmlspecialchars($graduate['first_name'] . ' ' . $graduate['middle_name'] . ' ' . $graduate['last_name']) ?>
                            </td>
                            <td><?= htmlspecialchars($graduate['student_number']) ?></td>
                            <td><?= htmlspecialchars($graduate['course']) ?></td>
                            <td><?= htmlspecialchars($graduate['graduation_year']) ?></td>
                            <td><?= htmlspecialchars($graduate['permanent_address']) ?></td>
                            <td>
                                <button class="btn btn-info btn-sm details-btn" data-bs-toggle="modal"
                                    data-bs-target="#detailsModal" data-id="<?= $graduate['id'] ?>">
                                    Details
                                </button>
                                <button type="button" data-id="<?= $graduate['id'] ?>" class="btn-del btn btn-none">
                                    <img src="assets/img/delete.png" alt="delete" class="icons_delete">
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <?php
                include_once __DIR__ . '/../templates/details.php'; 
               include_once __DIR__ . '/../templates/form-sample.php'; 
include_once __DIR__ . '/../templates/confirm.php'; 
include_once __DIR__ . '/../templates/alert.php'; 
                ?>