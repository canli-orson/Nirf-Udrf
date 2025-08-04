<?php
include 'config.php';
require "header.php";
// error_reporting(E_ALL);
error_reporting(0);


$dept = $_SESSION['dept_id'];

if (isset($_GET['ID'])) {
    $id = filter_var($_GET['ID'], FILTER_SANITIZE_NUMBER_INT);
    // Fetch existing data for the given ID
    $result = mysqli_query($conn, "SELECT * FROM patent_details WHERE ID = '$id'");
    $row = mysqli_fetch_assoc($result);

    if (!$row) {
        echo "<script>alert('Invalid Record ID'); window.location.href = 'PatentDetailsIndividual.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('No Record Selected'); window.location.href = 'PatentDetailsIndividual.php';</script>";
    exit;
}

// Update logic
if (isset($_POST['update'])) {
    $patent_application_number = trim(strip_tags(filter_input(INPUT_POST, 'patent_application_number', FILTER_SANITIZE_NUMBER_INT)));
    $status_of_patent = trim(strip_tags(filter_input(INPUT_POST, 'status_of_patent', FILTER_SANITIZE_STRING)));
    $Inventors_name = trim(strip_tags(filter_input(INPUT_POST, 'Inventors_name', FILTER_SANITIZE_STRING)));
    $Title_of_the_patent = trim(strip_tags(filter_input(INPUT_POST, 'Title_of_the_patent', FILTER_SANITIZE_STRING)));
    $Applicant_Name = trim(strip_tags(filter_input(INPUT_POST, 'Applicant_Name', FILTER_SANITIZE_STRING)));
    $Patent_Filed = trim(strip_tags(filter_input(INPUT_POST, 'Patent_Filed', FILTER_SANITIZE_STRING)));
    $Patent_published_date = trim(strip_tags(filter_input(INPUT_POST, 'Patent_published_date', FILTER_SANITIZE_STRING)));
    $Patent_granted_date = trim(strip_tags(filter_input(INPUT_POST, 'Patent_granted_date', FILTER_SANITIZE_STRING)));
    $Patent_publication_number = trim(strip_tags(filter_input(INPUT_POST, 'Patent_publication_number', FILTER_SANITIZE_NUMBER_INT)));
    $Assignee_Name = trim(strip_tags(filter_input(INPUT_POST, 'Assignee_Name', FILTER_SANITIZE_STRING)));
    $URL = trim(strip_tags(filter_input(INPUT_POST, 'URL', FILTER_SANITIZE_URL)));

    $update_query = "UPDATE `patent_details` 
                     SET 
                         PATENT_APPLICATION_NO = '$patent_application_number',
                         STATUS_OF_PATENT = '$status_of_patent',
                         INVENTOR_NAME = '$Inventors_name',
                         TITLE_OF_PATENT = '$Title_of_the_patent',
                         APPLICANT_NAME = '$Applicant_Name',
                         PATENT_FILED_DATE = '$Patent_Filed',
                         PATENT_PUBLISHED_DATE = '$Patent_published_date',
                         PATENT_GRANTED_DATE = '$Patent_granted_date',
                         PATENT_PUBLICATION_NUMBER = '$Patent_publication_number',
                         ASIGNEES_NAME = '$Assignee_Name',
                         URL = '$URL'
                     WHERE ID = '$id'";

    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('Record Updated Successfully'); window.location.href = 'PatentDetailsIndividual.php';</script>";
    } else {
        echo "<script>alert('Update Failed: Contact Admin');</script>";
    }
}
?>

<div class="div">
    <form class="fw-bold" method="POST" autocomplete="off">
        <div class="mb-3">
            <p class="text-center fs-4"><b>Edit Patent Details</b></p>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Academic Year</b></label>
            <input type="text" name="year" value="<?php echo $A_YEAR; ?>" class="form-control" style="margin-top: 0;" disabled>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;"><b>Department ID</b></label>
            <input type="text" name="dpt_id" value="<?php echo $dept; ?>" class="form-control" style="margin-top: 0;" disabled>
        </div>

        <div class="mb-3">
            <label class="form-label"><b>Patent Application Number</b></label>
            <input type="number" name="patent_application_number" class="form-control" value="<?php echo $row['PATENT_APPLICATION_NO']; ?>" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label"><b>Status of Patent</b></label>
            <select name="status_of_patent" class="form-control" style="margin-top: 0;">
                <option value="" disabled selected>Select</option>
                <option value="FILED" <?php if ($row['STATUS_OF_PATENT'] == 'FILED') echo 'selected'; ?>>FILED</option>
                <option value="GRANTED" <?php if ($row['STATUS_OF_PATENT'] == 'GRANTED') echo 'selected'; ?>>GRANTED</option>
                <option value="PUBLISHED" <?php if ($row['STATUS_OF_PATENT'] == 'PUBLISHED') echo 'selected'; ?>>PUBLISHED</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label"><b>Inventor's Name</b></label>
            <input type="text" name="Inventors_name" class="form-control" value="<?php echo $row['INVENTOR_NAME']; ?> " style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label"><b>Title of the Patent</b></label>
            <input type="text" name="Title_of_the_patent" class="form-control" value="<?php echo $row['TITLE_OF_PATENT']; ?>"style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label"><b>Applicant Name</b></label>
            <input type="text" name="Applicant_Name" class="form-control" value="<?php echo $row['APPLICANT_NAME']; ?>" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label"><b>Patent Filed Date</b></label>
            <input type="date" name="Patent_Filed" class="form-control" value="<?php echo $row['PATENT_FILED_DATE']; ?>" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label"><b>Patent Published Date</b></label>
            <input type="date" name="Patent_published_date" class="form-control" value="<?php echo $row['PATENT_PUBLISHED_DATE']; ?>"style="margin-top: 0;" >
        </div>

        <div class="mb-3">
            <label class="form-label"><b>Patent Granted Date</b></label>
            <input type="date" name="Patent_granted_date" class="form-control" value="<?php echo $row['PATENT_GRANTED_DATE']; ?>"style="margin-top: 0;" >
        </div>

        <div class="mb-3">
            <label class="form-label"><b>Patent Publication Number</b></label>
            <input type="number" name="Patent_publication_number" class="form-control" value="<?php echo $row['PATENT_PUBLICATION_NUMBER']; ?>" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label"><b>Assignee's Name</b></label>
            <input type="text" name="Assignee_Name" class="form-control" value="<?php echo $row['ASIGNEES_NAME']; ?>" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label"><b>URL</b></label>
            <input type="text" name="URL" class="form-control" value="<?php echo $row['URL']; ?>" style="margin-top: 0;" required>
        </div>

        <input type="submit" class="submit btn btn-primary" value="Update" name="update">
    </form>
</div>

<?php
require "footer.php";
?>