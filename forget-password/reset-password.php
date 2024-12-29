<?php

$token = $_GET["token"];

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

?>
<!DOCTYPE html>
<html>

<head>
    <title>Reset Password</title>
    <meta charset="UTF-8">
    <link href="../output.css" rel="stylesheet">
    <link rel="icon" href="../assets/favicon.ico" type="image/x-icon">
    <script src="../JustValidatePlugin/just-validate.production.min.js" defer></script>
    <script src="../js/reset-password-validation.js" defer></script>

</head>

<body>

    <div class="flex min-h-full flex-col max-w-md justify-center px-6 py-12 lg:px-8 mx-auto">
        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <h2 class="mt-10 mb-6 text-xl font-semibold text-gray-900 sm:text-2xl">Reset Password</h2>
            <form class="space-y-6" action="process-reset-password.php" method="POST" id="reset-password" novalidate>
                <div>
                    <label for="email" class="block text-sm/6 font-medium text-gray-900">Password</label>
                    <div class="mt-2">
                        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2"
                            placeholder="•••••••••"
                            required />
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <label for="password_confirmation" class="block text-sm/6 font-medium text-gray-900">Confrim Password</label>

                    </div>
                    <div class="mt-2">
                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
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
                        Submit
                    </button>


                </div>
            </form>
        </div>
    </div>
</body>

</html>