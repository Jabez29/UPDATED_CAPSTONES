<nav class="navbar fixed-top" style="background-color: #1d8348;">
    <a class="navbar-brand d-flex align-items-center" href="#">
        <img src="assets/icon/actscc_logo.png" width="50" height="50" class="d-inline-block align-top" alt="Logo"
            style="margin-right: 10px;">
        <span id="alumniText" class="ml-2"
            style="font-family: 'Arial', sans-serif; font-weight: bold; margin-left: 10px;">ALUMNI TRACER SYSTEM</span>
    </a>
</nav>

<body style="background-image: url('assets/icon/1.jpg'); background-size: cover; background-position: center; background-attachment: fixed;">
    <div class="background-div" style="position: relative; width: 100%; height: auto;">
        <form action="http://localhost/Caps/validate/graduate.php" method="POST"
            style="max-width: 800px; width: 100%; background: rgba(255, 255, 255, 0.9); padding: 20px; border-radius: 10px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); position: relative; margin: 50px auto;">
            
            <header style="text-align: center; margin-bottom: 20px;">
                <h2>Graduate Verification Form</h2>
                <p style="color: #666;">Please fill out the form below to verify your information.</p>
            </header>

            <div style="display: flex; gap: 15px; margin-bottom: 15px;">
                <div class="form-group" style="flex: 1;">
                    <label for="firstName">First Name</label>
                    <input type="text" id="firstName" name="first_name" placeholder="Enter First Name" required>
                </div>
                <div class="form-group" style="flex: 1;">
                    <label for="middleName">Middle Name</label>
                    <input type="text" id="middleName" name="middle_name" placeholder="Enter Middle Name">
                </div>
                <div class="form-group" style="flex: 1;">
                    <label for="lastName">Last Name</label>
                    <input type="text" id="lastName" name="last_name" placeholder="Enter Last Name" required>
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 15px;">
                <label for="studentNumber">Student Number</label>
                <input type="text" id="studentNumber" name="student_number"
                    value="<?= isset($_COOKIE['student_number']) ? htmlspecialchars($_COOKIE['student_number']) : ''; ?>"
                    required placeholder="Enter Student Number">
                <span id="student_number_error" style="color: red; font-weight: bold;"></span>
            </div>

            <div class="form-group" style="margin-bottom: 15px;">
                <label for="course">Course</label>
                <select id="course" name="course" required style="width: 100%;">
                    <option value="" disabled selected>Select Course</option>
                    <option value="BSIT">Bachelor of Information Technology</option>
                    <option value="BSCS">Bachelor of Computer Science</option>
                    <option value="BSBA">Bachelor of Business Administration</option>
                    <option value="BSEnt">Bachelor of Science Entrepreneurship</option>
                    <option value="BSAcc">Bachelor of Science in Accounting</option>
                    <option value="BTVTE">Bachelor in Technical-Vocational Teacher Education</option>
                    <option value="BSSA">Bachelor of Science in Secretarial Administration</option>
                </select>
            </div>

            <div class="form-group" style="margin-bottom: 15px;">
                <label for="graduationYear">Year of Graduation</label>
                <select id="graduationYear" name="graduation_year" required style="width: 100%;">
                    <!-- JavaScript will add years dynamically -->
                </select>
            </div>

            <button type="submit" class="btn btn-success" style="width: 100%;">Verify</button>
        </form>
    </div>

</body>
