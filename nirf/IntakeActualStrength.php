<?php
include 'config.php';
require "header.php";
// error_reporting(E_ALL);
error_reporting(0);


$dept = $_SESSION['dept_id'];



if (isset($_POST['submit'])) {
    $p_name = $_POST['p_name'];
    $query = "SELECT `PROGRAM_CODE` FROM `program_master` WHERE `PROGRAM_NAME` = '$p_name'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);

        if ($row) {
            $p_code = $row['PROGRAM_CODE'];
            $Student_Intake = trim(strip_tags(filter_input(INPUT_POST, 'Add_Total_Student_Intake', FILTER_SANITIZE_NUMBER_INT)));
            $Male_Students = trim(strip_tags(filter_input(INPUT_POST, 'Total_number_of_Male_Students', FILTER_SANITIZE_NUMBER_INT)));;
            $Female_Students = trim(strip_tags(filter_input(INPUT_POST, 'Total_number_of_Female_Students', FILTER_SANITIZE_NUMBER_INT)));;
            $Male_Students_within_state = trim(strip_tags(filter_input(INPUT_POST, 'Total_number_of_Male_Students_within_state', FILTER_SANITIZE_NUMBER_INT)));;
            $Female_Students_within_state = trim(strip_tags(filter_input(INPUT_POST, 'Total_number_of_Female_Students_within_state', FILTER_SANITIZE_NUMBER_INT)));;
            $Male_Students_outside_state = trim(strip_tags(filter_input(INPUT_POST, 'Male_Students_outside_state', FILTER_SANITIZE_NUMBER_INT)));;
            $Female_Students_outside_state = trim(strip_tags(filter_input(INPUT_POST, 'Female_Students_outside_state', FILTER_SANITIZE_NUMBER_INT)));;
            $Male_Students_outside_country = trim(strip_tags(filter_input(INPUT_POST, 'Male_Students_outside_country', FILTER_SANITIZE_NUMBER_INT)));;
            $Female_Students_outside_country = trim(strip_tags(filter_input(INPUT_POST, 'Female_Students_outside_country', FILTER_SANITIZE_NUMBER_INT)));;
            $Male_Students_Economic_Backward = trim(strip_tags(filter_input(INPUT_POST, 'Male_Students_Economic_Backward', FILTER_SANITIZE_NUMBER_INT)));;
            $Female_Students_Economic_Backward = trim(strip_tags(filter_input(INPUT_POST, 'Female_Students_Economic_Backward', FILTER_SANITIZE_NUMBER_INT)));;
            $Male_Students_Social_Backward = trim(strip_tags(filter_input(INPUT_POST, 'Male_Students_Social_Backward', FILTER_SANITIZE_NUMBER_INT)));;
            $Female_Student_Social_Backward = trim(strip_tags(filter_input(INPUT_POST, 'Female_Student_Social_Backward', FILTER_SANITIZE_NUMBER_INT)));;
            $Male_Students_Receiving_scholarship_from_Government = trim(strip_tags(filter_input(INPUT_POST, 'Male_Students_Receiving_scholarship_from_Government', FILTER_SANITIZE_NUMBER_INT)));;
            $Female_Students_Receiving_scholarship_from_Government = trim(strip_tags(filter_input(INPUT_POST, 'Female_Students_Receiving_scholarship_from_Government', FILTER_SANITIZE_NUMBER_INT)));;
            $Male_Students_Receiving_scholarship_from_Institution = trim(strip_tags(filter_input(INPUT_POST, 'Male_Students_Receiving_scholarship_from_Institution', FILTER_SANITIZE_NUMBER_INT)));;
            $Female_Students_Receiving_scholarship_from_Institution = trim(strip_tags(filter_input(INPUT_POST, 'Female_Students_Receiving_scholarship_from_Institution', FILTER_SANITIZE_NUMBER_INT)));;
            $Male_Students_Receiving_scholarship_from_private_Bodies = trim(strip_tags(filter_input(INPUT_POST, 'Male_Students_Receiving_scholarship_from_private_Bodies', FILTER_SANITIZE_NUMBER_INT)));;
            $Female_Students_Receiving_scholarship_from_private_Bodies = trim(strip_tags(filter_input(INPUT_POST, 'Female_Students_Receiving_scholarship_from_private_Bodies', FILTER_SANITIZE_NUMBER_INT)));;


            $insert_query = "INSERT INTO `intake_actual_strength`(`A_YEAR`, `DEPT_ID`, `PROGRAM_CODE`, `PROGRAM_NAME`, `NO_STUDENT_INTAKE`, `NO_MALE_STUDENT`, `NO_FEMALE_STUDENT`, `NO_STUDENT_WITHIN_STATE_MALE`, `NO_STUDENT_WITHIN_STATE_FEMALE`, `NO_STUDENT_OUTSIDE_STATE_MALE`, `NO_STUDENT_OUTSIDE_STATE_FEMALE`, `NO_STUDENT_OUTSIDE_COUNTRY_MALE`, `NO_STUDENT_OUTSIDE_COUNTRY_FEMALE`, `NO_STUDENT_ECONOMIC_BACKWARD_MALE`, `NO_STUDENT_ECONOMIC_BACKWARD_FEMALE`, `NO_STUDENT_SOCIAL_BACKWARD_SC_ST_OBC_MALE`, `NO_STUDENT_SOCIAL_BACKWARD_SC_ST_OBC_FEMALE`, `NO_STUDENT_RECEIVING_SCHOLARSHIP_GOVERN_MALE`, `NO_STUDENT_RECEIVING_SCHOLARSHIP_GOVERN_FEMALE`, `NO_STUDENT_RECEIVING_SCHOLARSHIP_INSTIT_MALE`, `NO_STUDENT_RECEIVING_SCHOLARSHIP_INSTIT_FEMALE`, `NO_STUDENT_RECEIVING_SCHOLARSHIP_PRIVATE_BODY_MALE`, `NO_STUDENT_RECEIVING_SCHOLARSHIP_PRIVATE_BODY_FEMALE`)
            VALUES ('$A_YEAR', '$dept', '$p_code', '$p_name', '$Student_Intake','$Male_Students','$Female_Students','$Male_Students_within_state','$Female_Students_within_state', '$Male_Students_outside_state', '$Female_Students_outside_state', '$Male_Students_outside_country', '$Female_Students_outside_country', '$Male_Students_Economic_Backward', '$Female_Students_Economic_Backward', '$Male_Students_Social_Backward', '$Female_Student_Social_Backward', '$Male_Students_Receiving_scholarship_from_Government', '$Female_Students_Receiving_scholarship_from_Government', '$Male_Students_Receiving_scholarship_from_Institution', '$Female_Students_Receiving_scholarship_from_Institution', '$Male_Students_Receiving_scholarship_from_private_Bodies', '$Female_Students_Receiving_scholarship_from_private_Bodies')
            ON DUPLICATE KEY UPDATE 
            A_YEAR = VALUES(A_YEAR), 
            DEPT_ID = VALUES(DEPT_ID), 
            PROGRAM_CODE = VALUES(PROGRAM_CODE),
            NO_STUDENT_INTAKE = VALUES(NO_STUDENT_INTAKE), 
            NO_MALE_STUDENT = VALUES(NO_MALE_STUDENT), 
            NO_FEMALE_STUDENT = VALUES(NO_FEMALE_STUDENT),
            NO_STUDENT_WITHIN_STATE_MALE = VALUES(NO_STUDENT_WITHIN_STATE_MALE),
            NO_STUDENT_WITHIN_STATE_FEMALE = VALUES(NO_STUDENT_WITHIN_STATE_FEMALE),
            NO_STUDENT_OUTSIDE_STATE_MALE = VALUES(NO_STUDENT_OUTSIDE_STATE_MALE),
            NO_STUDENT_OUTSIDE_STATE_FEMALE = VALUES(NO_STUDENT_OUTSIDE_STATE_FEMALE),
            NO_STUDENT_OUTSIDE_COUNTRY_MALE = VALUES(NO_STUDENT_OUTSIDE_COUNTRY_MALE),
            NO_STUDENT_OUTSIDE_COUNTRY_FEMALE = VALUES(NO_STUDENT_OUTSIDE_COUNTRY_FEMALE),
            NO_STUDENT_ECONOMIC_BACKWARD_MALE = VALUES(NO_STUDENT_ECONOMIC_BACKWARD_MALE),
            NO_STUDENT_ECONOMIC_BACKWARD_FEMALE = VALUES(NO_STUDENT_ECONOMIC_BACKWARD_FEMALE),
            NO_STUDENT_SOCIAL_BACKWARD_SC_ST_OBC_MALE = VALUES(NO_STUDENT_SOCIAL_BACKWARD_SC_ST_OBC_MALE),
            NO_STUDENT_SOCIAL_BACKWARD_SC_ST_OBC_FEMALE = VALUES(NO_STUDENT_SOCIAL_BACKWARD_SC_ST_OBC_FEMALE),
            NO_STUDENT_RECEIVING_SCHOLARSHIP_GOVERN_MALE = VALUES(NO_STUDENT_RECEIVING_SCHOLARSHIP_GOVERN_MALE),
            NO_STUDENT_RECEIVING_SCHOLARSHIP_GOVERN_FEMALE = VALUES(NO_STUDENT_RECEIVING_SCHOLARSHIP_GOVERN_FEMALE),
            NO_STUDENT_RECEIVING_SCHOLARSHIP_INSTIT_MALE = VALUES(NO_STUDENT_RECEIVING_SCHOLARSHIP_INSTIT_MALE),
            NO_STUDENT_RECEIVING_SCHOLARSHIP_INSTIT_FEMALE = VALUES(NO_STUDENT_RECEIVING_SCHOLARSHIP_INSTIT_FEMALE),
            NO_STUDENT_RECEIVING_SCHOLARSHIP_PRIVATE_BODY_MALE = VALUES(NO_STUDENT_RECEIVING_SCHOLARSHIP_PRIVATE_BODY_MALE),
            NO_STUDENT_RECEIVING_SCHOLARSHIP_PRIVATE_BODY_FEMALE = VALUES(NO_STUDENT_RECEIVING_SCHOLARSHIP_PRIVATE_BODY_FEMALE)";

            if (mysqli_query($conn, $insert_query)) {
                echo "<script>alert('Data Entered.')</script>";
                echo '<script>window.location.href = "IntakeActualStrength.php";</script>';
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


if (isset($_GET['action'])) {
    $action = $_GET['action'];
    if ($action == 'delete') {
        $id = filter_var($_GET['ID'], FILTER_SANITIZE_NUMBER_INT);
        $sql = mysqli_query($conn, "DELETE from intake_actual_strength where ID = '$id'");
        echo '<script>window.location.href = "IntakeActualStrength.php";</script>';
    }
}
?>
<div class="div">
    <form class="fw-bold" method="POST" enctype="multipart/form-data" autocomplete="off">
        <div class="mb-3">
            <p class="text-center fs-4 "><b>Intake & Actual Strength</b></p>
        </div>
        <!-- The Instructions -->
        <div class="alert alert-danger align-content-between justify-content-center" role="alert">
            <h5><b>Important Notes:</b></h5>
            <ul type="dot">
                <li style="font-weight:200;"><b>Sanctioned Approved intake of 1st year to be entered</b></li>
                <li style="font-weight:200;"><b>Enter value(s) in all field(s); if not applicable enter zero[0]</b></li>
                <li style="font-weight:200;"><b>Students counted under socially challenged shall not be counted in economically backward and vice versa</b></li>
                <li style="font-weight:200;"><b>Students whose parental income is less than taxable slab shall be considered under economically backward</b></li>
            </ul>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">Academic Year</label>
            <input type="text" name="year" value="<?php echo $A_YEAR ?>" class="form-control" style="margin-top: 0;" disabled>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">Department ID</label>
            <input type="text" name="dpt_id" value="<?php echo $dept ?>" class="form-control" style="margin-top: 0;" disabled>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">Program Name</label>
            <select name="p_name" class="form-control" style="margin-top: 0;">
                <?php
                $sql = "SELECT * FROM `program_master`";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    if ($row['PROGRAM_NAME'] == $p_name) {
                        echo '<option selected value="' . $row['PROGRAM_NAME'] . '">' . $row['PROGRAM_NAME'] . '</option>';
                    } else {
                        echo '<option value="' . $row['PROGRAM_NAME'] . '">' . $row['PROGRAM_NAME'] . '</option>';
                    }
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">Total Number of Students Intake</label>
            <input type="number" name="Add_Total_Student_Intake" placeholder="Enter Total Student Intake" class="form-control" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">Total MALE Students </label>
            <input type="number" name="Total_number_of_Male_Students" placeholder="Enter Count" class="form-control" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">Total FEMALE Students </label>
            <input type="number" name="Total_number_of_Female_Students" placeholder="Enter Count" class="form-control" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">Total MALE Students within state</label>
            <input type="number" name="Total_number_of_Male_Students_within_state" placeholder="Enter Count" class="form-control" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">Total FEMALE Students within state</label>
            <input type="number" name="Total_number_of_Female_Students_within_state" placeholder="Enter Count" class="form-control" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">Total MALE Students outside state</label>
            <input type="number" name="Male_Students_outside_state" placeholder="Enter Count" class="form-control" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">Total FEMALE Students outside state</label>
            <input type="number" name="Female_Students_outside_state" placeholder="Enter Count" class="form-control" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">Total MALE Students outside country</label>
            <input type="number" name="Male_Students_outside_country" placeholder="Enter Count" class="form-control" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">Total FEMALE Students outside country</label>
            <input type="number" name="Female_Students_outside_country" placeholder="Enter Count" class="form-control" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">Total MALE Students Economically Backward</label>
            <input type="number" name="Male_Students_Economic_Backward" placeholder="Enter Count" class="form-control" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">Total FEMALE Students Economically Backward</label>
            <input type="number" name="Female_Students_Economic_Backward" placeholder="Enter Count" class="form-control" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">Total MALE Students Social Backward(SC/ST/OBC)</label>
            <input type="number" name="Male_Students_Social_Backward" placeholder="Enter Count" class="form-control" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">Total FEMALE Students Social Backward(SC/ST/OBC)</label>
            <input type="number" name="Female_Student_Social_Backward" placeholder="Enter Count" class="form-control" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">Total MALE Students Receiving scholarship from Government</label>
            <input type="number" name="Male_Students_Receiving_scholarship_from_Government" placeholder="Enter Count" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">Total FEMALE Students Receiving scholarship from Government</label>
            <input type="number" name="Female_Students_Receiving_scholarship_from_Government" placeholder="Enter Count" class="form-control" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">Total MALE Students Receiving scholarship from Institution</label>
            <input type="number" name="Male_Students_Receiving_scholarship_from_Institution" placeholder="Enter Count" class="form-control" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">Total FEMALE Students Receiving scholarship from Institution</label>
            <input type="number" name="Female_Students_Receiving_scholarship_from_Institution" placeholder="Enter Count" class="form-control" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">Total MALE Students Receiving scholarship from private Bodies</label>
            <input type="number" name="Male_Students_Receiving_scholarship_from_private_Bodies" placeholder="Enter Count" class="form-control" style="margin-top: 0;" required>
        </div>

        <div class="mb-3">
            <label class="form-label" style="margin-bottom: 6px;">Total FEMALE Students Receiving scholarship from private Bodies</label>
            <input type="number" name="Female_Students_Receiving_scholarship_from_private_Bodies" placeholder="Enter Count" class="form-control" style="margin-top: 0;" required>
        </div>

        <button type="submit" class="submit btn btn-primary" name="submit" onclick="return Validate()">Submit</button>

        <!-- ###### added edit button ######## -->

        <button type="button" class="Edit" name="Edit" style="display: none;" onclick="editData()">Edit</button>
        <script>
            function Validate() {
                // Example validation: Check if a field is not empty
                if (document.getElementById("myInput").value !== "") {
                    // Show the "Edit" button after successful submission
                    document.querySelector('.Edit').style.display = 'inline';
                    return true; // Allow form submission
                } else {
                    // Hide the "Edit" button if validation fails (optional)
                    document.querySelector('.Edit').style.display = 'none';
                    alert("Please enter a value."); // Or display an error message
                    return false; // Prevent form submission
                }
            }

            function editData() {
                var inputValue = document.getElementById("myInput").value;

                alert("Editing data: " + inputValue);
            }
        </script>

        <!-- ###### added edit button ######## -->
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
                        <th scope="col">Program Code</th>
                        <th scope="col">Program Name</th>
                        <th scope="col">Number of Students Intake</th>
                        <th scope="col">MALE Students</th>
                        <th scope="col">FEMALE Students</th>
                        <th scope="col">MALE Students within state</th>
                        <th scope="col">FEMALE Students within state</th>
                        <th scope="col">MALE Students outside state</th>
                        <th scope="col">FEMALE Students outside state</th>
                        <th scope="col">MALE Students outside country</th>
                        <th scope="col">FEMALE Students outside country</th>
                        <th scope="col">MALE Students Economic Backward</th>
                        <th scope="col">FEMALE Students Economic Backward</th>
                        <th scope="col">MALE Students Social Backward(SC/ST/OBC)</th>
                        <th scope="col">FEMALE Students Social Backward(SC/ST/OBC)</th>
                        <th scope="col">MALE Students Receiving scholarship from Government</th>
                        <th scope="col">FEMALE Students Receiving scholarship from Government</th>
                        <th scope="col">MALE Students Receiving scholarship from Institution</th>
                        <th scope="col">FEMALE Students Receiving scholarship from Institution</th>
                        <th scope="col">MALE Students Receiving scholarship from private Bodies</th>
                        <th scope="col">FEMALE Students Receiving scholarship from private Bodies</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Delete</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT * FROM `intake_actual_strength` WHERE DEPT_ID = '$dept' AND A_YEAR = '$A_YEAR'";
                    $Record = mysqli_query($conn, $query);

                    while ($row = mysqli_fetch_array($Record)) {
                    ?>
                        <tr>
                            <td><?php echo $row['A_YEAR'] ?></td>
                            <td><?php echo $row['PROGRAM_CODE'] ?></td>
                            <td><?php echo $row['PROGRAM_NAME'] ?></td>
                            <td><?php echo $row['NO_STUDENT_INTAKE'] ?></td>
                            <td><?php echo $row['NO_MALE_STUDENT'] ?></td>
                            <td><?php echo $row['NO_FEMALE_STUDENT'] ?></td>
                            <td><?php echo $row['NO_STUDENT_WITHIN_STATE_MALE'] ?></td>
                            <td><?php echo $row['NO_STUDENT_WITHIN_STATE_FEMALE'] ?></td>
                            <td><?php echo $row['NO_STUDENT_OUTSIDE_STATE_MALE'] ?></td>
                            <td><?php echo $row['NO_STUDENT_OUTSIDE_STATE_FEMALE'] ?></td>
                            <td><?php echo $row['NO_STUDENT_OUTSIDE_COUNTRY_MALE'] ?></td>
                            <td><?php echo $row['NO_STUDENT_OUTSIDE_COUNTRY_FEMALE'] ?></td>
                            <td><?php echo $row['NO_STUDENT_ECONOMIC_BACKWARD_MALE'] ?></td>
                            <td><?php echo $row['NO_STUDENT_ECONOMIC_BACKWARD_FEMALE'] ?></td>
                            <td><?php echo $row['NO_STUDENT_SOCIAL_BACKWARD_SC_ST_OBC_MALE'] ?></td>
                            <td><?php echo $row['NO_STUDENT_SOCIAL_BACKWARD_SC_ST_OBC_FEMALE'] ?></td>
                            <td><?php echo $row['NO_STUDENT_RECEIVING_SCHOLARSHIP_GOVERN_MALE'] ?></td>
                            <td><?php echo $row['NO_STUDENT_RECEIVING_SCHOLARSHIP_GOVERN_FEMALE'] ?></td>
                            <td><?php echo $row['NO_STUDENT_RECEIVING_SCHOLARSHIP_INSTIT_MALE'] ?></td>
                            <td><?php echo $row['NO_STUDENT_RECEIVING_SCHOLARSHIP_INSTIT_FEMALE'] ?></td>
                            <td><?php echo $row['NO_STUDENT_RECEIVING_SCHOLARSHIP_PRIVATE_BODY_MALE'] ?></td>
                            <td><?php echo $row['NO_STUDENT_RECEIVING_SCHOLARSHIP_PRIVATE_BODY_FEMALE'] ?></td>
                            <td><a class="dbutton" href="EditIntakeActualStrength.php?action=delete&ID=<?php echo $row['ID'] ?>">Edit</a></td>
                            <td>
                                <a class="dbutton" href="IntakeActualStrength.php?action=delete&ID=<?php echo $row['ID'] ?>">Delete</a>
                            </td>
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