<?php

// echo $_GET['id'];
session_start();

require __DIR__ . "../includes/sessions.inc.php";

$mysqli = require __DIR__ . "../includes/database.inc.php";

$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $_SESSION["user_id"]);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update'])) {


    // initialize arrays empty
    $updates = [];
    $params = [];
    $types = "";


    // Check each field and add it to the update query if provided
    if (!empty($_POST["first_name"])) {
        $updates[] = "first_name = ?";
        $params[] = $_POST["first_name"];
        $types .= "s";
    }

    if (!empty($_POST["last_name"])) {
        $updates[] = "last_name = ?";
        $params[] = $_POST["last_name"];
        $types .= "s";
    }

    if (!empty($_POST["about"])) {
        $updates[] = "about = ?";
        $params[] = $_POST["about"];
        $types .= "s";
    }

    // Handle password updates
    $current_password = $_POST["current_password"] ?? null;
    $new_password = $_POST["new_password"] ?? null;
    $confirm_password = $_POST["password_confirmation"] ?? null;

    if (!empty($current_password)) {


        // Check if current password matches
        if (!password_verify($current_password, $user["password_hash"])) {
            echo "<script>alert('Current password is incorrect.'); window.location.href='';</script>";
            die();
        }
        // Require new password and confirmation if current password is provided
        if (empty($new_password) || empty($confirm_password)) {
            echo "<script>alert('Please provide both new password and confirmation.'); window.location.href='';</script>";
            die();
        }

        // Check if new passwords match
        if ($new_password !== $confirm_password) {
            echo "<script>alert('Confirm passwords do not match.'); window.location.href='';</script>";
            die();
        }

        // Validate password strength
        if (strlen($new_password) < 8) {
            echo "<script>alert('New password must be at least 8 characters long.'); window.location.href='';</script>";
            die();
        }

        // Hash the new password
        $new_password_hashed = password_hash($new_password, PASSWORD_DEFAULT);

        $updates[] = "password_hash = ?";
        $params[] = $new_password_hashed;
        $types .= "s";
    }


    // If no fields to update, do nothing
    if (empty($updates)) {
        die("No fields to update.");
    }
    // Prepare the final SQL query
    $sql = "UPDATE users SET " . implode(", ", $updates) . " WHERE id = ?";
    $params[] = $_SESSION["user_id"];
    $types .= "i";

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param($types, ...$params);

    if ($stmt->execute()) {
        echo "<script>alert('Profile updated successfully.'); window.location.href='user-profile.php';</script>";
        exit();
    } else {
        die("Error updating profile: " . $mysqli->error);
    }
}
?>

<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./output.css" rel="stylesheet">
    <title>Edit user details</title>
    <link rel="icon" href="assets/favicon.ico" type="image/x-icon">

</head>

<body>



    <div class="mx-auto max-w-2xl px-2 sm:px-6 lg:px-8 mt-10">
        <h2 class="mt-10 mb-6 text-xl font-semibold text-gray-900  sm:text-2xl">Edit Profile</h2>
        <!-- <div id="img-view"
            style="width: 200px; height: 200px; background-size: cover; background-position: center; margin-top: 20px;">
        </div> -->
        <form action="" method="post" novalidate>
            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <div>
                    <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900">First
                        name</label>
                    <input type="text" id="first_name" name="first_name"
                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2"
                        placeholder="" value="<?php echo htmlspecialchars($user["first_name"]); ?>" />
                </div>
                <div>
                    <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900 ">Last
                        name</label>
                    <input type="text" id="last_name" name="last_name"
                        class=" border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2"
                        placeholder="" value="<?php echo htmlspecialchars($user["last_name"]); ?>" />
                </div>










            </div>
            <!-- profile here -->

            <div class="col-span-full mb-6">
                <label for="about" class="block text-sm font-medium text-gray-900">About</label>
                <div class="mt-2">
                    <textarea id="about" rows="4" name="about"
                        class="block p-2.5 w-full text-sm text-gray-900  rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"><?php echo htmlspecialchars($user["about"]); ?></textarea>
                </div>
                <p class="mt-3 text-sm text-gray-600">Write a few sentences about yourself.</p>
            </div>

            <div class="mb-6">
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 ">Email
                    address</label>
                <input type="email" id="email" name="email" class=" border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2" value=<?php echo htmlspecialchars($user["email"]); ?> disabled readonly />

            </div>
            <div class="mb-6">
                <label for="current_password" class="block mb-2 text-sm font-medium text-gray-900 ">Current password</label>
                <input type="password" id="current_password" name="current_password"
                    class=" border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 "
                    placeholder="•••••••••" />
            </div>
            <div class="mb-6">
                <label for="new_password" class="block mb-2 text-sm font-medium text-gray-900 ">New password</label>
                <input type="password" id="new_password" name="new_password"
                    class=" border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 "
                    placeholder="•••••••••" />
            </div>
            <div class="mb-6">
                <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900 ">Confirm
                    password</label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                    class=" border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2  "
                    placeholder="•••••••••" required />
            </div>
            <button type="submit" name="update"
                class="text-white bg-zinc-900 mb-6 focus:ring-2 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2 text-center">
                Update</button>
        </form>

    </div>







    <script src="main.js"></script>



</body>

</html>