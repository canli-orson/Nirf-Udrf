<?php
include 'config.php';
require "header.php";
// error_reporting(E_ALL);
error_reporting(0);


$dept = $_SESSION['dept_id'];
    
if (isset($_POST['submit'])){

    $First_Name=trim(strip_tags(filter_input(INPUT_POST,'First_Name',FILTER_SANITIZE_STRING)));
    $Last_Name=trim(strip_tags(filter_input(INPUT_POST,'Last_Name',FILTER_SANITIZE_STRING)));
    $Designation=trim(strip_tags(filter_input(INPUT_POST,'Designation',FILTER_SANITIZE_STRING)));;
    $Type_of_Industry=trim(strip_tags(filter_input(INPUT_POST,'Type_of_Industry',FILTER_SANITIZE_STRING)));;
    $Company=trim(strip_tags(filter_input(INPUT_POST,'Company',FILTER_SANITIZE_STRING)));
    $Location=trim(strip_tags(filter_input(INPUT_POST,'Location',FILTER_SANITIZE_STRING)));
    $Email_ID=trim(strip_tags(filter_input(INPUT_POST,'Email_ID',FILTER_SANITIZE_EMAIL)));
    $Phone_Number=trim(strip_tags(filter_input(INPUT_POST,'Phone_Number',FILTER_SANITIZE_NUMBER_INT)));;
    $type=trim(strip_tags(filter_input(INPUT_POST,'type',FILTER_SANITIZE_STRING)));

    $query="INSERT INTO `employers_details`(`A_YEAR`, `DEPT_ID`, `FIRST_NAME`, `LAST_NAME`, `DESIGNATION`, `TYPE_OF_INDUSTRY`, `COMPANY`, `LOCATION`, `EMAIL_ID`, `PHONE`, `TYPE_INDIAN_FOREIGN`) 
    VALUES ('$A_YEAR', '$dept','$First_Name','$Last_Name','$Designation', '$Type_of_Industry', '$Company', '$Location', '$Email_ID', '$Phone_Number', '$type')
    ON DUPLICATE KEY UPDATE
    FIRST_NAME = VALUES(FIRST_NAME),
    LAST_NAME = VALUES(LAST_NAME),
    DESIGNATION = VALUES(DESIGNATION),
    TYPE_OF_INDUSTRY = VALUES(TYPE_OF_INDUSTRY),
    COMPANY = VALUES(COMPANY),
    LOCATION = VALUES(LOCATION),
    EMAIL_ID = VALUES(EMAIL_ID),
    PHONE = VALUES(PHONE),
    TYPE_INDIAN_FOREIGN = VALUES(TYPE_INDIAN_FOREIGN)";
    // $q=mysqli_query($conn,$query);
    if(mysqli_query($conn, $query)){
        echo "<script>alert('Data Entered.')</script>";
        echo '<script>window.location.href = "EmployerDetails.php";</script>';
    } else{
        echo "<script>alert('Woops! There was an error (Contact Admin if it continues).')</script>";
    }
}    

if(isset($_GET['action'])) {
    $action=$_GET['action'];
    if($action == 'delete') {
        $id=$_GET['ID'];
        $sql = mysqli_query($conn, "delete from employers_details where ID = '$id'");
        echo '<script>window.location.href = "EmployerDetails.php";</script>';
    }
}
?>
        <div class="div">
            <form class="fw-bold" method="POST" enctype="multipart/form-data" autocomplete="off">
                <div class="mb-3">
                    <p class="text-center fs-4"><b>Employer Details</b></p>
                </div>
                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>Academic Year</b></label>
                    <input type="years" name="year" value="<?php echo $A_YEAR?>" class="form-control" style="margin-top: 0;" disabled>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>Department ID</b></label>
                    <input type="text" name="dpt_id" value="<?php echo $dept?>" class="form-control" style="margin-top: 0;" disabled>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>First Name</b></label>
                    <input type="text" name="First_Name" class="form-control" placeholder="Enter First Name" style="margin-top: 0;" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>Last Name</b></label>
                    <input type="text" name="Last_Name" class="form-control" placeholder="Enter Last Name" style="margin-top: 0;"required>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>Designation</b></label>
                    <input type="text" name="Designation" class="form-control" placeholder="Enter Designation" style="margin-top: 0;" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>Type of Industry</b></label>
                    <input type="text" name="Type_of_Industry" class="form-control" placeholder="Enter Industry" style="margin-top: 0;" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>Company</b></label>
                    <input type="text" name="Company" class="form-control" placeholder="Enter Company Name" style="margin-top: 0;" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>Location</b></label>
                    <input type="text" name="Location" class="form-control" placeholder="Enter Location" style="margin-top: 0;" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>Email ID</b></label>
                    <input type="email" name="Email_ID" class="form-control" placeholder="Enter Email ID" style="margin-top: 0;" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>Phone Number</b></label>
                    <input type="number" name="Phone_Number" class="form-control" placeholder="Enter Mobile Number" style="margin-top: 0;" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>Type(Indian/Foreign)</b></label>
                    <select name="type" style="margin-top: 0%;">
                        <option value="Indian">Indian</option>
                        <option value="Foreign">Foreign</option>
                </div>

                <input type="submit" class="submit btn btn-primary" value="Submit" name="submit" onclick="return Validate()">
            </form>
        </div>
        </div>

         <!-- Show Entered Data -->
    <div class="row my-5" >
    <h3 class="fs-4 mb-3 text-center" id="msg"><b>You Have Entered the Following Data</b></h3>
        <div class="col ">
            <div class="overflow-auto">
                <table class="table bg-white rounded shadow-sm  table-hover ">
                    <thead>
                        <tr>
                            <th scope="col">Academic Year</th>
                            <th scope="col">First Name</th>
                            <th scope="col">Last Name</th>
                            <th scope="col">Designation</th>
                            <th scope="col">Type of Industry</th>
                            <th scope="col">Company</th>
                            <th scope="col">Location</th>
                            <th scope="col">Email ID</th>
                            <th scope="col">Phone Number</th>
                            <th scope="col">Type(Indian/Foreign)</th>
                            <th scope="col">Edit</th>
                            <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                $Record = mysqli_query($conn, "SELECT * FROM employers_details WHERE DEPT_ID = '$dept' AND A_YEAR = '$A_YEAR'");
                while ($row = mysqli_fetch_array($Record)) {
                    ?>
                <tr>
                    <td><?php echo $row['A_YEAR']?></td>
                    <td><?php echo $row['FIRST_NAME']?></td>
                    <td><?php echo $row['LAST_NAME']?></td>
                    <td><?php echo $row['DESIGNATION']?></td>
                    <td><?php echo $row['TYPE_OF_INDUSTRY']?></td>
                    <td><?php echo $row['COMPANY']?></td>
                    <td><?php echo $row['LOCATION']?></td>
                    <td><?php echo $row['EMAIL_ID']?></td>
                    <td><?php echo $row['PHONE']?></td>
                    <td><?php echo $row['TYPE_INDIAN_FOREIGN']?></td>
                    <td><a class="dbutton" href="EditEmployerDetails.php?action=edit&ID=<?php echo $row['ID']?>">Edit</a></td>
                    <td><a class="dbutton" href="EmployerDetails.php?action=delete&ID=<?php echo $row['ID']?>">Delete</a></td>
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

