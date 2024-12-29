<?php require_once __DIR__ . '/includes/csrf_token.inc.php'; ?>
<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./output.css" rel="stylesheet">
    <script src="JustValidatePlugin/just-validate.production.min.js" defer></script>
    <script src="js/signup-validation.js" defer></script>
    <script src="js/script.js" defer></script>
    <link rel="icon" href="assets/favicon.ico" type="image/x-icon">
    <title>Sign up</title>

</head>

<body>



    <div class="mx-auto max-w-2xl px-2 sm:px-6 lg:px-8 mt-10">
        <h2 class="mt-10 mb-6 text-xl font-semibold text-gray-900  sm:text-2xl">Sign Up</h2>
        <!-- <div id="img-view"
            style="width: 200px; height: 200px; background-size: cover; background-position: center; margin-top: 20px;">
        </div> -->
        <form action="process-signup.php" method="post" id="signup" enctype="multipart/form-data" novalidate>
            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <div>
                    <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900">First
                        name</label>
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <input type="text" id="first_name" name="first_name"
                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2"
                        placeholder="" required />
                </div>
                <div>
                    <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900 ">Last
                        name</label>
                    <input type="text" id="last_name" name="last_name"
                        class=" border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2"
                        placeholder="" required />
                </div>










            </div>
            <!-- profile here -->

            <div class="col-span-full mb-6">
                <label for="about" class="block text-sm font-medium text-gray-900">About</label>
                <div class="mt-2">
                    <textarea id="about" rows="4" name="about"
                        class="block p-2.5 w-full text-sm text-gray-900  rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"></textarea>
                </div>
                <p class="mt-3 text-sm text-gray-600">Write a few sentences about yourself.</p>
            </div>

            <div class="mb-6">
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 ">Email
                    address</label>
                <input type="email" id="email" name="email" class=" border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 
                    placeholder=" required />

            </div>
            <div class="mb-6">
                <label for="password" class="block mb-2 text-sm font-medium text-gray-900 ">Password</label>
                <input type="password" id="password" name="password"
                    class=" border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 "
                    placeholder="•••••••••" required />
            </div>
            <div class="mb-6">
                <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900 ">Confirm
                    password</label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                    class=" border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2  "
                    placeholder="•••••••••" required />
            </div>
            <div class="mb-6">


                <label for="profile" class="block mb-2 text-sm font-medium text-gray-900">Profile
                </label>



                <div class="flex items-center justify-center w-full">
                    <label for="dropzone-file" id="drop-area"
                        class="flex flex-col items-center justify-center w-full h-52 border-2 border-dashed border-gray-300  rounded-lg cursor-pointer bg-gray-50">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-4 text-gray-500 " aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                            </svg>
                            <p class="mb-2 text-sm text-gray-500 " id="dropdownContent"><span class="font-semibold">Click
                                    to
                                    upload</span> or drag and drop</p>
                            <p id="img-name" class="text-sm text-gray-500 "></p>
                        </div>
                        <input id="dropzone-file" name="image" type="file" class="hidden m-[30px]"
                            accept="image/*" />

                    </label>
                </div>



                <!-- Image preview area -->


            </div>
            <button type="submit"
                class="mb-10 text-gray-900 bg-gray-100 hover:bg-gray-200    font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center  me-2">
                Sign Up</button>
            <span class="text-sm text-gray-500">
                Already a member?
                <a href="sign-in.php" class="font-semibold text-blue-500 hover:text-blue-400">Sign In</a>
            </span>

        </form>

    </div>





</body>

</html>