<?php
include_once '../CAPSTONE/templates/dash.php';
require_once __DIR__ . '/../models/Users.php';

$users = new Users;
$lists = $users->list();


?>
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    User Managements
                </div>
                <div class="card-body">
                    <button type="button" id="user-add" class="btn btn-primary mb-2">Add Another User</button>
                    <div class="table-responsive">
                        <table id="user-table" class="table table-striped table-success">
                            <thead class="table-dark">
                                <tr>
                                    <th>Firstname</th>
                                    <th>Middlename</th>
                                    <th>Lastname</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <!-- <th>Password</th> -->
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($lists) {
                                    foreach ($lists as $id => $row) {
                                ?>
                                <tr>

                                    <td><?php echo $row['firstName'] ?></td>
                                    <td><?php echo $row['middleName'] ?></td>
                                    <td><?php echo $row['lastName'] ?></td>
                                    <td><?php echo $row['userName'] ?></td>
                                    <td><?php echo $row['email'] ?></td>


                                    <td>
                                        <button type="button" data-id="<?php echo $row['id'] ?>"
                                            class="btn-edit btn btn-none"><img src="assets/img/pen.png" alt="edit"
                                                class="icons_edit"></button>
                                        <button type="button" data-id="<?php echo $row['id'] ?>"
                                            class="btn-del btn btn-none"><img src="assets/img/delete.png" alt="delete"
                                                class="icons_delete"></button>
                                    </td>
                                </tr>
                                <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                        <!-- New button at the bottom -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include_once __DIR__ . '/../templates/form-sample.php'; 
include_once __DIR__ . '/../templates/confirm.php'; 
include_once __DIR__ . '/../templates/alert.php'; 
?>