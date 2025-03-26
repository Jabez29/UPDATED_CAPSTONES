<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/Caps/templates/nav.php');


?>

<div class="p-4 border rounded shadow-sm bg-white">
    <div class="block-heading text-center">
        <h2 class="text-info">Graduate Tracer Survey</h2>
    </div>

    <h3 class="mb-4">A. General Information</h3>

    <form action="http://localhost/Caps/validate/info.php" method="POST">
        <div class="form-group">
            <label>Student No.</label>
            <input type="text" name="student_number"
                value="<?= htmlspecialchars($_SESSION['alumni_data']['student_number'] ?? '') ?>" required>
        </div>

        <div class="form-group row">
            <div class="col-md-4">
                <label>Last Name</label>
                <input type="text" name="last_name"
                    value="<?= htmlspecialchars($_SESSION['alumni_data']['last_name'] ?? '') ?>" required>
            </div>
            <div class="col-md-4">
                <label>First Name</label>
                <input type="text" name="first_name"
                    value="<?= htmlspecialchars($_SESSION['alumni_data']['first_name'] ?? '') ?>" required>
            </div>
            <div class="col-md-4">
                <label>Middle Name</label>
                <input type="text" name="middle_name"
                    value="<?= htmlspecialchars($_SESSION['alumni_data']['middle_name'] ?? '') ?>">
            </div>
        </div>


        <label for="address">Permanent Address:</label>
        <input type="text" id="address" name="address" required><br><br>

        <label for="mobile">Mobile No.:</label>
        <input type="text" id="mobile" name="mobile"><br><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email"><br><br>

        <label for="civilstatus">Civil Status:</label>
        <select id="civilstatus" name="civilstatus" required>
            <option value="Single">Single</option>
            <option value="Married">Married</option>
        </select><br><br>

        <label for="gender">Gender:</label>
        <select id="gender" name="gender" required>
            <option value="M">Male</option>
            <option value="F">Female</option>
        </select><br><br>

        <label for="region">Region:</label>
        <select id="region" name="region_id" required>
            <option value="">Select Region</option>
        </select><br><br>

        <label for="province">Province:</label>
        <select id="province" name="province_id" required disabled>
            <option value="">Select Province</option>
        </select><br><br>

        <label for="city">City:</label>
        <select id="city" name="city_id" required disabled>
            <option value="">Select City</option>
        </select><br><br>

        <label for="barangay">Barangay:</label>
        <select id="barangay" name="barangay_id" required disabled>
            <option value="">Select Barangay</option>
        </select><br><br>
        

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>