<?php
session_start();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_email'])) {
        echo json_encode(['success' => false, 'error' => 'User email not found in session.']);
        exit();
    }

    $user_email = $_SESSION['user_email'];
    $activation_token = bin2hex(random_bytes(16));
    $activation_token_hash = hash("sha256", $activation_token);

    // Database connection
    $mysqli = require __DIR__ . "/includes/database.inc.php";


    // Update the activation token in the database
    $sql = "UPDATE users SET account_activation_hash = ? WHERE email = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ss", $activation_token_hash, $user_email);
    if (!$stmt->execute()) {
        echo json_encode(['success' => false, 'error' => 'Database error while updating token.']);
        exit();
    }

    // Resend the email
    $mail = require __DIR__ . "/forget-password/mailer.php";
    $mail->setFrom("noreply@example.com");
    $mail->addAddress($user_email);
    $mail->Subject = "Resend: Account Activation";
    $mail->Body = <<<END
    Click <a href="http://localhost/web-project/activate-account.php?token=$activation_token">here</a> 
    to activate your account.
    END;

    try {
        $mail->send();
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $mail->ErrorInfo]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method.']);
}
