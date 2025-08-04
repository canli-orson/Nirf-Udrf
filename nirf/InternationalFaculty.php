<?php
include 'config.php';
require "header.php";
// error_reporting(E_ALL);
error_reporting(0);


$dept = $_SESSION['dept_id'];

if (isset($_POST['submit'])){

    $Male_Faculty_Inbound=trim(strip_tags(filter_input(INPUT_POST, 'Male_Faculty_Inbound', FILTER_SANITIZE_NUMBER_INT)));
    $Female_Faculty_Inbound=trim(strip_tags(filter_input(INPUT_POST, 'Female_Faculty_Inbound', FILTER_SANITIZE_NUMBER_INT)));
    $Male_Faculty_Outbound=trim(strip_tags(filter_input(INPUT_POST, 'Male_Faculty_Outbound', FILTER_SANITIZE_NUMBER_INT)));
    $Female_Faculty_Outbound=trim(strip_tags(filter_input(INPUT_POST, 'Female_Faculty_Outbound', FILTER_SANITIZE_NUMBER_INT)));

    $query="INSERT INTO `inter_faculty`(`A_YEAR`, `DEPT_ID`, `TOTAL_NO_INBOUND_FAC_MALE`, `TOTAL_NO_INBOUND_FAC_FEMALE`, `TOTAL_NO_OUTBOUND_FAC_MALE`, `TOTAL_NO_OUTBOUND_FAC_FEMALE`) 
    VALUES ('$A_YEAR', '$dept','$Male_Faculty_Inbound','$Female_Faculty_Inbound','$Male_Faculty_Outbound', '$Female_Faculty_Outbound')
    ON DUPLICATE KEY UPDATE
    TOTAL_NO_INBOUND_FAC_MALE = VALUES(TOTAL_NO_INBOUND_FAC_MALE),
    TOTAL_NO_INBOUND_FAC_FEMALE = VALUES(TOTAL_NO_INBOUND_FAC_FEMALE),
    TOTAL_NO_OUTBOUND_FAC_MALE = VALUES(TOTAL_NO_OUTBOUND_FAC_MALE),
    TOTAL_NO_OUTBOUND_FAC_FEMALE = VALUES(TOTAL_NO_OUTBOUND_FAC_FEMALE)";
    // $q=mysqli_query($conn,$query);
    if(mysqli_query($conn, $query)){
        echo "<script>alert('Data Entered.')</script>";
        echo '<script>window.location.href = "InternationalFaculty.php";</script>';
    } else{
        echo "<script>alert('Woops! There was an error (Contact Admin if it continues).')</script>";
    }
}    

if(isset($_GET['action'])) {
    $action=$_GET['action'];
    if($action == 'delete') {
        $id=$_GET['ID'];
        $sql = mysqli_query($conn, "delete from inter_faculty where ID = '$id'");
        echo '<script>window.location.href = "InternationalFaculty.php";</script>';
    }
}
?>
        <div class="div">
            <form class="fw-bold" method="POST" enctype="multipart/form-data" autocomplete="off">
                <div class="mb-3">
                    <p class="text-center fs-4 ">International Faculty</p>
                </div>
                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>Academic Year</b></label>
                    <input type="text" name="year" value="<?php echo $A_YEAR?>" class="form-control" style="margin-top: 0;" disabled>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>Dept ID</b></label>
                    <input type="text" name="dpt_id" value="<?php echo $dept?>" class="form-control" style="margin-top: 0;" disabled>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>Total MALE Faculty Inbound</b></label>
                    <input type="number" name="Male_Faculty_Inbound" class="form-control" placeholder="Enter Total Male Faculty Inbound" style="margin-top: 0;" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>Total FEMALE Faculty Inbound</b></label>
                    <input type="number" name="Female_Faculty_Inbound" class="form-control" placeholder="Enter Total Female Faculty Inbound" style="margin-top: 0;" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>Total MALE Faculty Outbound</b></label>
                    <input type="number" name="Male_Faculty_Outbound" class="form-control" placeholder="Enter Total Male Faculty Outbound" style="margin-top: 0;" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="margin-bottom: 6px;"><b>Total FEMALE Faculty Outbound</b></label>
                    <input type="number" name="Female_Faculty_Outbound" class="form-control" placeholder="Enter Total Female Faculty Outbound" style="margin-top: 0;" required>
                </div>

                <input type="submit" class="submit btn btn-primary" value="Submit" name="submit" onclick="return Validate()">
            </form>
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
                            <th scope="col">Total MALE Faculty Inbound</th> 
                            <th scope="col">Total FEMALE Faculty Inbound</th>
                            <th scope="col">Total MALE Faculty Outbound</th>
                            <th scope="col">Total FEMALE Faculty Outbound</th>
                            <th scope="col">Edit</th>
                            <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                $Record = mysqli_query($conn, "SELECT * FROM inter_faculty WHERE DEPT_ID = '$dept' AND A_YEAR = '$A_YEAR'");
                while ($row = mysqli_fetch_array($Record)) {
                    ?>
                <tr>
                    <td><?php echo $row['A_YEAR']?></td>
                    <td><?php echo $row['TOTAL_NO_INBOUND_FAC_MALE']?></td>
                    <td><?php echo $row['TOTAL_NO_INBOUND_FAC_FEMALE']?></td>
                    <td><?php echo $row['TOTAL_NO_OUTBOUND_FAC_MALE']?></td>
                    <td><?php echo $row['TOTAL_NO_OUTBOUND_FAC_FEMALE']?></td>
                    <td><a class="dbutton" href="EditInternationalFaculty.php?action=edit&ID=<?php echo $row['ID']?>">Edit</a></td>
                    <td><a class="dbutton" href="InternationalFaculty.php?action=delete&ID=<?php echo $row['ID']?>">Delete</a></td>
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
