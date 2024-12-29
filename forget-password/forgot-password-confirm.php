<?php
session_start();
$user_email = $_SESSION['email'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot password confirm</title>
    <link href="../output.css" rel="stylesheet">
    <link rel="icon" href="../assets/favicon.ico" type="image/x-icon">

</head>

<body class="bg-gray-100">
    <div class="text-center ">
        <h1 class="font-semibold text-3xl mt-44">Forgot Password</h1>
        <p class="pt-2 text-gray-900">We sent an email to <?php echo $user_email; ?>.
            <br> Click the link inside to forgot your password.
        </p>




        <button type="button" id="openGmailButton"
            class="mt-3 pl-12 pr-12 text-gray-900 font-semibold hover:bg-zinc-200 bg-gray-200  rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-500 me-2 mb-2 ">
            <svg class="w-4 h-4 me-2 -ms-1 text-[#626890]" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                width="100" height="100" viewBox="0 0 48 48">
                <path fill="#4caf50" d="M45,16.2l-5,2.75l-5,4.75L35,40h7c1.657,0,3-1.343,3-3V16.2z"></path>
                <path fill="#1e88e5" d="M3,16.2l3.614,1.71L13,23.7V40H6c-1.657,0-3-1.343-3-3V16.2z"></path>
                <polygon fill="#e53935" points="35,11.2 24,19.45 13,11.2 12,17 13,23.7 24,31.95 35,23.7 36,17">
                </polygon>
                <path fill="#c62828"
                    d="M3,12.298V16.2l10,7.5V11.2L9.876,8.859C9.132,8.301,8.228,8,7.298,8h0C4.924,8,3,9.924,3,12.298z">
                </path>
                <path fill="#fbc02d"
                    d="M45,12.298V16.2l-10,7.5V11.2l3.124-2.341C38.868,8.301,39.772,8,40.702,8h0 C43.076,8,45,9.924,45,12.298z">
                </path>
            </svg>
            Open Gmail
        </button>
        <br>


    </div>

    <script>
        document.getElementById('openGmailButton').addEventListener('click', function() {
            window.open('https://mail.google.com', '_blank');
        });
    </script>
</body>

</html>