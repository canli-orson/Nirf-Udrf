<?php
include 'config.php';
require "header.php";

$dept = $_SESSION['dept_id'];
// error_reporting(E_ALL);
error_reporting(0);


if (isset($_GET['ID'])) {
    $record_id = filter_var($_GET['ID'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM placement_details WHERE ID = '$record_id' AND DEPT_ID = '$dept'";
    $result = mysqli_query($conn, $query);
    $record = mysqli_fetch_assoc($result);

    if (!$record) {
        echo "<script>alert('Record not found');</script>";
        echo '<script>window.location.href = "PlacementDetails.php";</script>';
        exit;
    }
}

if (isset($_POST['submit'])) {
    $p_name = $_POST['p_name'];
    $query = "SELECT `PROGRAM_CODE` FROM `program_master` WHERE `PROGRAM_NAME` = '$p_name'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);

        if ($row) {
            $p_code = $row['PROGRAM_CODE'];

            // Gather updated input data
            $total_students = trim(strip_tags(filter_input(INPUT_POST, 'total_students', FILTER_SANITIZE_NUMBER_INT)));
            $students_lateral_entry = trim(strip_tags(filter_input(INPUT_POST, 'students_lateral_entry', FILTER_SANITIZE_NUMBER_INT)));
            $students_graduated = trim(strip_tags(filter_input(INPUT_POST, 'students_graduated', FILTER_SANITIZE_NUMBER_INT)));
            $students_placed = trim(strip_tags(filter_input(INPUT_POST, 'students_placed', FILTER_SANITIZE_NUMBER_INT)));
            $students_higher_studies = trim(strip_tags(filter_input(INPUT_POST, 'students_higher_studies', FILTER_SANITIZE_NUMBER_INT)));

            $update_query = "UPDATE placement_details SET 
                PROGRAM_NAME = '$p_name',
                PROGRAM_CODE = '$p_code',
                TOTAL_NO_OF_STUDENT = '$total_students',
                NUM_OF_STUDENTS_ADMITTED_LATERAL_ENTRY = '$students_lateral_entry',
                TOTAL_NUM_OF_STUDENTS_GRADUATED = '$students_graduated',
                TOTAL_NUM_OF_STUDENTS_PLACED = '$students_placed',
                NUM_OF_STUDENTS_IN_HIGHER_STUDIES = '$students_higher_studies'
                WHERE ID = '$record_id' AND DEPT_ID = '$dept'";

            if (mysqli_query($conn, $update_query)) {
                echo "<script>alert('Data Updated.')</script>";
                echo '<script>window.location.href = "PlacementDetails.php";</script>';
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
    <form class="fw-bold" method="POST" enctype="multipart/form-data" autocomplete="off">
        <div class="mb-3">
            <p class="text-center fs-4"><b>Edit Placement Details</b></p>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">Department ID</label>
            <input type="text" name="dept_id" value="<?php echo $dept; ?>" class="form-control" style="margin-top: 0;" disabled>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">Program Name</label>
            <select name="p_name" class="form-control" style="margin-top: 0;" required>
                <?php
                $sql = "SELECT * FROM program_master";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    if ($row['PROGRAM_NAME'] == $record['PROGRAM_NAME']) {
                        echo '<option selected value="' . htmlspecialchars($row['PROGRAM_NAME']) . '">' . htmlspecialchars($row['PROGRAM_NAME']) . '</option>';
                    } else {
                        echo '<option value="' . htmlspecialchars($row['PROGRAM_NAME']) . '">' . htmlspecialchars($row['PROGRAM_NAME']) . '</option>';
                    }
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">Total No. of Students</label>
            <input type="number" name="total_students" value="<?php echo htmlspecialchars($record['TOTAL_NO_OF_STUDENT']); ?>" class="form-control" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">No. of Students Admitted through Lateral Entry</label>
            <input type="number" name="students_lateral_entry" value="<?php echo htmlspecialchars($record['NUM_OF_STUDENTS_ADMITTED_LATERAL_ENTRY']); ?>" class="form-control" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">No. of Students Graduated</label>
            <input type="number" name="students_graduated" value="<?php echo htmlspecialchars($record['TOTAL_NUM_OF_STUDENTS_GRADUATED']); ?>" class="form-control" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">No. of Students Placed</label>
            <input type="number" name="students_placed" value="<?php echo htmlspecialchars($record['TOTAL_NUM_OF_STUDENTS_PLACED']); ?>" class="form-control" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">No. of Students in Higher Studies</label>
            <input type="number" name="students_higher_studies" value="<?php echo htmlspecialchars($record['NUM_OF_STUDENTS_IN_HIGHER_STUDIES']); ?>" class="form-control" style="margin-top: 0;" required>
        </div>

        <div class="text-center">
            <input type="submit" class="submit btn btn-primary" value="Update" name="submit">
        </div>
    </form>
</div>

<?php
require "footer.php";
?>