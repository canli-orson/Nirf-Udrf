<?php
// include 'config.php'; // Include your database configuration file
// error_reporting(E_ALL);

// // Get the email and department ID from the AJAX request
// $email = $_POST['email'] ?? '';
// $dept_id = $_POST['dept_id'] ?? '';

// if ($email && $dept_id) {
//     // Fetch faculty data from the database
//     $query = "SELECT * FROM faculty_details WHERE DEPT_ID = $dept_id AND EMAIL_ID = '$email' ORDER BY ID DESC LIMIT 1";
//     $result = mysqli_query($conn, $query);

//     if ($result && mysqli_num_rows($result) > 0) {
//         // Fetch the data as an associative array
//         $data = mysqli_fetch_assoc($result);
//         echo json_encode($data); // Return the data as JSON
//     } else {
//         echo json_encode([]); // Return an empty object if no data is found
//     }
// } else {
//     echo json_encode([]); // Return an empty object if email or dept_id is missing
// }
?>


<?php
include 'config.php';
// error_reporting(E_ALL);
error_reporting(0);


// Get the email and department ID from the AJAX request
$email = $_POST['email'] ?? '';
$dept_id = $_POST['dept_id'] ?? '';

if ($email && $dept_id) {
    // Fetch the most recent data for the specific email and department
    $query = "SELECT * FROM faculty_details 
              WHERE DEPT_ID = ? AND EMAIL_ID = ? 
              ORDER BY ID DESC 
              LIMIT 1";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("is", $dept_id, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        // Fetch the data as an associative array
        $data = $result->fetch_assoc();
        echo json_encode($data);
    } else {
        echo json_encode([]); // Return an empty object if no data is found
    }
} else {
    echo json_encode([]); // Return an empty object if email or dept_id is missing
}
?>
