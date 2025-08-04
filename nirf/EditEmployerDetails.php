<?php
include 'config.php';
require "header.php";
// error_reporting(E_ALL);
error_reporting(0);


$dept = $_SESSION['dept_id'];

if (isset($_GET['ID'])) {
    $id = filter_var($_GET['ID'], FILTER_SANITIZE_NUMBER_INT);

    // Fetch existing data for editing
    $sql = "SELECT * FROM employers_details WHERE ID = '$id' AND DEPT_ID = '$dept'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        // Populate the form with existing data
        $First_Name = trim(strip_tags($row['FIRST_NAME']));
        $Last_Name = trim(strip_tags($row['LAST_NAME']));
        $Designation = trim(strip_tags($row['DESIGNATION']));
        $Type_of_Industry = trim(strip_tags($row['TYPE_OF_INDUSTRY']));
        $Company = trim(strip_tags($row['COMPANY']));
        $Location = trim(strip_tags($row['LOCATION']));
        $Email_ID = trim(strip_tags($row['EMAIL_ID']));
        $Phone_Number = trim(strip_tags($row['PHONE']));
        $type = trim(strip_tags($row['TYPE_INDIAN_FOREIGN']));
    } else {
        echo "<script>alert('Record not found.');</script>";
        echo '<script>window.location.href = "EmployerDetails.php";</script>';
    }
}

if (isset($_POST['submit'])) {
    $First_Name = trim(strip_tags(filter_input(INPUT_POST, 'First_Name', FILTER_SANITIZE_STRING)));
    $Last_Name = trim(strip_tags(filter_input(INPUT_POST, 'Last_Name', FILTER_SANITIZE_STRING)));
    $Designation = trim(strip_tags(filter_input(INPUT_POST, 'Designation', FILTER_SANITIZE_STRING)));
    $Type_of_Industry = trim(strip_tags(filter_input(INPUT_POST, 'Type_of_Industry', FILTER_SANITIZE_STRING)));
    $Company = trim(strip_tags(filter_input(INPUT_POST, 'Company', FILTER_SANITIZE_STRING)));
    $Location = trim(strip_tags(filter_input(INPUT_POST, 'Location', FILTER_SANITIZE_STRING)));
    $Email_ID = trim(strip_tags(filter_input(INPUT_POST, 'Email_ID', FILTER_SANITIZE_EMAIL)));
    $Phone_Number = trim(strip_tags(filter_input(INPUT_POST, 'Phone_Number', FILTER_SANITIZE_NUMBER_INT)));
    $type = trim(strip_tags(filter_input(INPUT_POST, 'type', FILTER_SANITIZE_STRING)));

    // Update existing data
    $query = "UPDATE employers_details SET 
                FIRST_NAME = '$First_Name',
                LAST_NAME = '$Last_Name',
                DESIGNATION = '$Designation',
                TYPE_OF_INDUSTRY = '$Type_of_Industry',
                COMPANY = '$Company',
                LOCATION = '$Location',
                EMAIL_ID = '$Email_ID',
                PHONE = '$Phone_Number',
                TYPE_INDIAN_FOREIGN = '$type'
              WHERE ID = '$id' AND DEPT_ID = '$dept'";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Data Updated.')</script>";
        echo '<script>window.location.href = "EmployerDetails.php";</script>';
    } else {
        echo "<script>alert('Error updating data.')</script>";
    }
}

?>

<div class="div">
    <form class="fw-bold" method="POST" enctype="multipart/form-data" autocomplete="off">
        <div class="mb-3">
            <p class="text-center fs-4 "><b>Edit Employer Details</b></p>
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
            <label class="form-label" style="margin-bottom: 6px;"><b>First Name</b></label>
            <input type="text" name="First_Name" class="form-control" value="<?php echo $First_Name ?>" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Last Name</b></label>
            <input type="text" name="Last_Name" class="form-control" value="<?php echo $Last_Name ?>" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Designation</b></label>
            <input type="text" name="Designation" class="form-control" value="<?php echo $Designation ?>" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Type of Industry</b></label>
            <input type="text" name="Type_of_Industry" class="form-control" value="<?php echo $Type_of_Industry ?>" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Company</b></label>
            <input type="text" name="Company" class="form-control" value="<?php echo $Company ?>" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Location</b></label>
            <input type="text" name="Location" class="form-control" value="<?php echo $Location ?>" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Email ID</b></label>
            <input type="email" name="Email_ID" class="form-control" value="<?php echo $Email_ID ?>" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Phone Number</b></label>
            <input type="number" name="Phone_Number" class="form-control" value="<?php echo $Phone_Number ?>" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Type (Indian/Foreign)</b></label>
            <select name="type" class="form-control" style="margin-top: 0;">
                <option value="Indian" <?php echo ($type == 'Indian') ? 'selected' : ''; ?>>Indian</option>
                <option value="Foreign" <?php echo ($type == 'Foreign') ? 'selected' : ''; ?>>Foreign</option>
            </select>
        </div>

        <input type="submit" class="submit btn btn-primary" value="Update" name="submit">
    </form>
</div>

<?php
require "footer.php";
?>