<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['uploaded_file'])) {
    $max_file_size = ini_get('upload_max_filesize');
    $post_max_size = ini_get('post_max_size');
    $file_size = $_FILES['uploaded_file']['size'];
    $upload_dir = 'uploads/';
    
    // Create uploads directory if it doesn't exist
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }
    
    $target_file = $upload_dir . basename($_FILES['uploaded_file']['name']);
    
    // Log configuration values
    error_log("Upload Max Filesize: $max_file_size");
    error_log("Post Max Size: $post_max_size");
    error_log("Uploaded File Size: $file_size");
    
    try {
        if ($file_size > 0 && $file_size <= parse_size($max_file_size)) {
            if (move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $target_file)) {
                $message = "File uploaded successfully: " . htmlspecialchars(basename($_FILES['uploaded_file']['name']));
            } else {
                $message = "Error uploading file. Error code: " . $_FILES['uploaded_file']['error'];
            }
        } else {
            $message = "File size exceeds maximum limit or is empty. File size: $file_size bytes, Max allowed: " . parse_size($max_file_size) . " bytes";
        }
    } catch (Exception $e) {
        $message = "Exception occurred: " . $e->getMessage();
    }
}

// Function to parse PHP ini size values (e.g., 2M to bytes)
function parse_size($size) {
    $unit = preg_replace('/[^bkmgtpezy]/i', '', $size);
    $size = preg_replace('/[^0-9\.]/', '', $size);
    if ($unit) {
        $size *= pow(1024, stripos('bkmgtpezy', $unit[0]));
    }
    return round($size);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload Test</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 0 auto; padding: 20px; }
        .error { color: red; }
        .success { color: green; }
        .config { margin-top: 20px; padding: 10px; background: #f0f0f0; }
    </style>
</head>
<body>
    <h1>File Upload Test</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="file" name="uploaded_file" required>
        <input type="submit" value="Upload File">
    </form>

    <?php if (isset($message)): ?>
        <p class="<?php echo strpos($message, 'successfully') !== false ? 'success' : 'error'; ?>">
            <?php echo htmlspecialchars($message); ?>
        </p>
    <?php endif; ?>

    <div class="config">
        <h3>PHP Configuration</h3>
        <p>upload_max_filesize: <?php echo ini_get('upload_max_filesize'); ?></p>
        <p>post_max_size: <?php echo ini_get('post_max_size'); ?></p>
        <p>memory_limit: <?php echo ini_get('memory_limit'); ?></p>
        <p>max_execution_time: <?php echo ini_get('max_execution_time'); ?> seconds</p>
    </div>
</body>
</html>