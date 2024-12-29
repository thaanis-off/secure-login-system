<?php

session_start();

if (isset($_SESSION["user_id"])) {

    $mysqli =  require __DIR__ . "../includes/database.inc.php";

    $sql = "SELECT * FROM users WHERE id = {$_SESSION["user_id"]}";

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();

    // echo $user['id'];
} else {
    header("location: index.php");
}




?>
<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./output.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="icon" href="assets/favicon.ico" type="image/x-icon">
    <title>User dashboard</title>
</head>

<body>

    <?php require_once 'includes/nav.inc.php' ?>

    <section class="container mx-auto px-8 py-5">
        <div class="relative flex flex-col bg-clip-border bg-white text-gray-700  rounded-2xl">

            <div class="relative bg-clip-border mt-4 mx-4 rounded-xl overflow-hidden bg-white text-gray-700  h-60 ">

                <?php

                if ($user['banner_image'] == '') {
                    echo '<img class="w-full h-full object-center" src="./banner_img/dark-image.webp">';
                } else {
                    echo '<img class="w-full h-full object-center" src="./banner_img/'  . $user['banner_image'] . '">';
                }

                ?>

            </div>

            <div class="p-6">
                <div class="flex lg:gap-0 gap-6 flex-wrap justify-between items-center">
                    <div class="flex items-center gap-3">
                        <?php

                        if ($user['profile_image'] == '') {
                            echo '<img  alt="avatar" class="inline-block relative object-cover object-center w-12 h-12 rounded-lg" src="./upload/default-avatar.png">';
                        } else {
                            echo '<img  alt="avatar" class="inline-block relative object-cover object-center w-12 h-12 rounded-lg" src="./upload/'  . $user['profile_image'] . '">';
                        }

                        ?>


                        <div>
                            <h6
                                class="block antialiased tracking-normal font-sans text-base font-semibold leading-relaxed text-blue-gray-900">
                                <?php echo htmlspecialchars($user["first_name"]  . " " .  $user["last_name"]) ?>
                            </h6>
                            <p
                                class="block antialiased font-sans text-sm  leading-normal text-inherit font-normal text-gray-600">
                                <?php echo htmlspecialchars($user["email"]) ?>
                            </p>
                        </div>

                    </div>



                    <a href="edit-user-profile-image.php?id=<?php echo $user['id']; ?>">
                        <button type="button"
                            class="ml-12  text-gray-900 bg-gray-100 hover:bg-gray-200  font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center  me-2 mb-2">
                            Edit

                        </button>
                    </a>
                </div>

                <p
                    class="max-w-[45%] block antialiased font-sans text-sm/6 text-gray-700  leading-normal text-inherit font-normal  mt-6">

                    <?php echo htmlspecialchars($user["about"]) ?>
                </p>
            </div>
        </div>
        <hr>
    </section>


    <div class="container px-14">
        <div class="px-4 sm:px-0">
            <h3 class="text-base/7 font-semibold text-gray-900">Contact Information</h3>
            <p class="mt-1 max-w-2xl text-sm/6 text-gray-500">Personal details.</p>
        </div>
        <div class="mt-6 border-t border-gray-100">
            <dl class="divide-y divide-gray-100">
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                    <dt class="text-sm/6 font-medium text-gray-900">First name</dt>
                    <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0">
                        <?php echo htmlspecialchars($user["first_name"]) ?>
                    </dd>
                </div>
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                    <dt class="text-sm/6 font-medium text-gray-900">Last name</dt>
                    <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0">
                        <?php echo htmlspecialchars($user["last_name"]) ?>
                    </dd>
                </div>
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                    <dt class="text-sm/6 font-medium text-gray-900">Email address</dt>
                    <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0">
                        <?php echo htmlspecialchars($user["email"]) ?>
                    </dd>
                </div>

                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                    <dt class="text-sm/6 font-medium text-gray-900">About</dt>
                    <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0">
                        <?php echo htmlspecialchars($user["about"]) ?>
                    </dd>

                </div>

            </dl>

        </div>

    </div>

    <a href="edit-user-datails.php?id=<?php echo $user['id']; ?>">
        <button type="button"
            class=" ml-12  text-gray-900 bg-gray-100 hover:bg-gray-200  font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center  me-2 mb-2">
            Edit

        </button>
    </a>
    <script src="app.js"></script>

    <?php require_once 'includes/footer.inc.php' ?>

</body>

</html>