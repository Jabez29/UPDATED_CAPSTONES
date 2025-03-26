<div class="content">
    <nav class="navbar fixed-top navbar-light bg-light">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="assets/img/actscc_logo.png" width="50" height="50" class="d-inline-block align-top" alt="Logo">
            <span id="alumniText" class="ml-2"
                style="font-family: 'Arial', sans-serif; font-weight: bold; color: black; margin-left: 10px;">
                ALUMNI TRACER SYSTEM
            </span>
        </a>
        <div class="ml-auto d-flex align-items-center">
            <a href="#" class="mr-3 text-dark" title="Notifications">
                <i class="fas fa-bell fa-lg"></i>
            </a>
            <div class="dropdown">
                <a class="nav-link dropdown-toggle text-dark" href="#" id="profileDropdown" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-user-circle fa-lg"></i> Profile
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profileDropdown">
                    <a class="dropdown-item" href="#">Settings</a>
                    <a class="dropdown-item" href="#">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="sidebar" id="sidebar"
        style="position: fixed; top: 60px; left: 0; width: 250px; height: 100%; background-color: #f8f9fa; padding-top: 20px; z-index: 1000;">
        <ul class="list-group">
            <li class="list-group-item">
                <a href="../Capstone/dash.php">
                    <img src="assets/img/speedometer.png" width="20" height="20" alt="Dashboard" class="mr-2">Dashboard
                </a>
            </li>
            <li class="list-group-item dropdown">
                <a class="" href="#" id="manageAlumniDropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    <img src="assets/img/student.png" width="20" height="20" alt="Alumni Courses" class="mr-2">Manage
                    Alumni
                </a>
                <!-- <div class="dropdown-menu" aria-labelledby="manageAlumniDropdown">
                    <a class="dropdown-item" href="../CAPSTONEDASHBOARD/bsit.php">
                        <img src="assets/img/bsit-icon.png" width="15" height="15" alt="BSIT" class="mr-2">
                    </a>
                    <a class="dropdown-item" href="#">
                        <img src="assets/img/bscs-icon.png" width="15" height="15" alt="BSCS" class="mr-2">
                    </a>
                    <a class="dropdown-item" href="#">
                        <img src="assets/img/bsba-icon.png" width="15" height="15" alt="BSBA" class="mr-2">
                    </a>
                </div> -->
            </li>
            <li class="list-group-item">
                <a href="../capstone/report.php">
                    <img src="assets/img/megaphone.png" width="20" height="20" alt="Reports" class="mr-2">Reports
                </a>
            </li>
            <li class="list-group-item">
                <a href="#">
                    <img src="assets/img/usermanagement.png" width="20" height="20" alt="User Management"
                        class="mr-2">User Management
                </a>
            </li>
        </ul>
    </div>