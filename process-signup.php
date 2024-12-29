<?php
session_start();

// Check if the CSRF token is valid
if (empty($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die("Invalid CSRF token");
}

// Optionally regenerate the token to prevent reuse
unset($_SESSION['csrf_token']);

// Client-side validation bypassed, perform server-side checks
if (empty($_POST["first_name"])) {
    die("First name is required");
}

if (empty($_POST["last_name"])) {
    die("Last name is required");
}

if (empty($_POST["about"])) {
    die("About is required");
}

if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    die("A valid email is required");
}

if (strlen($_POST["password"]) < 8) {
    die("Password must be at least 8 characters long");
}

if (!preg_match("/[a-z]/i", $_POST['password'])) {
    die("Password must contain at least one letter");
}

if (!preg_match("/[0-9]/", $_POST['password'])) {
    die("Password must contain at least one number");
}

if ($_POST["password"] != $_POST["password_confirmation"]) {
    die("Passwords must match");
}

if (!isset($_FILES["image"])) {
    die("Profile image field is not set.");
}

// Hash the password
$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

$activation_token = bin2hex(random_bytes(16));

$activation_token_hash = hash("sha256", $activation_token);

$mysqli = require __DIR__ . "/includes/database.inc.php";

// Check if the user uploaded a file
if (isset($_FILES["image"]) && $_FILES["image"]["error"] === UPLOAD_ERR_OK) {
    // Create a FileInfo instance to validate MIME type
    $finfo = new finfo(FILEINFO_MIME_TYPE);

    // Get the temporary file path
    $tmp_name = $_FILES["image"]["tmp_name"];

    // Get the MIME type of the uploaded file
    if (!is_uploaded_file($tmp_name) || !$mime_type = $finfo->file($tmp_name)) {
        exit("Invalid file upload.");
    }

    // Define allowed MIME types
    $allowed_mime_types = ["image/gif", "image/png", "image/jpeg"];

    // Validate MIME type
    if (!in_array($mime_type, $allowed_mime_types)) {
        exit("Invalid file type. Allowed types are GIF, PNG, and JPEG.");
    }

    // Get original file details
    $pathinfo = pathinfo($_FILES["image"]["name"]);
    $base = $pathinfo["filename"];
    $extension = $pathinfo["extension"];

    // Sanitize the base name
    $base = preg_replace("/[^\w-]/", "_", $base);

    // Ensure the extension matches the MIME type
    $valid_extensions = [
        "image/gif" => "gif",
        "image/png" => "png",
        "image/jpeg" => "jpg",
    ];
    if (!isset($valid_extensions[$mime_type]) || $valid_extensions[$mime_type] !== strtolower($extension)) {
        $extension = $valid_extensions[$mime_type];
    }

    // Construct the destination filename
    $filename = $base . "." . $extension;
    $destination = __DIR__ . "/upload/" . $filename;

    // Add a numeric suffix if the file already exists
    while (file_exists($destination)) {
        $filename = $base . "_" . time() . "." . $extension;
        $destination = __DIR__ . "/upload/" . $filename;
    }

    // Move the uploaded file
    if (!move_uploaded_file($_FILES["image"]["tmp_name"], $destination)) {
        exit("Failed to move the uploaded file.");
    }
}

// Insert data into pending_users table
$sql = "INSERT INTO users (first_name, last_name, about, email, password_hash, profile_image, account_activation_hash) VALUES (?, ?, ?, ?, ?, ?, ?)";

try {
    // Prepare the statement
    $stmt = $mysqli->stmt_init();

    if (!$stmt->prepare($sql)) {
        throw new Exception("SQL ERROR: " . $mysqli->error);
    }

    // Bind parameters
    $stmt->bind_param(
        "sssssss",
        $_POST["first_name"],
        $_POST["last_name"],
        $_POST["about"],
        $_POST["email"],
        $password_hash,
        $filename,
        $activation_token_hash
    );

    // Execute the statement
    $stmt->execute();

    // Send activation email
    $mail = require __DIR__ . "/forget-password/mailer.php";
    $mail->setFrom("noreply@example.com");
    $mail->addAddress($_POST["email"]);
    $mail->Subject = "Account activation";
    $mail->Body = <<<END
    Click <a href="http://localhost/web-project/activate-account.php?token=$activation_token">here</a> 
    to Activate your password.
    END;

    try {
        $mail->send();

        echo "Message sent, please check your inbox.";
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer error: {$mail->ErrorInfo}";
        exit();
    }

    $_SESSION['user_email'] = $_POST['email']; // Store the email
    $_SESSION['signup_token'] = bin2hex(random_bytes(16)); // Generate a temporary token

    header("Location: sign-up-success.php");
    exit;
} catch (mysqli_sql_exception $e) {
    if ($e->getCode() === 1062) {
        die("Email already taken. Please use another email.");
    } else {
        echo "Error: " . $e->getMessage() . " (Error Code: " . $e->getCode() . ")";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
