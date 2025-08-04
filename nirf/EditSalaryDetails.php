<?php
include 'config.php';
require "header.php";
// error_reporting(E_ALL);
error_reporting(0);


$dept = $_SESSION['dept_id'];

// Fetch existing data for the record to edit
if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['ID'])) {
    $id = filter_var($_GET['ID'], FILTER_SANITIZE_NUMBER_INT);

    // Retrieve the current record
    $query = "SELECT * FROM `salary_details` WHERE `ID` = '$id' AND `DEPT_ID` = '$dept'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        if ($row) {
            $A_YEAR = trim(strip_tags($row['A_YEAR']));
            $p_name = trim(strip_tags($row['PROGRAM_NAME']));
            $p_code = trim(strip_tags($row['PROGRAM_CODE']));
            $Roll_No = trim(strip_tags($row['ROLL_NO']));
            $Student_Name = trim(strip_tags($row['STUDENT_NAME']));
            $Company_Name = trim(strip_tags($row['COMPANY_NAME']));
            $Designation = trim(strip_tags($row['DESIGNATION']));
            $Salary = trim(strip_tags($row['SALARY']));
            $Job_Order = trim(strip_tags($row['JOB_ORDER']));
        } else {
            echo "<script>alert('Record not found.')</script>";
            echo '<script>window.location.href = "SalaryDetails.php";</script>';
        }
    } else {
        echo "Error executing query: " . mysqli_error($conn);
    }
}

// Handle form submission for updating
if (isset($_POST['submit'])) {
    $p_name = $_POST['p_name'];

    // Fetch PROGRAM_CODE from program_master based on PROGRAM_NAME
    $select_query = "SELECT `PROGRAM_CODE` FROM `program_master` WHERE `PROGRAM_NAME` = '$p_name'";
    $result = mysqli_query($conn, $select_query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);

        if ($row) {
            $p_code = trim(strip_tags(filter_input(INPUT_POST, 'PROGRAM_CODE', FILTER_SANITIZE_STRING)));

            // Other form values
            $Roll_No = trim(strip_tags(filter_input(INPUT_POST, 'Roll_No', FILTER_SANITIZE_NUMBER_INT)));
            $Student_Name = trim(strip_tags(filter_input(INPUT_POST, 'Student_Name', FILTER_SANITIZE_STRING)));
            $Company_Name = trim(strip_tags(filter_input(INPUT_POST, 'Company_Name', FILTER_SANITIZE_STRING)));
            $Designation = trim(strip_tags(filter_input(INPUT_POST, 'Designation', FILTER_SANITIZE_STRING)));
            $Salary = trim(strip_tags(filter_input(INPUT_POST, 'Salary', FILTER_SANITIZE_NUMBER_INT)));
            $Job_Order = trim(strip_tags(filter_input(INPUT_POST, 'Job_Order', FILTER_SANITIZE_STRING)));

            // Update query
            $query = "UPDATE `salary_details` SET 
                        `PROGRAM_CODE` = '$p_code',
                        `PROGRAM_NAME` = '$p_name',
                        `ROLL_NO` = '$Roll_No',
                        `STUDENT_NAME` = '$Student_Name',
                        `COMPANY_NAME` = '$Company_Name',
                        `DESIGNATION` = '$Designation',
                        `SALARY` = '$Salary',
                        `JOB_ORDER` = '$Job_Order'
                      WHERE `ID` = '$id'";

            if (mysqli_query($conn, $query)) {
                echo "<script>alert('Data Updated.')</script>";
                echo '<script>window.location.href = "SalaryDetails.php";</script>';
            } else {
                echo "<script>alert('Woops! There was an error (Contact Admin if it continues).')</script>";
            }
        } else {
            echo "No matching PROGRAM_CODE found for PROGRAM_NAME: $p_name";
        }
    } else {
        echo "Error executing query: " . mysqli_error($conn);
    }
}
?>

<div class="div">
    <form class="fw-bold" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()" autocomplete="off">
        <div class="mb-3">
            <p class="text-center fs-4 "><b>Edit Salary Details (Employers)</b></p>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Academic Year</b></label>
            <input type="year" name="year" value="<?php echo $A_YEAR ?>" class="form-control" style="margin-top: 0;" disabled>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Department ID</b></label>
            <input type="text" name="dpt_id" value="<?php echo $dept ?>" class="form-control" style="margin-top: 0;" disabled>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Program Name</b></label>
            <select name="p_name" class="form-control" style="margin-top: 0;">
                <?php
                $sql = "SELECT * FROM `program_master`";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    if ($row['PROGRAM_NAME'] == $p_name) {
                        echo '<option selected value="' . htmlspecialchars($row['PROGRAM_NAME']) . '">' . htmlspecialchars($row['PROGRAM_NAME']) . '</option>';
                    } else {
                        echo '<option value="' . htmlspecialchars($row['PROGRAM_NAME']) . '">' . htmlspecialchars($row['PROGRAM_NAME']) . '</option>';
                    }
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Roll No</b></label>
            <input type="number" name="Roll_No" class="form-control" value="<?php echo $Roll_No ?>" placeholder="Enter the Roll No" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Student Name</b></label>
            <input type="text" name="Student_Name" class="form-control" value="<?php echo $Student_Name ?>" placeholder="Enter the Student Name" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Company Name</b></label>
            <input type="text" name="Company_Name" class="form-control" value="<?php echo $Company_Name ?>" placeholder="Enter the Company Name" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Designation</b></label>
            <input type="text" name="Designation" class="form-control" value="<?php echo $Designation ?>" placeholder="Enter your Designation" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Salary</b></label>
            <input type="number" name="Salary" class="form-control" value="<?php echo $Salary ?>" placeholder="Enter your Salary" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Job Order(Optional)</b></label>
            <input type="text" name="Job_Order" class="form-control" value="<?php echo $Job_Order ?>" placeholder="Enter your Job Order URL" style="margin-top: 0;">
        </div>

        <input type="submit" class="submit btn btn-primary" value="Update" name="submit" onclick="return Validate()">
    </form>
</div>

<?php
require "footer.php";
?>