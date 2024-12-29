<?php
session_start();

if (isset($_SESSION["user_id"])) {

    $mysqli =  require __DIR__ . "../includes/database.inc.php";

    $sql = "SELECT * FROM users WHERE id = {$_SESSION["user_id"]}";

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();
}

// print_r($user['profile_image'])
?>

<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="output.css" rel="stylesheet">
    <script defer src="alphineJs/alphine.min.js"></script>
    <title>Contact us</title>
    <link rel="icon" href="assets/favicon.ico" type="image/x-icon">
</head>

<body>

    <!-- nav start -->
    <?php require_once 'includes/nav.inc.php' ?>
    <!-- nav end -->

    <div class=" bg-white px-6  sm:py-14 lg:px-8">

        <div class="mx-auto max-w-xl">
            <h2 class=" text-balance font-semibold tracking-tight text-gray-900 sm:text-2xl block">Contact Us</h2>
        </div>

        <form action="#" method="POST" class="mx-auto mt-4 max-w-xl sm:mt-6">
            <div class="grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-2">
                <div>
                    <label for="first-name" class="block text-sm/6 font-semibold text-gray-900">First name</label>
                    <div class="mt-2.5">
                        <input type="text" name="first-name" id="first-name" autocomplete="given-name" class="block w-full rounded-lg bg-white px-3.5 py-2 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-gray-900">
                    </div>
                </div>
                <div>
                    <label for="last-name" class="block text-sm/6 font-semibold text-gray-900">Last name</label>
                    <div class="mt-2.5">
                        <input type="text" name="last-name" id="last-name" autocomplete="family-name" class="block w-full rounded-lg bg-white px-3.5 py-2 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-gray-900">
                    </div>
                </div>

                <div class="sm:col-span-2">
                    <label for="email" class="block text-sm/6 font-semibold text-gray-900">Email</label>
                    <div class="mt-2.5">
                        <input type="email" name="email" id="email" autocomplete="email" class="block w-full rounded-lg bg-white px-3.5 py-2 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-gray-900">
                    </div>
                </div>
                <div class="sm:col-span-2">
                    <label for="phone-number" class="block text-sm/6 font-semibold text-gray-900">Phone number</label>
                    <div class="mt-2.5">
                        <div class="flex rounded-lg bg-white outline outline-1 -outline-offset-1 outline-gray-300 has-[input:focus-within]:outline has-[input:focus-within]:outline-2 has-[input:focus-within]:-outline-offset-2 has-[input:focus-within]:outline-gray-900">
                            <div class="grid shrink-0 grid-cols-1 focus-within:relative">
                                <select id="country" name="country" autocomplete="country" aria-label="Country" class="col-start-1 row-start-1 w-full appearance-none rounded-md py-2 pl-3.5 pr-7 text-base text-gray-500 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-gray-900 sm:text-sm/6">
                                    <option>US</option>
                                    <option>CA</option>
                                    <option>EU</option>
                                </select>
                                <svg class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
                                    <path fill-rule="evenodd" d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="text" name="phone-number" id="phone-number" class="block min-w-0 grow py-1.5 pl-1 pr-3 text-base text-gray-900 placeholder:text-gray-400 focus:outline focus:outline-0 sm:text-sm/6" placeholder="123-456-7890">
                        </div>
                    </div>
                </div>
                <div class="sm:col-span-2">
                    <label for="message" class="block text-sm/6 font-semibold text-gray-900">Message</label>
                    <div class="mt-2.5">
                        <textarea name="message" id="message" rows="4" class="block w-full rounded-lg bg-white px-3.5 py-2 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-gray-900"></textarea>
                    </div>
                </div>

            </div>
            <div class="mt-10">
                <button type="submit" class="block w-full rounded-md bg-gray-100 px-3.5 py-2.5 text-center text-sm font-semibold text-gray-700 shadow-sm  focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Let's talk</button>
            </div>
        </form>
    </div>




    <!-- footer start -->
    <?php require_once 'includes/footer.inc.php' ?>
    <!-- footer end -->
    <script src="num.js"></script>

    <!-- <script>
        const menuButton = document.getElementById("mobile-menu-button");
        const mobileMenu = document.getElementById("mobile-menu");

        menuButton.addEventListener("click", () => {
            mobileMenu.classList.toggle("hidden");
        });
    </script> -->
</body>

</html>