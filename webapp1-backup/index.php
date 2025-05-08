<!DOCTYPE html>
<html>
<head>
    <title>File Upload Test</title>
</head>
<body>
    <h2>Upload a file</h2>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <label>Select file to upload:</label>
        <input type="file" name="fileToUpload" id="fileToUpload">
        <br><br>
        <input type="submit" value="Upload File" name="submit">
    </form>
</body>
</html>
