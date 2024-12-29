<?php
session_start();
$email = $_POST["email"];
$_SESSION["email"] = $email;

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("A valid email is required");
}

// Connect to the database
$mysqli = require __DIR__ . "/../includes/database.inc.php";

// Check if the email exists in the database
$sql = "SELECT * FROM users WHERE email = ?";

$stmt = $mysqli->prepare($sql);

$stmt->bind_param("s", $email);

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Email exists, proceed with generating the token
    $token = bin2hex(random_bytes(16));

    $token_hash = hash("sha256", $token);

    $expiry = date("Y-m-d H:i:s", time() + 60 * 30);

    // Update the user record with the token and expiry
    $sql = "UPDATE users SET reset_token_hash = ?, 
                        reset_token_expires_at = ? 
                        WHERE email = ?";

    $stmt = $mysqli->prepare($sql);

    $stmt->bind_param("sss", $token_hash, $expiry, $email);

    $stmt->execute();

    if ($mysqli->affected_rows > 0) {
        // Send the password reset email
        $mail = require __DIR__ . "/mailer.php";
        $mail->setFrom("noreply@example.com");
        $mail->addAddress($email);
        $mail->Subject = "Password Reset";
        $mail->Body = <<<END
        Click <a href="http://localhost/web-project/forget-password/reset-password.php?token=$token">here</a> 
        to reset your password.
        END;

        try {
            $mail->send();
            header("location: forgot-password-confirm.php");
            exit();
            //echo "Message sent, please check your inbox.";
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer error: {$mail->ErrorInfo}";
        }
    } else {
        echo "An error occurred. Please try again later.";
    }
} else {
    // Email does not exist
    echo "Email doesn't exist in our records. Please try a valid email.";
}
