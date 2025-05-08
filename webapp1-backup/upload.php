<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['fileToUpload'])) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $uploadFile = $uploadDir . basename($_FILES['fileToUpload']['name']);

        if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $uploadFile)) {
            echo "File successfully uploaded!";
        } else {
            echo "File upload failed.";
        }
    } else {
        echo "No file selected.";
    }
}
?>
