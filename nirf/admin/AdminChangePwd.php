<?php
include '../config.php';
include '../PERMISSION.php';

// Set error reporting for debugging
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
error_reporting(0);

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check for admin permission
checkPermission('admin');

// Check if the user is logged in
if (!isset($_SESSION['admin_username'])) {
    // Log the unauthorized access attempt
    error_log("Unauthorized access attempt to change password page from IP: " . $_SERVER['REMOTE_ADDR']);
    
    // Redirect to login page
    header("Location: ../login.php?error=unauthorized");
    exit;
}

// Define variables for error/success messages
$message = "";
$messageType = "";
$debugInfo = "";  // Added for debugging

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve user input
    $email = $_SESSION['admin_username'];
    $currentPassword = $_POST['current_password'];
    $newPassword = trim($_POST['new_password']);
    $confirmPassword = trim($_POST['confirm_password']);
    
    // Debugging - log email being used
    error_log("Processing password change for email: " . $email);
    $debugInfo .= "Email used for verification: " . htmlspecialchars($email) . "<br>";

    // Password policy validation
    $passwordPattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';
    
    if (!preg_match($passwordPattern, $newPassword)) {
        $message = "Password must be at least 8 characters and include at least one uppercase letter, one lowercase letter, one number, and one special character.";
        $messageType = "error";
    } 
    // Check if new password matches confirmation
    else if ($newPassword !== $confirmPassword) {
        $message = "New password and confirm password do not match.";
        $messageType = "error";
    } 
    else {
        try {
            // Test the connection
            if ($conn->connect_error) {
                error_log("Connection failed: " . $conn->connect_error);
                $debugInfo .= "Database connection failed: " . $conn->connect_error . "<br>";
                throw new Exception("Database connection failed");
            }
            
            // Prepare statement with error checking
            $sql = "SELECT PASS_WORD FROM boss WHERE email = ?";
            $stmt = $conn->prepare($sql);
            
            if (!$stmt) {
                error_log("Prepare failed: " . $conn->error);
                $debugInfo .= "SQL prepare failed: " . htmlspecialchars($conn->error) . 
                            " for query: " . htmlspecialchars($sql) . "<br>";
                throw new Exception("Database query preparation failed");
            }
            
            // Bind parameter
            $stmt->bind_param("s", $email);
            
            // Execute with error checking
            if (!$stmt->execute()) {
                error_log("Execute failed: " . $stmt->error);
                $debugInfo .= "SQL execute failed: " . htmlspecialchars($stmt->error) . "<br>";
                throw new Exception("Database query execution failed");
            }
            
            // Get result
            $result = $stmt->get_result();
            $debugInfo .= "Query returned " . $result->num_rows . " rows<br>";
            
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $storedPassword = $row['PASS_WORD'];
                $debugInfo .= "Stored password found in database: " . htmlspecialchars($storedPassword) . "<br>";
                
                // Simple direct comparison instead of password_verify
                if ($currentPassword === $storedPassword) {
                    // Check if new password is the same as current
                    if ($newPassword === $storedPassword) {
                        $message = "New password cannot be the same as the current password.";
                        $messageType = "error";
                    } else {
                        // Store the new password in plain text (no hashing)
                        $updateSql = "UPDATE boss SET PASS_WORD = ? WHERE email = ?";
                        $updateStmt = $conn->prepare($updateSql);
                        
                        if (!$updateStmt) {
                            error_log("Prepare update failed: " . $conn->error);
                            $debugInfo .= "Update prepare failed: " . htmlspecialchars($conn->error) . "<br>";
                            throw new Exception("Database update preparation failed");
                        }
                        
                        $updateStmt->bind_param("ss", $newPassword, $email);
                        
                        if ($updateStmt->execute()) {
                            $message = "Password changed successfully.";
                            $messageType = "success";
                            
                            // Log the successful password change
                            error_log("Password changed successfully for user: $email");
                            
                            // Regenerate session ID for security
                            session_regenerate_id(true);
                            
                            // Clear password fields
                            $_POST = array();
                        } else {
                            error_log("Execute update failed: " . $updateStmt->error);
                            $debugInfo .= "Update execute failed: " . htmlspecialchars($updateStmt->error) . "<br>";
                            $message = "Error updating password. Please try again.";
                            $messageType = "error";
                        }
                        $updateStmt->close();
                    }
                } else {
                    $debugInfo .= "Password mismatch. Entered: " . htmlspecialchars($currentPassword) . 
                                " Stored: " . htmlspecialchars($storedPassword) . "<br>";
                    
                    $message = "Current password is incorrect.";
                    $messageType = "error";
                }
            } else {
                $debugInfo .= "No user found with email: " . htmlspecialchars($email) . "<br>";
                $message = "User not found.";
                $messageType = "error";
            }
            $stmt->close();
            
        } catch (Exception $e) {
            error_log("Exception: " . $e->getMessage());
            $message = "System error occurred. Please try again later.";
            $messageType = "error";
            $debugInfo .= "Exception: " . htmlspecialchars($e->getMessage()) . "<br>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Change Password</title>
    <style>
        :root {
            --primary-color: #4a90e2;
            --error-color: #e74c3c;
            --success-color: #2ecc71;
            --dark-color: #333;
            --light-color: #f8f9fa;
            --border-color: #ddd;
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        
        .container {
            max-width: 500px;
            width: 100%;
            padding: 20px;
        }
        
        .card {
            background-color: white;
            border-radius: 8px;
            box-shadow: var(--shadow);
            overflow: hidden;
        }
        
        .card-header {
            background-color: var(--primary-color);
            color: white;
            padding: 20px;
            text-align: center;
        }
        
        .card-header h2 {
            margin: 0;
            font-weight: 600;
            font-size: 1.5rem;
        }
        
        .card-body {
            padding: 30px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--dark-color);
        }
        
        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            font-size: 1rem;
            transition: border-color 0.3s;
            box-sizing: border-box;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.1);
        }
        
        .password-container {
            position: relative;
        }
        
        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #777;
            background: none;
            border: none;
            font-size: 1rem;
        }
        
        .submit-btn {
            display: block;
            width: 100%;
            padding: 12px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .submit-btn:hover {
            background-color: #357abd;
        }
        
        .alert {
            padding: 12px 15px;
            border-radius: 4px;
            margin-bottom: 20px;
            font-weight: 500;
        }
        
        .alert-error {
            background-color: rgba(231, 76, 60, 0.1);
            color: var(--error-color);
            border-left: 4px solid var(--error-color);
        }
        
        .alert-success {
            background-color: rgba(46, 204, 113, 0.1);
            color: var(--success-color);
            border-left: 4px solid var(--success-color);
        }
        
        .password-strength {
            margin-top: 8px;
            height: 5px;
            background-color: #eee;
            border-radius: 3px;
            overflow: hidden;
        }
        
        .strength-meter {
            height: 100%;
            width: 0;
            transition: width 0.3s, background-color 0.3s;
        }
        
        .password-feedback {
            margin-top: 5px;
            font-size: 0.85rem;
            color: #666;
        }
        
        .requirements {
            margin-top: 8px;
            font-size: 0.85rem;
            color: #666;
        }
        
        .requirement {
            margin-bottom: 3px;
            display: flex;
            align-items: center;
        }
        
        .requirement i {
            margin-right: 5px;
            font-size: 0.8rem;
        }
        
        .requirement.met {
            color: var(--success-color);
        }
        
        .requirement.unmet {
            color: #999;
        }

        .back-link {
            display: inline-block;
            margin-top: 15px;
            color: var(--primary-color);
            text-decoration: none;
            font-size: 0.9rem;
        }

        .back-link:hover {
            text-decoration: underline;
        }
        
        .debug-info {
            margin-top: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-family: monospace;
            font-size: 0.85rem;
            color: #333;
            white-space: pre-wrap;
            max-height: 300px;
            overflow-y: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2>Admin - Change Password</h2>
            </div>
            <div class="card-body">
                <?php if (!empty($message)): ?>
                    <div class="alert alert-<?php echo $messageType; ?>">
                        <?php echo htmlspecialchars($message); ?>
                    </div>
                <?php endif; ?>
                
                <form action="" method="post" id="passwordForm">
                    <!-- CSRF Token Hidden Field -->
                    <!-- <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>"> -->
                    
                    <div class="form-group">
                        <label for="current_password" class="form-label">Current Password</label>
                        <div class="password-container">
                            <input type="password" id="current_password" name="current_password" class="form-control" 
                                placeholder="Enter your current password" required>
                            <button type="button" class="toggle-password" onclick="togglePasswordVisibility('current_password')">
                                Show
                            </button>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="new_password" class="form-label">New Password</label>
                        <div class="password-container">
                            <input type="password" id="new_password" name="new_password" class="form-control" 
                                placeholder="Enter your new password" required onkeyup="checkPasswordStrength()">
                            <button type="button" class="toggle-password" onclick="togglePasswordVisibility('new_password')">
                                Show
                            </button>
                        </div>
                        <div class="password-strength">
                            <div class="strength-meter" id="strength-meter"></div>
                        </div>
                        <div class="password-feedback" id="password-feedback">Password strength</div>
                        
                        <div class="requirements">
                            <div class="requirement unmet" id="req-length">At least 8 characters</div>
                            <div class="requirement unmet" id="req-lowercase">At least 1 lowercase letter</div>
                            <div class="requirement unmet" id="req-uppercase">At least 1 uppercase letter</div>
                            <div class="requirement unmet" id="req-number">At least 1 number</div>
                            <div class="requirement unmet" id="req-special">At least 1 special character</div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="confirm_password" class="form-label">Confirm New Password</label>
                        <div class="password-container">
                            <input type="password" id="confirm_password" name="confirm_password" class="form-control" 
                                placeholder="Confirm your new password" required onkeyup="checkPasswordMatch()">
                            <button type="button" class="toggle-password" onclick="togglePasswordVisibility('confirm_password')">
                                Show
                            </button>
                        </div>
                        <div id="password-match-feedback"></div>
                    </div>
                    
                    <button type="submit" class="submit-btn" id="submit-btn">Change Password</button>

                    <div style="text-align: center; margin-top: 15px;">
                        <a href="/admin/Dashboard.php" class="back-link">Back to Dashboard</a>
                    </div>
                </form>
                
                <!-- Debug Information -->
                <!-- <?php if (!empty($debugInfo)): ?>
                    <div class="debug-info">
                        <h4>Debug Information:</h4>
                        <?php echo $debugInfo; ?>
                    </div>
                <?php endif; ?> -->
            </div>
        </div>
    </div>
    
    <script>
        function togglePasswordVisibility(fieldId) {
            const field = document.getElementById(fieldId);
            const button = field.nextElementSibling;
            
            if (field.type === "password") {
                field.type = "text";
                button.textContent = "Hide";
            } else {
                field.type = "password";
                button.textContent = "Show";
            }
        }
        
        function checkPasswordStrength() {
            const password = document.getElementById('new_password').value;
            const meter = document.getElementById('strength-meter');
            const feedback = document.getElementById('password-feedback');
            
            // Check each requirement
            const hasLength = password.length >= 8;
            const hasLower = /[a-z]/.test(password);
            const hasUpper = /[A-Z]/.test(password);
            const hasNumber = /[0-9]/.test(password);
            const hasSpecial = /[^A-Za-z0-9]/.test(password);
            
            // Update requirement indicators
            document.getElementById('req-length').className = hasLength ? 'requirement met' : 'requirement unmet';
            document.getElementById('req-lowercase').className = hasLower ? 'requirement met' : 'requirement unmet';
            document.getElementById('req-uppercase').className = hasUpper ? 'requirement met' : 'requirement unmet';
            document.getElementById('req-number').className = hasNumber ? 'requirement met' : 'requirement unmet';
            document.getElementById('req-special').className = hasSpecial ? 'requirement met' : 'requirement unmet';
            
            // Calculate strength
            let strength = 0;
            if (hasLength) strength += 20;
            if (hasLower) strength += 20;
            if (hasUpper) strength += 20;
            if (hasNumber) strength += 20;
            if (hasSpecial) strength += 20;
            
            // Update meter
            meter.style.width = strength + '%';
            
            // Set color based on strength
            if (strength <= 20) {
                meter.style.backgroundColor = '#e74c3c'; // Red - Very Weak
                feedback.textContent = 'Very Weak';
                feedback.style.color = '#e74c3c';
            } else if (strength <= 40) {
                meter.style.backgroundColor = '#e67e22'; // Orange - Weak
                feedback.textContent = 'Weak';
                feedback.style.color = '#e67e22';
            } else if (strength <= 60) {
                meter.style.backgroundColor = '#f1c40f'; // Yellow - Moderate
                feedback.textContent = 'Moderate';
                feedback.style.color = '#f1c40f';
            } else if (strength <= 80) {
                meter.style.backgroundColor = '#3498db'; // Blue - Strong
                feedback.textContent = 'Strong';
                feedback.style.color = '#3498db';
            } else {
                meter.style.backgroundColor = '#2ecc71'; // Green - Very Strong
                feedback.textContent = 'Very Strong';
                feedback.style.color = '#2ecc71';
            }
        }
        
        function checkPasswordMatch() {
            const newPassword = document.getElementById('new_password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            const feedback = document.getElementById('password-match-feedback');
            
            if (confirmPassword.length === 0) {
                feedback.textContent = '';
                return;
            }
            
            if (newPassword === confirmPassword) {
                feedback.textContent = 'Passwords match';
                feedback.style.color = '#2ecc71';
            } else {
                feedback.textContent = 'Passwords do not match';
                feedback.style.color = '#e74c3c';
            }
        }
        
        // Add form validation before submission
        document.getElementById('passwordForm')?.addEventListener('submit', function(event) {
            const newPassword = document.getElementById('new_password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            
            const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
            
            if (!passwordPattern.test(newPassword)) {
                event.preventDefault();
                alert('Please ensure your password meets all the requirements.');
                return false;
            }
            
            if (newPassword !== confirmPassword) {
                event.preventDefault();
                alert('Passwords do not match.');
                return false;
            }
            
            return true;
        });
    </script>
</body>
</html>