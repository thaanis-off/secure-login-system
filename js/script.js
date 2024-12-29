const dropArea = document.getElementById("drop-area");
const inputFile = document.getElementById("dropzone-file");

const imgName = document.getElementById("img-name");
const uploadText = document.querySelector("#drop-area p");
const uploadText2 = document.querySelector("#drop-area svg");

inputFile.addEventListener("change", uploadImage);

function uploadImage() {
  if (inputFile.files && inputFile.files[0]) {
    let file = inputFile.files[0];

    imgName.textContent = file.name; // Set the text content to the file name
    uploadText.style.display = "none";
    uploadText2.style.display = "none";
  } else {
    imgName.textContent = "No file selected"; // Error message if no file is selected
  }
}

dropArea.addEventListener("dragover", function (e) {
  e.preventDefault();
});

dropArea.addEventListener("drop", function (e) {
  e.preventDefault();

  // Handle file drop
  inputFile.files = e.dataTransfer.files;
  uploadImage();
});
