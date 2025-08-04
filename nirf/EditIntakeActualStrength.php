<?php
include 'config.php';
require "header.php";

$dept = $_SESSION['dept_id'];
// error_reporting(E_ALL);
error_reporting(0);


if (isset($_GET['ID'])) {
    $id = filter_var($_GET['ID'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM intake_actual_strength WHERE ID = '$id' AND DEPT_ID = '$dept'";
    $result = mysqli_query($conn, $query);
    $intake_detail = mysqli_fetch_assoc($result);

    if (!$intake_detail) {
        echo "<script>alert('Record not found');</script>";
        echo '<script>window.location.href = "IntakeActualStrength.php";</script>';
        exit;
    }
}

if (isset($_POST['submit'])) {
    $p_name = filter_input(INPUT_POST, 'p_name', FILTER_SANITIZE_STRING);
    $query = "SELECT `PROGRAM_CODE` FROM `program_master` WHERE `PROGRAM_NAME` = '$p_name'";
    $result = mysqli_query($conn, $query);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        $p_code = $row['PROGRAM_CODE'];

        // Input sanitization
        $student_intake = filter_input(INPUT_POST, 'student_intake', FILTER_SANITIZE_NUMBER_INT);
        $male_students = filter_input(INPUT_POST, 'male_students', FILTER_SANITIZE_NUMBER_INT);
        $female_students = filter_input(INPUT_POST, 'female_students', FILTER_SANITIZE_NUMBER_INT);
        $male_within_state = filter_input(INPUT_POST, 'male_within_state', FILTER_SANITIZE_NUMBER_INT);
        $female_within_state = filter_input(INPUT_POST, 'female_within_state', FILTER_SANITIZE_NUMBER_INT);
        $male_outside_state = filter_input(INPUT_POST, 'male_outside_state', FILTER_SANITIZE_NUMBER_INT);
        $female_outside_state = filter_input(INPUT_POST, 'female_outside_state', FILTER_SANITIZE_NUMBER_INT);
        $male_outside_country = filter_input(INPUT_POST, 'male_outside_country', FILTER_SANITIZE_NUMBER_INT);
        $female_outside_country = filter_input(INPUT_POST, 'female_outside_country', FILTER_SANITIZE_NUMBER_INT);
        $male_economic_backward = filter_input(INPUT_POST, 'male_economic_backward', FILTER_SANITIZE_NUMBER_INT);
        $female_economic_backward = filter_input(INPUT_POST, 'female_economic_backward', FILTER_SANITIZE_NUMBER_INT);
        $male_social_backward = filter_input(INPUT_POST, 'male_social_backward', FILTER_SANITIZE_NUMBER_INT);
        $female_social_backward = filter_input(INPUT_POST, 'female_social_backward', FILTER_SANITIZE_NUMBER_INT);
        $male_scholarship_government = filter_input(INPUT_POST, 'male_scholarship_government', FILTER_SANITIZE_NUMBER_INT);
        $female_scholarship_government = filter_input(INPUT_POST, 'female_scholarship_government', FILTER_SANITIZE_NUMBER_INT);
        $male_scholarship_institution = filter_input(INPUT_POST, 'male_scholarship_institution', FILTER_SANITIZE_NUMBER_INT);
        $female_scholarship_institution = filter_input(INPUT_POST, 'female_scholarship_institution', FILTER_SANITIZE_NUMBER_INT);
        $male_scholarship_private = filter_input(INPUT_POST, 'male_scholarship_private', FILTER_SANITIZE_NUMBER_INT);
        $female_scholarship_private = filter_input(INPUT_POST, 'female_scholarship_private', FILTER_SANITIZE_NUMBER_INT);

        $update_query = "UPDATE `intake_actual_strength` SET 
            `A_YEAR` = '{$intake_detail['A_YEAR']}', 
            `DEPT_ID` = '$dept', 
            `PROGRAM_CODE` = '$p_code', 
            `PROGRAM_NAME` = '$p_name', 
            `NO_STUDENT_INTAKE` = '$student_intake', 
            `NO_MALE_STUDENT` = '$male_students', 
            `NO_FEMALE_STUDENT` = '$female_students', 
            `NO_STUDENT_WITHIN_STATE_MALE` = '$male_within_state', 
            `NO_STUDENT_WITHIN_STATE_FEMALE` = '$female_within_state', 
            `NO_STUDENT_OUTSIDE_STATE_MALE` = '$male_outside_state', 
            `NO_STUDENT_OUTSIDE_STATE_FEMALE` = '$female_outside_state', 
            `NO_STUDENT_OUTSIDE_COUNTRY_MALE` = '$male_outside_country', 
            `NO_STUDENT_OUTSIDE_COUNTRY_FEMALE` = '$female_outside_country', 
            `NO_STUDENT_ECONOMIC_BACKWARD_MALE` = '$male_economic_backward', 
            `NO_STUDENT_ECONOMIC_BACKWARD_FEMALE` = '$female_economic_backward', 
            `NO_STUDENT_SOCIAL_BACKWARD_SC_ST_OBC_MALE` = '$male_social_backward', 
            `NO_STUDENT_SOCIAL_BACKWARD_SC_ST_OBC_FEMALE` = '$female_social_backward', 
            `NO_STUDENT_RECEIVING_SCHOLARSHIP_GOVERN_MALE` = '$male_scholarship_government', 
            `NO_STUDENT_RECEIVING_SCHOLARSHIP_GOVERN_FEMALE` = '$female_scholarship_government', 
            `NO_STUDENT_RECEIVING_SCHOLARSHIP_INSTIT_MALE` = '$male_scholarship_institution', 
            `NO_STUDENT_RECEIVING_SCHOLARSHIP_INSTIT_FEMALE` = '$female_scholarship_institution', 
            `NO_STUDENT_RECEIVING_SCHOLARSHIP_PRIVATE_BODY_MALE` = '$male_scholarship_private', 
            `NO_STUDENT_RECEIVING_SCHOLARSHIP_PRIVATE_BODY_FEMALE` = '$female_scholarship_private' 
            WHERE ID = '$id' AND DEPT_ID = '$dept'";

        if (mysqli_query($conn, $update_query)) {
            echo "<script>alert('Data Updated Successfully.');</script>";
            echo '<script>window.location.href = "IntakeActualStrength.php";</script>';
        } else {
            echo "<script>alert('Error updating data: " . mysqli_error($conn) . "');</script>";
        }
    } else {
        echo "<script>alert('No matching program found for: $p_name');</script>";
    }
}
?>

<div class="div">
    <form class="fw-bold" method="POST" enctype="multipart/form-data" autocomplete="off">
        <div class="mb-3">
            <p class="text-center fs-4"><b>Edit Intake & Actual Strength</b></p>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">Academic Year</label>
            <input type="text" name="year" value="<?php echo htmlspecialchars($intake_detail['A_YEAR']); ?>" class="form-control" style="margin-top: 0;" disabled>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">Department ID</label>
            <input type="text" name="dept_id" value="<?php echo htmlspecialchars($dept); ?>" class="form-control" style="margin-top: 0;" disabled>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">Program Name</label>
            <select name="p_name" class="form-control" style="margin-top: 0;" required>
                <?php
                $sql = "SELECT * FROM `program_master`";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    $selected = ($row['PROGRAM_NAME'] == $intake_detail['PROGRAM_NAME']) ? 'selected' : '';
                    echo '<option value="' . htmlspecialchars($row['PROGRAM_NAME']) . '" ' . $selected . '>' . htmlspecialchars($row['PROGRAM_NAME']) . '</option>';
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">Total Number of Students Intake</label>
            <input type="number" name="student_intake" value="<?php echo htmlspecialchars($intake_detail['NO_STUDENT_INTAKE']); ?>" class="form-control" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">Total Male Students</label>
            <input type="number" name="male_students" value="<?php echo htmlspecialchars($intake_detail['NO_MALE_STUDENT']); ?>" class="form-control" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">Total Female Students</label>
            <input type="number" name="female_students" value="<?php echo htmlspecialchars($intake_detail['NO_FEMALE_STUDENT']); ?>" class="form-control" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">Male Students Within State</label>
            <input type="number" name="male_within_state" value="<?php echo htmlspecialchars($intake_detail['NO_STUDENT_WITHIN_STATE_MALE']); ?>" class="form-control" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">Female Students Within State</label>
            <input type="number" name="female_within_state" value="<?php echo htmlspecialchars($intake_detail['NO_STUDENT_WITHIN_STATE_FEMALE']); ?>" class="form-control" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">Male Students Outside State</label>
            <input type="number" name="male_outside_state" value="<?php echo htmlspecialchars($intake_detail['NO_STUDENT_OUTSIDE_STATE_MALE']); ?>" class="form-control" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">Female Students Outside State</label>
            <input type="number" name="female_outside_state" value="<?php echo htmlspecialchars($intake_detail['NO_STUDENT_OUTSIDE_STATE_FEMALE']); ?>" class="form-control" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">Male Students Outside Country</label>
            <input type="number" name="male_outside_country" value="<?php echo htmlspecialchars($intake_detail['NO_STUDENT_OUTSIDE_COUNTRY_MALE']); ?>" class="form-control" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">Female Students Outside Country</label>
            <input type="number" name="female_outside_country" value="<?php echo htmlspecialchars($intake_detail['NO_STUDENT_OUTSIDE_COUNTRY_FEMALE']); ?>" class="form-control" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">Male Students Economically Backward</label>
            <input type="number" name="male_economic_backward" value="<?php echo htmlspecialchars($intake_detail['NO_STUDENT_ECONOMIC_BACKWARD_MALE']); ?>" class="form-control" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">Female Students Economically Backward</label>
            <input type="number" name="female_economic_backward" value="<?php echo htmlspecialchars($intake_detail['NO_STUDENT_ECONOMIC_BACKWARD_FEMALE']); ?>" class="form-control" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">Male Students Socially Backward (SC/ST/OBC)</label>
            <input type="number" name="male_social_backward" value="<?php echo htmlspecialchars($intake_detail['NO_STUDENT_SOCIAL_BACKWARD_SC_ST_OBC_MALE']); ?>" class="form-control" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">Female Students Socially Backward (SC/ST/OBC)</label>
            <input type="number" name="female_social_backward" value="<?php echo htmlspecialchars($intake_detail['NO_STUDENT_SOCIAL_BACKWARD_SC_ST_OBC_FEMALE']); ?>" class="form-control" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">Male Students Receiving Government Scholarship</label>
            <input type="number" name="male_scholarship_government" value="<?php echo htmlspecialchars($intake_detail['NO_STUDENT_RECEIVING_SCHOLARSHIP_GOVERN_MALE']); ?>" class="form-control" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">Female Students Receiving Government Scholarship</label>
            <input type="number" name="female_scholarship_government" value="<?php echo htmlspecialchars($intake_detail['NO_STUDENT_RECEIVING_SCHOLARSHIP_GOVERN_FEMALE']); ?>" class="form-control" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">Male Students Receiving Institution Scholarship</label>
            <input type="number" name="male_scholarship_institution" value="<?php echo htmlspecialchars($intake_detail['NO_STUDENT_RECEIVING_SCHOLARSHIP_INSTIT_MALE']); ?>" class="form-control" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">Female Students Receiving Institution Scholarship</label>
            <input type="number" name="female_scholarship_institution" value="<?php echo htmlspecialchars($intake_detail['NO_STUDENT_RECEIVING_SCHOLARSHIP_INSTIT_FEMALE']); ?>" class="form-control" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">Male Students Receiving Private Bodies Scholarship</label>
            <input type="number" name="male_scholarship_private" value="<?php echo htmlspecialchars($intake_detail['NO_STUDENT_RECEIVING_SCHOLARSHIP_PRIVATE_BODY_MALE']); ?>" class="form-control" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">Female Students Receiving Private Bodies Scholarship</label>
            <input type="number" name="female_scholarship_private" value="<?php echo htmlspecialchars($intake_detail['NO_STUDENT_RECEIVING_SCHOLARSHIP_PRIVATE_BODY_FEMALE']); ?>" class="form-control" style="margin-top: 0;" required>
        </div>

        <div class="text-center">
            <input type="submit" class="submit btn btn-primary" value="Update" name="submit">
        </div>
    </form>
</div>

<?php
require "footer.php";
?>