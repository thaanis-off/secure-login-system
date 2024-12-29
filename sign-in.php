<?php

require_once __DIR__ . '/includes/csrf_token.inc.php';

$is_invalid = false;

$user = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $mysqli = require_once __DIR__ . "/includes/database.inc.php";

    // Validate CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("CSRF token validation failed.");
    }

    $stmt = $mysqli->prepare("SELECT * FROM users WHERE email = ?");

    $stmt->bind_param("s", $_POST["email"]);

    $stmt->execute();

    $result = $stmt->get_result();

    $user = $result->fetch_assoc();


    if ($user && $user["account_activation_hash"] === null) {

        if (password_verify($_POST["password"], $user["password_hash"])) {

            if ($user["user_status"] == 0) {
                // Update user_status to 1
                $update_stmt = $mysqli->prepare("UPDATE users SET user_status = 1 WHERE id = ?");

                $update_stmt->bind_param("i", $user["id"]);

                $update_stmt->execute();

                $update_stmt->close();
            }

            session_start();

            // Regenerate session ID for security
            session_regenerate_id();

            // Store the user's ID in the session
            $_SESSION["user_id"] = $user["id"];

            header("location: index.php");
            exit();
        }
    }

    if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        die("A valid email is required");
    }
    if (strlen($_POST["password"]) == null) {
        die("Password is required");
    }


    $is_invalid = true;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./output.css" rel="stylesheet">
    <script src="JustValidatePlugin/just-validate.production.min.js" defer></script>
    <script src="js/signin-validation.js" defer></script>
    <link rel="icon" href="assets/favicon.ico" type="image/x-icon">
    <title>Sign in</title>
</head>



<body>
    <?php if ($_SERVER["REQUEST_METHOD"] === "POST"): ?>
        <?php if (!$user): ?>
            <?php echo "<script>alert('We haven\'t found this email in our records');</script>"; ?>
        <?php elseif ($is_invalid): ?>
            <?php echo "<script>alert('Invalid email or password');</script>"; ?>
        <?php endif; ?>
    <?php endif; ?>



    <!-- sdsd -->

    <div class="flex min-h-full flex-col max-w-md justify-center px-6 py-12 lg:px-8 mx-auto">
        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <h2 class="mt-10 mb-6 text-xl font-semibold text-gray-900 sm:text-2xl">Login</h2>
            <form class="space-y-6" action="" method="POST" id="login" novalidate>
                <div>
                    <label for="email" class="block text-sm/6 font-medium text-gray-900">Email address</label>
                    <div class="mt-2">
                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2"
                            placeholder=""
                            required
                            value="<?= htmlspecialchars($_POST["email"] ?? "") ?>" />
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm/6 font-medium text-gray-900">Password</label>
                        <div class="text-sm">
                            <a href="forget-password/forgot-password.php" class="font-semibold text-blue-500 hover:text-blue-300">Forgot password?</a>
                        </div>
                    </div>
                    <div class="mt-2">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2"
                            placeholder="•••••••••"
                            required />
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    <!-- Login Button -->
                    <button
                        type="submit"
                        class="text-gray-900 bg-gray-100 hover:bg-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 inline-flex items-center">
                        Sign In
                    </button>

                    <!-- Not a member text -->
                    <span class="text-sm text-gray-500">
                        Not a member?
                        <a href="sign-up.php" class="font-semibold text-blue-500 hover:text-blue-400">Sign Up</a>
                    </span>
                </div>
            </form>
        </div>
    </div>



</body>

</html>