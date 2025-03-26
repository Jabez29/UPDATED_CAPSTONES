<?php
session_start();
include '../includes/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $pdo->beginTransaction();

        // 🔍 Get `graduate_id` from session or fetch from database
        $graduate_id = $_SESSION['graduate_id'] ?? null;
        if (!$graduate_id) {
            $stmt = $pdo->prepare("SELECT id FROM graduates WHERE student_number = ?");
            $stmt->execute([$_SESSION['student_number'] ?? null]);
            $graduate = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($graduate) {
                $graduate_id = $graduate['id'];
                $_SESSION['graduate_id'] = $graduate_id;
            } else {
                throw new Exception("Graduate ID not found. Please log in again.");
            }
        }

        // 🛠️ Replace `NULL` with empty string or default values
        $stmt = $pdo->prepare("
            INSERT INTO employment_survey 
            (graduate_id, employed, reason_not_employed, other_reason_specify, employment_status, company_name, 
            business_type, other_business_type, work_place, first_job, job_search, break_duration, other_break_duration, 
            first_job_related, reason_for_accepting, other_accepting_reason, reason_for_changing, other_changing_reason, 
            first_job_promoted, time_before_promotion, other_promotion_time, first_job_duration, other_first_job_duration, 
            job_finding_method, other_job_finding_method, time_to_land_first_job, other_time_to_land_first_job, first_job_level) 
            VALUES (:graduate_id, :employed, :reason_not_employed, :other_reason_specify, :employment_status, :company_name, 
            :business_type, :other_business_type, :work_place, :first_job, :job_search, :break_duration, :other_break_duration, 
            :first_job_related, :reason_for_accepting, :other_accepting_reason, :reason_for_changing, :other_changing_reason, 
            :first_job_promoted, :time_before_promotion, :other_promotion_time, :first_job_duration, :other_first_job_duration, 
            :job_finding_method, :other_job_finding_method, :time_to_land_first_job, :other_time_to_land_first_job, :first_job_level)
        ");

        $success = $stmt->execute([
            ':graduate_id' => $graduate_id,
            ':employed' => $_POST['employed'] ?? 'no', 
            ':reason_not_employed' => $_POST['reason_not_employed'] ?? '',
            ':other_reason_specify' => $_POST['other_reason_specify'] ?? '',
            ':employment_status' => $_POST['employment_status'] ?? 'unemployed',
            ':company_name' => $_POST['company_name'] ?? 'N/A',
            ':business_type' => $_POST['business_type'] ?? 'N/A',
            ':other_business_type' => $_POST['other_business_type'] ?? '',
            ':work_place' => $_POST['work_place'] ?? 'N/A',
            ':first_job' => $_POST['first_job'] ?? 'no',
            ':job_search' => $_POST['job_search'] ?? '',
            ':break_duration' => $_POST['break_duration'] ?? 'none',
            ':other_break_duration' => $_POST['other_break_duration'] ?? '',
            ':first_job_related' => $_POST['first_job_related'] ?? 'no',
            ':reason_for_accepting' => $_POST['reason_for_accepting'] ?? '',
            ':other_accepting_reason' => $_POST['other_accepting_reason'] ?? '',
            ':reason_for_changing' => $_POST['reason_for_changing'] ?? '',
            ':other_changing_reason' => $_POST['other_changing_reason'] ?? '',
            ':first_job_promoted' => $_POST['first_job_promoted'] ?? 'no',
            ':time_before_promotion' => $_POST['time_before_promotion'] ?? '',
            ':other_promotion_time' => $_POST['other_promotion_time'] ?? '',
            ':first_job_duration' => $_POST['first_job_duration'] ?? 'N/A',
            ':other_first_job_duration' => $_POST['other_first_job_duration'] ?? '',
            ':job_finding_method' => $_POST['job_finding_method'] ?? '',
            ':other_job_finding_method' => $_POST['other_job_finding_method'] ?? '',
            ':time_to_land_first_job' => $_POST['time_to_land_first_job'] ?? '',
            ':other_time_to_land_first_job' => $_POST['other_time_to_land_first_job'] ?? '',
            ':first_job_level' => $_POST['first_job_level'] ?? ''
        ]);

        if ($success) {
            $pdo->commit();
            echo "<script>
                    alert('Data submitted successfully!');
                    window.location.href = 'http://localhost/caps/landingpage.php';
                  </script>";
            exit();
        } else {
            throw new Exception("Failed to insert data.");
        }
    } catch (Exception $e) {
        $pdo->rollBack();
        error_log("Error: " . $e->getMessage());
        echo "<script>
                alert('An error occurred while submitting the form.');
                window.history.back();
              </script>";
        exit();
    }
} else {
    echo "<script>
            alert('Invalid request method.');
            window.history.back();
          </script>";
    exit();
}
?>
