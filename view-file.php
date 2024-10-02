<?php
include('config/connection.php');

// Check if 'file' is set in the URL query parameter
if (isset($_GET['file'])) {
    $file_path = 'uploads/' . basename($_GET['file']);

    // Check if the file exists on the server
    if (file_exists($file_path)) {
        // Get the file's MIME type
        $mime_type = mime_content_type($file_path);

        // Set the correct headers to display the file
        header('Content-Type: ' . $mime_type);
        header('Content-Length: ' . filesize($file_path)); // Optional: set content length

        // Output the file content
        readfile($file_path);
        exit;
    } else {
        echo "Error: File not found.";
    }
} else {
    echo "No file specified.";
}
?>
