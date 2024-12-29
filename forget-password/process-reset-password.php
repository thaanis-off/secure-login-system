<?php

$token = $_POST["token"];

$token_hash = hash("sha256", $token);

$mysqli = require __DIR__ . "/../includes/database.inc.php";

$sql = "SELECT * FROM users
        WHERE reset_token_hash = ?";

$stmt = $mysqli->prepare($sql);

$stmt->bind_param("s", $token_hash);

$stmt->execute();

$result = $stmt->get_result();

$user = $result->fetch_assoc();

if ($user === null) {
    die("token not found");
}

if (strtotime($user["reset_token_expires_at"]) <= time()) {
    die("token has expired");
}

if (strlen($_POST["password"]) < 8) {
    die("Password must be at least 8 characters");
}

if (! preg_match("/[a-z]/i", $_POST["password"])) {
    die("Password must contain at least one letter");
}

if (! preg_match("/[0-9]/", $_POST["password"])) {
    die("Password must contain at least one number");
}

if ($_POST["password"] !== $_POST["password_confirmation"]) {
    die("Passwords must match");
}

$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

$sql = "UPDATE users
        SET password_hash = ?,
            reset_token_hash = NULL,
            reset_token_expires_at = NULL
        WHERE id = ?";

$stmt = $mysqli->prepare($sql);

$stmt->bind_param("ss", $password_hash, $user["id"]);

$stmt->execute();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Update</title>
    <link href="../output.css" rel="stylesheet">
    <link rel="icon" href="../assets/favicon.ico" type="image/x-icon">

</head>



<body class="bg-gray-100">
    <div class="text-center ">
        <h1 class="font-semibold text-3xl mt-44">Password Updated</h1>
        <p class="pt-2 text-gray-900">Password updated successful you can now,
        </p>



        <a href="../sign-in.php">
            <button type="button"
                class="mt-3 pl-12 pr-12 text-gray-900 font-semibold hover:bg-zinc-200 bg-gray-200  rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-500 me-2 mb-2 ">

                Sign In
            </button>
            <br>
        </a>

    </div>


</body>

</html>