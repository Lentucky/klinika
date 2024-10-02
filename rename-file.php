<?php
include('config/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get data from the AJAX request
    $file_id = $_POST['file_id'];
    $new_name = $_POST['new_name'];

    // Update the file name in the database
    $sql = "UPDATE patient_files SET file_name = ? WHERE file_id = ?";
    $stmt = $database->prepare($sql);
    $stmt->bind_param("si", $new_name, $file_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }

    $stmt->close();
    $database->close();
}
?>
