<?php

class customException extends Exception
{
    public function errorMessage()
    {
        // Custom error message
        die('Invalid or expired activation token.');
    }
}

try {
    if (!isset($_GET["token"])) {
        throw new customException();
    }

    $token = $_GET["token"];
    $token_hash = hash("sha256", $token);

    $mysqli = require __DIR__ . "/includes/database.inc.php";

    // Check if token exists
    $sql = "SELECT * FROM users WHERE account_activation_hash = ?";
    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        throw new Exception("Database query failed: " . $mysqli->error);
    }

    $stmt->bind_param("s", $token_hash);
    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if ($user === null) {
        throw new customException();
    }

    // Update user activation status
    $sql = "UPDATE users SET account_activation_hash = NULL WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        throw new Exception("Database query failed: " . $mysqli->error);
    }

    $stmt->bind_param("s", $user["id"]);
    $stmt->execute();
    $stmt->close();
} catch (customException $e) {
    echo $e->errorMessage();
} catch (Exception $e) {
    // Log error (in production, use a logging framework)
    error_log($e->getMessage());
    echo "An error occurred. Please try again later.";
}


?>
<!DOCTYPE html>
<html>

<head>
    <title>Account activation</title>
    <meta charset="UTF-8">
    <link href="./output.css" rel="stylesheet">
    <link rel="icon" href="assets/favicon.ico" type="image/x-icon">
</head>

<body class="bg-gray-100">

    <div class="text-center ">
        <h1 class="font-semibold text-3xl mt-44">Account activation</h1>
        <p class="pt-2 text-gray-900">Account activated succesful. you can now,


        </p>
        <a class="mb-10 text-blue-700 bg-gray-100 hover:bg-gray-200  font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center  me-2" href="./sign-in.php">Login</a>




        <br>


    </div>


</body>

</html>