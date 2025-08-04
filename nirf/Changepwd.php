<?php
include 'config.php';  
require 'header.php';
error_reporting(0);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve user input
    $email = $_SESSION['admin_username'];
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    // Check if new password matches confirmation
    if ($newPassword !== $confirmPassword) {
        echo "<script>alert('New password and confirm password do not match.')</script>";
        exit;
    }

    // Securely fetch current password (PLAIN TEXT)
    $stmt = $conn->prepare("SELECT PASS_WORD FROM department_master WHERE EMAIL = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($currentPasswordFromDatabase);
        $stmt->fetch();

        // Verify password (PLAIN TEXT COMPARISON)
        if ($currentPassword === $currentPasswordFromDatabase) {
            // Update the password (PLAIN TEXT)
            $updateStmt = $conn->prepare("UPDATE department_master SET PASS_WORD = ? WHERE EMAIL = ?");
            $updateStmt->bind_param("ss", $newPassword, $email);

            if ($updateStmt->execute()) {
                echo "<script>alert('Password changed successfully.')</script>";
            } else {
                echo "Error updating password: " . $conn->error;
            }
            $updateStmt->close();
        } else {
            echo "<script>alert('Current password is incorrect.')</script>";
        }
    } else {
        echo "<script>alert('User not found.')</script>";
    }

    $stmt->close();
}
?>



    <div class="div">
    <div class="mb-3">
        <p class="text-center fs-4 "><B>Change Password </p>
    </div>
    <form action="" method="post" autocomplete="off">

        <div class="mb-3">
            <label class="form-label">
                Current Password
            </label>
            <input type="password" name="current_password" class="form-control" placeholder="Enter Current Password" required>
        </div>
        
        <div class="mb-3">
            <label class="form-label">
                New Password
            </label>
            <input type="password" name="new_password" class="form-control" placeholder="Enter New Password" required>
        </div>
       
        <div class="mb-3">
            <label class="form-label">
                Confirm New Password
            </label>
            <input type="password" name="confirm_password" class="form-control" placeholder="Confirm New Password" required>
        </div>

        <button type="submit" class="submit btn btn-primary">Change Password</button>
    </form>
    </div>

<?php
require "footer.php";
?>