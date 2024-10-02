<?php
include('config/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get data from the AJAX request
    $file_id = $_POST['file_id'];

    // Delete the file record from the database
    $sql = "DELETE FROM patient_files WHERE file_id = ?";
    $stmt = $database->prepare($sql);
    $stmt->bind_param("i", $file_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }

    $stmt->close();
    $database->close();
}
?>
