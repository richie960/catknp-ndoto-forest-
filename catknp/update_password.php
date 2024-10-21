<?php
// File path where the password is stored
$passwordFilePath = 'password.txt';

// Generate a new password (replace this with your own logic)
$newPassword = password_hash('new_password', PASSWORD_DEFAULT);

// Update the password in the file
if (file_put_contents($passwordFilePath, $newPassword) !== false) {
    echo "Password updated successfully!";
} else {
    echo "Error updating password. Check file permissions.";
}
?>
