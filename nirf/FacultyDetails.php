<?php
include 'config.php';
require "header.php";
// error_reporting(E_ALL);
error_reporting(0);


$dept = $_SESSION['dept_id'];

// ################################################################################################################
// Fetch all faculty emails for the logged-in department
$email_query = "SELECT EMAIL_ID FROM faculty_details WHERE DEPT_ID = ?";
$stmt = $conn->prepare($email_query);
$stmt->bind_param("i", $dept);
$stmt->execute();
$email_result = $stmt->get_result();

// Fetch the latest data for the selected email (if any)
$selected_email = $_POST['selected_email'] ?? ''; // Get selected email from the form
$latest_data = [];

if ($selected_email) {
    $fetch_query = "SELECT * FROM faculty_details WHERE DEPT_ID = ? AND EMAIL_ID = ? ORDER BY ID DESC LIMIT 1";
    $fetch_stmt = $conn->prepare($fetch_query);
    $fetch_stmt->bind_param("is", $dept, $selected_email);
    $fetch_stmt->execute();
    $fetch_result = $fetch_stmt->get_result();
    if ($fetch_result && mysqli_num_rows($fetch_result) > 0) {
        $latest_data = mysqli_fetch_assoc($fetch_result); // Fetch the latest row of data
    }
}
// ################################################################################################################

if (isset($_POST['submit'])) {

    $Faculty_Name = trim(strip_tags(filter_input(INPUT_POST, 'Faculty_Name', FILTER_SANITIZE_STRING))); // (int)$_POST['Faculty_Name']); // (int)$_POST['Faculty_Name'];
    $gender = trim(strip_tags(filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_STRING)));
    $designation = trim(strip_tags(filter_input(INPUT_POST, 'designation', FILTER_SANITIZE_STRING)));;
    $DOB = trim(strip_tags(filter_input(INPUT_POST, 'DOB', FILTER_SANITIZE_STRING)));
    $Age = trim(strip_tags(filter_input(INPUT_POST, 'Age', FILTER_SANITIZE_NUMBER_INT)));
    $qualification = trim(strip_tags(filter_input(INPUT_POST, 'qualification', FILTER_SANITIZE_STRING)));;
    $experience = trim(strip_tags(filter_input(INPUT_POST, 'experience', FILTER_SANITIZE_STRING)));;
    $pan_number = trim(strip_tags(filter_input(INPUT_POST, 'pan_number', FILTER_SANITIZE_STRING)));;
    $Associated = trim(strip_tags(filter_input(INPUT_POST, 'Associated', FILTER_SANITIZE_STRING)));;
    $Teaching = trim(strip_tags(filter_input(INPUT_POST, 'Teaching', FILTER_SANITIZE_STRING)));;
    $Industrial = trim(strip_tags(filter_input(INPUT_POST, 'Industrial', FILTER_SANITIZE_STRING)));;
    $Date_of_joining = trim(strip_tags(filter_input(INPUT_POST, 'Date_of_joining', FILTER_SANITIZE_STRING)));;
    $latest_joining = trim(strip_tags(filter_input(INPUT_POST, 'latest_joining', FILTER_SANITIZE_STRING)));;
    $Association_Type = trim(strip_tags(filter_input(INPUT_POST, 'Association_Type', FILTER_SANITIZE_STRING)));;
    $EmailID_of_Faculty = trim(strip_tags(filter_input(INPUT_POST, 'EmailID_of_Faculty', FILTER_SANITIZE_EMAIL)));;
    $Mobile_Number_of_Faculty = trim(strip_tags(filter_input(INPUT_POST, 'Mobile_Number_of_Faculty', FILTER_SANITIZE_NUMBER_INT)));;
    $Name_of_Award = trim(strip_tags(filter_input(INPUT_POST, 'Name_of_Award', FILTER_SANITIZE_STRING)));;
    $Level_of_Award = trim(strip_tags(filter_input(INPUT_POST, 'Level_of_Award', FILTER_SANITIZE_STRING)));;
    $Name_of_Award_Agency = trim(strip_tags(filter_input(INPUT_POST, 'Name_of_Award_Agency', FILTER_SANITIZE_STRING)));;
    $Address_of_Award_Agency = trim(strip_tags(filter_input(INPUT_POST, 'Address_of_Award_Agency', FILTER_SANITIZE_STRING)));;
    $Year_of_Received_Award = trim(strip_tags(filter_input(INPUT_POST, 'Year_of_Received_Award', FILTER_SANITIZE_STRING)));;
    $EmailID_of_Agency = trim(strip_tags(filter_input(INPUT_POST, 'EmailID_of_Agency', FILTER_SANITIZE_EMAIL)));;
    $Contact_of_Agency = trim(strip_tags(filter_input(INPUT_POST, 'Contact_of_Agency', FILTER_SANITIZE_NUMBER_INT)));;

    $query = "INSERT INTO `faculty_details`(`A_YEAR`, `DEPT_ID`, `FACULTY_NAME`, `GENDER`, `DESIGNATION`, `DOB`, `AGE`, `QUALIF`, `EXPERIENCE`, `PAN_NUM`, `FACULTY_ASSO_IN_PREV_YEAR`, `FACULTY_EXP_TEACHING`, `FACULTY_EXP_INDUSTRIAL`, `JOINING_INSTITUTE_DATE`, `LATEST_DATE`, `ASSOC_TYPE`, `EMAIL_ID`, `MOBILE_NUM`, `NAME_OF_AWARD`, `LEVEL_OF_AWARD`, `NAME_OF_AWARD_AGENCY`, `ADD_OF_AWARD_AGENCY`, `YEAR_OF_RECEIVED_AWARD`, `EMAIL_OF_AGENCY`, `CONTACT_OF_AGENCY`) 
    VALUES ('$A_YEAR', '$dept','$Faculty_Name','$gender','$designation', '$DOB', '$Age','$qualification','$experience','$pan_number', '$Associated', '$Teaching', '$Industrial','$Date_of_joining','$latest_joining','$Association_Type', '$EmailID_of_Faculty', '$Mobile_Number_of_Faculty','$Name_of_Award','$Level_of_Award','$Name_of_Award_Agency', '$Address_of_Award_Agency', '$Year_of_Received_Award','$EmailID_of_Agency','$Contact_of_Agency')
    ON DUPLICATE KEY UPDATE
    FACULTY_NAME = VALUES(FACULTY_NAME),
    GENDER = VALUES(GENDER),
    DESIGNATION = VALUES(DESIGNATION),
    DOB = VALUES(DOB),
    AGE = VALUES(AGE),
    QUALIF = VALUES(QUALIF),
    EXPERIENCE = VALUES(EXPERIENCE),
    PAN_NUM = VALUES(PAN_NUM),
    FACULTY_ASSO_IN_PREV_YEAR = VALUES(FACULTY_ASSO_IN_PREV_YEAR),
    FACULTY_EXP_TEACHING = VALUES(FACULTY_EXP_TEACHING),
    FACULTY_EXP_INDUSTRIAL = VALUES(FACULTY_EXP_INDUSTRIAL),
    JOINING_INSTITUTE_DATE = VALUES(JOINING_INSTITUTE_DATE),
    LATEST_DATE = VALUES(LATEST_DATE),
    ASSOC_TYPE = VALUES(ASSOC_TYPE),
    EMAIL_ID = VALUES(EMAIL_ID),
    MOBILE_NUM = VALUES(MOBILE_NUM),
    NAME_OF_AWARD = VALUES(NAME_OF_AWARD),
    LEVEL_OF_AWARD = VALUES(LEVEL_OF_AWARD),
    NAME_OF_AWARD_AGENCY = VALUES(NAME_OF_AWARD_AGENCY),
    ADD_OF_AWARD_AGENCY = VALUES(ADD_OF_AWARD_AGENCY),
    YEAR_OF_RECEIVED_AWARD = VALUES(YEAR_OF_RECEIVED_AWARD),
    EMAIL_OF_AGENCY = VALUES(EMAIL_OF_AGENCY),
    CONTACT_OF_AGENCY = VALUES(CONTACT_OF_AGENCY)";

    
    // $q=mysqli_query($conn,$query);
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Data Entered.')</script>";
        echo '<script>window.location.href = "FacultyDetails.php";</script>';
    } else {
        echo "<script>alert('Woops! There was an error (Contact Admin if it continues).')</script>";
    }
}

if (isset($_GET['action'])) {
    $action = $_GET['action'];
    if ($action == 'delete') {
        $id = filter_var($_GET['ID'], FILTER_SANITIZE_NUMBER_INT);
        $sql = mysqli_query($conn, "delete from faculty_details where ID = '$id'");
        echo '<script>window.location.href = "FacultyDetails.php";</script>';
    }
}
?>
<div class="div">
    <form class="fw-bold" method="POST" enctype="multipart/form-data" autocomplete="off">
        <div class="mb-3">
            <p class="text-center fs-4 "><b>Faculty Details</b></p>
        </div>

         <!-- ################################################################################################################ -->

         <div class="alert alert-danger align-content-between justify-content-center" role="alert">
                    <h5><b>Important Notes</b></h5>
                    <ul type="dot">
                        <li style="font-weight: 200;"><b>While fetching emails, verify the data before submitting it.</b></li>
                    </ul>   
                </div>

         <!-- Dropdown to select email -->
         <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Select Fetch Faculty Email</b></label>
            <select name="selected_email" class="form-control" style="margin-top: 0;" onchange="fetchFacultyData()">
                <option value="">Select an email</option>
                <?php
                $email_query = "SELECT DISTINCT  EMAIL_ID FROM faculty_details WHERE DEPT_ID = $dept ORDER BY EMAIL_ID";
                $email_result = mysqli_query($conn, $email_query);
                while ($email_row = mysqli_fetch_assoc($email_result)) {
                    $email_value = $email_row['EMAIL_ID'];
                    echo "<option value='$email_value'>$email_value</option>";
                }
                ?>
            </select>
        </div>

        <script>
        function fetchFacultyData() {
            const email = document.querySelector('select[name="selected_email"]').value;
            if (!email) return; // Do nothing if no email is selected

            // Send an AJAX request to fetch data
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'fetch_faculty_data.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                if (xhr.status === 200) {
                    const data = JSON.parse(xhr.responseText);
                    if (data) {
                        // Pre-fill the form fields with the fetched data
                        document.querySelector('input[name="Faculty_Name"]').value = data.FACULTY_NAME || '';
                        document.querySelector('select[name="gender"]').value = data.GENDER || '';
                        document.querySelector('select[name="designation"]').value = data.DESIGNATION || '';
                        document.querySelector('input[name="DOB"]').value = data.DOB || '';
                        document.querySelector('input[name="Age"]').value = data.AGE || '';
                        document.querySelector('input[name="qualification"]').value = data.QUALIF || '';
                        document.querySelector('input[name="experience"]').value = data.EXPERIENCE || '';
                        document.querySelector('input[name="pan_number"]').value = data.PAN_NUM || '';
                        document.querySelector('select[name="Associated"]').value = data.FACULTY_ASSO_IN_PREV_YEAR || '';
                        document.querySelector('input[name="Teaching"]').value = data.FACULTY_EXP_TEACHING || '';
                        document.querySelector('input[name="Industrial"]').value = data.FACULTY_EXP_INDUSTRIAL || '';
                        document.querySelector('input[name="Date_of_joining"]').value = data.JOINING_INSTITUTE_DATE || '';
                        document.querySelector('input[name="latest_joining"]').value = data.LATEST_DATE || '';
                        document.querySelector('select[name="Association_Type"]').value = data.ASSOC_TYPE || '';
                        document.querySelector('input[name="EmailID_of_Faculty"]').value = data.EMAIL_ID || '';
                        document.querySelector('input[name="Mobile_Number_of_Faculty"]').value = data.MOBILE_NUM || '';
                        document.querySelector('input[name="Name_of_Award"]').value = data.NAME_OF_AWARD || '';
                        document.querySelector('select[name="Level_of_Award"]').value = data.LEVEL_OF_AWARD || '';
                        document.querySelector('input[name="Name_of_Award_Agency"]').value = data.NAME_OF_AWARD_AGENCY || '';
                        document.querySelector('input[name="Address_of_Award_Agency"]').value = data.ADD_OF_AWARD_AGENCY || '';
                        document.querySelector('input[name="Year_of_Received_Award"]').value = data.YEAR_OF_RECEIVED_AWARD || '';
                        document.querySelector('input[name="EmailID_of_Agency"]').value = data.EMAIL_OF_AGENCY || '';
                        document.querySelector('input[name="Contact_of_Agency"]').value = data.CONTACT_OF_AGENCY || '';
                    }
                }
            };
            xhr.send(`email=${encodeURIComponent(email)}&dept_id=<?php echo $dept; ?>`);
        }
        </script>

         <!-- ################################################################################################################ -->



        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Academic Year</b></label>
            <input type="year" name="year" value="<?php echo $A_YEAR ?>" class="form-control" style="margin-top: 0;" disabled>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Department ID</b></label>
            <input type="text" name="dpt_id" value="<?php echo $dept ?>" class="form-control" style="margin-top: 0;" disabled>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Faculty Name</b></label>
            <input type="text" name="Faculty_Name" class="form-control" placeholder="Enter Name" value="<?php echo $latest_data['FACULTY_NAME'] ?? ''; ?>" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Gender</b></label>
            <select name="gender" class="form-control" style="margin-top: 0;" required>
                <option value="" disabled <?php echo empty($latest_data['GENDER']) ? 'selected' : ''; ?>>Select</option>
                <option value="Male" <?php echo ($latest_data['GENDER'] ?? '') == 'Male' ? 'selected' : ''; ?>>Male</option>
                <option value="Female" <?php echo ($latest_data['GENDER'] ?? '') == 'Female' ? 'selected' : ''; ?>>Female</option>
                <option value="other" <?php echo ($latest_data['GENDER'] ?? '') == 'other' ? 'selected' : ''; ?>>Other</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Designation</b></label>
            <select name="designation" class="form-control" style="margin-top: 0;" required>
                <option value="" disabled <?php echo empty($latest_data['Designation'])? 'selected': '';?>>Select</option>
                <option value="PROFESSOR" <?php echo ($latest_data['DESIGNATION'] ?? '') == 'PROFESSOR' ? 'selected' : ''; ?>>PROFESSOR</option>
                <option value="ASSOCIATE PROFESSOR" <?php echo ($latest_data['DESIGNATION'] ?? '') == 'ASSOCIATE PROFESSOR' ? 'selected' : ''; ?>>ASSOCIATE PROFESSOR</option>
                <option value="ASSISTANT PROFESSOR" <?php echo ($latest_data['DESIGNATION'] ?? '') == 'ASSISTANT PROFESSOR' ? 'selected' : ''; ?>>ASSISTANT PROFESSOR</option>
                <option value="ADJUNCT PROFESSOR" <?php echo ($latest_data['DESIGNATION'] ?? '') == 'ADJUNCT PROFESSOR' ? 'selected' : ''; ?>>ADJUNCT PROFESSOR</option>
                <option value="CHAIR PROFESSOR" <?php echo ($latest_data['DESIGNATION'] ?? '') == 'CHAIR PROFESSOR' ? 'selected' : ''; ?>>CHAIR PROFESSOR</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Date of Birth</b></label>
            <input type="date" name="DOB" class="form-control" placeholder="Enter DOB" style="margin-top: 0;" value="<?php echo $latest_data['DOB'] ?? ''; ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Age</b></label>
            <input type="number" name="Age" class="form-control" placeholder="Enter Age" style="margin-top: 0;" value="<?php echo $latest_data['AGE'] ?? ''; ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Qualification</b></label>
            <input type="text" name="qualification" class="form-control" placeholder="Enter Highest Qualification" style="margin-top: 0;" value="<?php echo $latest_data['QUALIF'] ?? ''; ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Experience</b></label>
            <input type="text" name="experience" class="form-control" placeholder="Enter Experience(in months)" style="margin-top: 0;" value="<?php echo $latest_data['EXPERIENCE'] ?? ''; ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>PAN Number</b></label>
            <input type="text" name="pan_number" class="form-control" placeholder="Enter PAN Number" style="margin-top: 0;" value="<?php echo $latest_data['PAN_NUM'] ?? ''; ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Whether faculty is associated with the institute in previous academic year(2022-2023)? </b></label>
            <select name="Associated" class="form-control" style="margin-top: 0;" required>
                <option value="" disabled <?php echo empty($latest_data['FACULTY_ASSO_IN_PREV_YEAR'])? 'selected': '';?>>Select</option>
                <option value="Yes" <?php echo ($latest_data['FACULTY_ASSO_IN_PREV_YEAR'] ?? '') == 'Yes' ? 'selected' : ''; ?>>Yes</option>
                <option value="No" <?php echo ($latest_data['FACULTY_ASSO_IN_PREV_YEAR'] ?? '') == 'No' ? 'selected' : ''; ?>>No</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Faculty Experience in Teaching (in months)</b></label>
            <input type="text" name="Teaching" class="form-control" placeholder="Enter Teaching Experience" style="margin-top: 0;"  value="<?php echo $latest_data['FACULTY_EXP_TEACHING'] ?? ''; ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Faculty Experience in Industrial (in months)</b></label>
            <input type="text" name="Industrial" class="form-control" placeholder="Enter Industrial Experience" style="margin-top: 0;"  value="<?php echo $latest_data['FACULTY_EXP_INDUSTRIAL'] ?? ''; ?>" required>
        </div>

        <br>
        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Currently working with institution?</b></label>
            <p><span class="small" style="margin-left: -0.8rem;"><b>Date of joining the institute</b></p>
            <input type="date" name="Date_of_joining" class="form-control" placeholder="Date of Joining the institute" style="margin-top: 0;" value="<?php echo $latest_data['JOINING_INSTITUTE_DATE'] ?? ''; ?>" required>
            <p><span class="small" style="margin-left: -0.8rem;"><b>Date of latest joining</b></p>
            <input type="date" name="latest_joining" class="form-control" placeholder="Latest Joining" style="margin-top: 0;" value="<?php echo $latest_data['LATEST_DATE'] ?? ''; ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Association Type</b></label>
            <select name="Association_Type" class="form-control" style="margin-top: 0;" required>
                <option value="" disabled <?php echo empty($latest_data['ASSOC_TYPE'])? 'selected': '';?>>Select</option>
                <option value="REGULAR" <?php echo ($latest_data['ASSOC_TYPE'] ?? '') == 'REGULAR' ? 'selected' : ''; ?>>REGULAR</option>
                <option value="CONTRACTUAL" <?php echo ($latest_data['ASSOC_TYPE'] ?? '') == 'CONTRACTUAL' ? 'selected' : ''; ?>>CONTRACTUAL</option>
                <option value="VISITING" <?php echo ($latest_data['ASSOC_TYPE'] ?? '') == 'VISITING' ? 'selected' : ''; ?>>VISITING</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Email ID of Faculty(Official Email ID)</b></label>
            <input type="email" name="EmailID_of_Faculty" class="form-control" placeholder="Enter Email ID" style="margin-top: 0;" value="<?php echo $latest_data['EMAIL_ID'] ?? ''; ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Mobile Number of Faculty</b></label>
            <input type="number" name="Mobile_Number_of_Faculty" class="form-control" placeholder="Enter Mobile number" style="margin-top: 0;" value="<?php echo $latest_data['MOBILE_NUM'] ?? ''; ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Name of Award</b></label>
            <input type="text" name="Name_of_Award" class="form-control" placeholder="Enter Name of Award" style="margin-top: 0;" value="<?php echo $latest_data['NAME_OF_AWARD'] ?? ''; ?>">
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Level of Award</b></label>
            <select name="Level_of_Award" class="form-control" style="margin-top: 0; " required>
                <option value="" disabled <?php echo empty($latest_data['LEVEL_OF_AWARD'])? 'selected': '';?>>Select</option>
                <option value="NATIONAL" <?php echo ($latest_data['LEVEL_OF_AWARD'] ?? '') == 'NATIONAL' ? 'selected' : ''; ?>>NATIONAL</option>
                <option value="INTERNATIONAL" <?php echo ($latest_data['LEVEL_OF_AWARD'] ?? '') == 'INTERNATIONAL' ? 'selected' : ''; ?>>INTERNATIONAL</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Name of Award Agency</b></label>
            <input type="text" name="Name_of_Award_Agency" class="form-control" placeholder="Enter Name of Award Agency" style="margin-top: 0;" value="<?php echo $latest_data['NAME_OF_AWARD_AGENCY'] ?? ''; ?>">
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Address of Award Agency</b></label>
            <input type="text" name="Address_of_Award_Agency" class="form-control" placeholder="Enter Address of Award Agency" style="margin-top: 0;" value="<?php echo $latest_data['ADD_OF_AWARD_AGENCY'] ?? ''; ?>">
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Year of Received Award</b></label>
            <input type="date" name="Year_of_Received_Award" class="form-control" placeholder="Enter Year of Received Award" style="margin-top: 0;" value="<?php echo $latest_data['YEAR_OF_RECEIVED_AWARD'] ?? ''; ?>">
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Email ID of Agency</b></label>
            <input type="email" name="EmailID_of_Agency" class="form-control" placeholder="Enter Agency Email ID" style="margin-top: 0;" value="<?php echo $latest_data['EMAIL_OF_AGENCY'] ?? ''; ?>">
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Contact of Agency</b></label>
            <input number="text" name="Contact_of_Agency" class="form-control" placeholder="Enter Mobile number" style="margin-top: 0;" value="<?php echo $latest_data['CONTACT_OF_AGENCY'] ?? ''; ?>">
        </div>

        <input type="submit" class="submit btn btn-primary" value="Submit" name="submit" onclick="return Validate()">
    </form>
</div>

<!-- Show Entered Data -->
<div class="row my-5">
    <h3 class="fs-4 mb-3 text-center" id="msg"><b>You Have Entered the Following Data</b></h3>
    <div class="col ">
        <div class="overflow-auto">
            <table class="table bg-white rounded shadow-sm  table-hover ">
                <thead>
                    <tr>
                        <th scope="col">Academic Year</th>
                        <th scope="col">Faculty Name</th>
                        <th scope="col">Gender</th>
                        <th scope="col">Designation</th>
                        <th scope="col">Date of Birth</th>
                        <th scope="col">Age</th>
                        <th scope="col">Qualification</th>
                        <th scope="col">Experience</th>
                        <th scope="col">PAN Number</th>
                        <th scope="col">Associated in previous academic year?</th>
                        <th scope="col">Facuty Experience in Teaching</th>
                        <th scope="col">Facuty Experience in Industrial</th>
                        <th scope="col">Date of joining the institute</th>
                        <th scope="col">Date of latest joining</th>
                        <th scope="col">Association Type</th>
                        <th scope="col">Official Email ID of Faculty</th>
                        <th scope="col">Mobile Number of Faculty</th>
                        <th scope="col">Name of Award</th>
                        <th scope="col">Level of Award</th>
                        <th scope="col">Name of Award Agency</th>
                        <th scope="col">Address of Award Agency</th>
                        <th scope="col">Year of Received Award</th>
                        <th scope="col">Email ID of Agency</th>
                        <th scope="col">Contact of Agency</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $Record = mysqli_query($conn, "SELECT * FROM faculty_details WHERE DEPT_ID = '$dept' AND A_YEAR = '$A_YEAR'");
                    while ($row = mysqli_fetch_array($Record)) {
                    ?>
                        <tr>
                            <td><?php echo $row['A_YEAR'] ?></td>
                            <td><?php echo $row['FACULTY_NAME'] ?></td>
                            <td><?php echo $row['GENDER'] ?></td>
                            <td><?php echo $row['DESIGNATION'] ?></td>
                            <td><?php echo $row['DOB'] ?></td>
                            <td><?php echo $row['AGE'] ?></td>
                            <td><?php echo $row['QUALIF'] ?></td>
                            <td><?php echo $row['EXPERIENCE'] ?></td>
                            <td><?php echo $row['PAN_NUM'] ?></td>
                            <td><?php echo $row['FACULTY_ASSO_IN_PREV_YEAR'] ?></td>
                            <td><?php echo $row['FACULTY_EXP_TEACHING'] ?></td>
                            <td><?php echo $row['FACULTY_EXP_INDUSTRIAL'] ?></td>
                            <td><?php echo $row['JOINING_INSTITUTE_DATE'] ?></td>
                            <td><?php echo $row['LATEST_DATE'] ?></td>
                            <td><?php echo $row['ASSOC_TYPE'] ?></td>
                            <td><?php echo $row['EMAIL_ID'] ?></td>
                            <td><?php echo $row['MOBILE_NUM'] ?></td>
                            <td><?php echo $row['NAME_OF_AWARD'] ?></td>
                            <td><?php echo $row['LEVEL_OF_AWARD'] ?></td>
                            <td><?php echo $row['NAME_OF_AWARD_AGENCY'] ?></td>
                            <td><?php echo $row['ADD_OF_AWARD_AGENCY'] ?></td>
                            <td><?php echo $row['YEAR_OF_RECEIVED_AWARD'] ?></td>
                            <td><?php echo $row['EMAIL_OF_AGENCY'] ?></td>
                            <td><?php echo $row['CONTACT_OF_AGENCY'] ?></td>
                            <td><a class="dbutton" href="EditFacultyDetails.php?action=edit&ID=<?php echo $row['ID'] ?>">Edit</a></td>
                            <td><a class="dbutton" href="FacultyDetails.php?action=delete&ID=<?php echo $row['ID'] ?>">Delete</a></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
require "footer.php";
?>

