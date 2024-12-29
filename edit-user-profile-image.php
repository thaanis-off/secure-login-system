<?php


// Start session
require __DIR__ . "../includes/sessions.inc.php";
// Include the database connection
$mysqli = require __DIR__ . "../includes/database.inc.php";

// Fetch user data from the database
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $_SESSION["user_id"]);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Function to handle file upload
function handleFileUpload($file, $upload_dir, $old_file = null)
{
    if (!isset($file) || $file['error'] != UPLOAD_ERR_OK) {
        return null;
    }

    // Validate file type
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime_type = $finfo->file($file["tmp_name"]);
    $allowed_types = ["image/gif", "image/png", "image/jpeg"];
    if (!in_array($mime_type, $allowed_types)) {
        echo "<script>alert('Invalid file type. Please upload a valid image (JPEG, PNG, GIF).');</script>";
        exit();
    }

    // Generate a unique filename
    $pathinfo = pathinfo($file["name"]);
    $extension = $pathinfo["extension"];
    $filename = time() . "." . $extension;

    // Define destination path
    $destination = $upload_dir . $filename;

    // Remove old file if it exists
    if ($old_file) {
        $old_file_path = $upload_dir . $old_file;
        if (file_exists($old_file_path)) {
            unlink($old_file_path);
        }
    }

    // Move the uploaded file
    if (!move_uploaded_file($file["tmp_name"], $destination)) {
        exit("Error: Unable to move the uploaded file.");
    }

    return $filename;
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $profile_upload_dir = __DIR__ . "/upload/";
    $banner_upload_dir = __DIR__ . "/banner_img/";

    // Handle profile image upload
    $profile_image = handleFileUpload(
        $_FILES["image1"] ?? null,
        $profile_upload_dir,
        $user["profile_image"] ?? null
    );

    // Handle banner image upload
    $banner_image = handleFileUpload(
        $_FILES["banner-image-input"] ?? null,
        $banner_upload_dir,
        $user["banner_image"] ?? null
    );

    // Update the database if at least one file was uploaded
    if ($profile_image || $banner_image) {
        $profile_image = $profile_image ?: $user["profile_image"];
        $banner_image = $banner_image ?: $user["banner_image"];

        $update_sql = "UPDATE users SET profile_image = ?, banner_image = ? WHERE id = ?";
        $stmt = $mysqli->prepare($update_sql);
        $stmt->bind_param("ssi", $profile_image, $banner_image, $_SESSION["user_id"]);

        if ($stmt->execute()) {

            // header("Location: user-profile.php");
            echo "<script>alert('Profile updated successfully.'); window.location.href='user-profile.php';</script>";
            exit();
        } else {
            die("Error updating profile: " . $stmt->error);
        }
    } else {
        echo "<script>alert('No files were uploaded.');</script>";
    }
}




?>



<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./output.css" rel="stylesheet">
    <title>Edit user profile</title>
    <link rel="icon" href="assets/favicon.ico" type="image/x-icon">

</head>

<body>



    <div class="mx-auto max-w-2xl px-2 sm:px-6 lg:px-8 mt-10">
        <h2 class="mt-10 mb-6 text-xl font-semibold text-gray-900  sm:text-2xl">Edit image</h2>

        <form action="" method="post" enctype="multipart/form-data" novalidate>


            <div class="mb-6">
                <label for="profile" class="block mb-2 text-sm font-medium text-gray-900">Profile</label>
                <div class="flex items-center justify-center w-full">
                    <label for="dropzone-file-1" id="drop-area-1"
                        class="flex flex-col items-center justify-center w-full h-52 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer bg-gray-50">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                            </svg>
                            <p class="mb-2 text-sm text-gray-500" id="dropdownContent-1">
                                <span class="font-semibold">Click to upload</span> or drag and drop
                            </p>
                            <p id="img-name-1" class="text-sm text-gray-500"></p>
                        </div>
                        <input id="dropzone-file-1" name="image1" type="file" class="hidden m-[30px]" accept="image/*" />
                    </label>
                </div>
            </div>

            <!-- banner -->
            <div class="mb-6">
                <label for="banner" class="block mb-2 text-sm font-medium text-gray-900">Banner</label>
                <div class="flex items-center justify-center w-full">
                    <label for="dropzone-file-2" id="drop-area-2"
                        class="flex flex-col items-center justify-center w-full h-52 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer bg-gray-50">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                            </svg>
                            <p class="mb-2 text-sm text-gray-500" id="dropdownContent-2">
                                <span class="font-semibold">Click to upload</span> or drag and drop
                            </p>
                            <p id="img-name-2" class="text-sm text-gray-500"></p>
                        </div>
                        <input id="dropzone-file-2" name="banner-image-input" type="file" class="hidden m-[30px]" accept="image/*" />
                    </label>
                </div>
            </div>






            <button type="submit"
                class="text-white bg-zinc-900  focus:ring-2 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2 text-center">
                Update</button>
        </form>

    </div>






    <script>
        function initializeDropArea(dropAreaId, inputFileId, imgNameId, uploadTextId, uploadIconId) {
            const dropArea = document.getElementById(dropAreaId);
            const inputFile = document.getElementById(inputFileId);
            const imgName = document.getElementById(imgNameId);
            const uploadText = document.querySelector(`#${uploadTextId}`);
            const uploadIcon = document.querySelector(`#${uploadIconId}`);

            inputFile.addEventListener("change", uploadImage);

            function uploadImage() {
                if (inputFile.files && inputFile.files[0]) {
                    let file = inputFile.files[0];

                    imgName.textContent = file.name; // Show file name
                    uploadText.style.display = "none";
                    uploadIcon.style.display = "none";
                } else {
                    imgName.textContent = "No file selected"; // Error message if no file is selected
                }
            }

            dropArea.addEventListener("dragover", function(e) {
                e.preventDefault();
            });

            dropArea.addEventListener("drop", function(e) {
                e.preventDefault();

                // Handle file drop
                inputFile.files = e.dataTransfer.files;
                uploadImage();
            });
        }

        // Initialize both file inputs
        initializeDropArea("drop-area-1", "dropzone-file-1", "img-name-1", "dropdownContent-1", "drop-area-1 svg");
        initializeDropArea("drop-area-2", "dropzone-file-2", "img-name-2", "dropdownContent-2", "drop-area-2 svg");
    </script>






</body>

</html>