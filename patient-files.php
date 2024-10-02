<?php
include('config/connection.php');
// include('partials/header.php');

// Get patient_id from URL (hardcoded for now)
$patient_id = 4;

// Fetch patient info
$sql = "SELECT first_name, last_name, date_of_birth FROM patients WHERE patient_id = ?";
$stmt = $database->prepare($sql);
$stmt->bind_param("i", $patient_id);
$stmt->execute();
$patient = $stmt->get_result()->fetch_assoc();

// Fetch patient files
$sql_files = "SELECT file_name, file_path, file_id FROM patient_files WHERE patient_id = ?";
$stmt_files = $database->prepare($sql_files);
$stmt_files->bind_param("i", $patient_id);
$stmt_files->execute();
$result_files = $stmt_files->get_result();
$files = $result_files->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Files</title>

    <!-- Roboto Font -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- Custom CSS for Patient Files -->
    <link rel="stylesheet" href="css/patient-files.css">
    <!-- JS for Patient Files -->
    <script src="js/patient-files.js" defer></script>

</head>
<body>
<main>
    <div class="container">
        <h1>Patient Files</h1>
        <div class="patient-info">
            <h2><?php echo htmlspecialchars($patient['first_name'] . ' ' . $patient['last_name']); ?></h2>
            <p>Date of Birth: <?php echo htmlspecialchars($patient['date_of_birth']); ?></p>
        </div>

        <!-- Upload Document Button -->
        <div class="upload-section">
            <button onclick="openUploadDocumentModal()">Upload Document</button>
        </div>

        <div class="files-section">
            <h3>Uploaded Documents</h3>
            <?php if (!empty($files)): ?>
                <div class="files-grid">
                    <?php foreach ($files as $file): ?>
                        <!-- File Card -->
                        <div class="file-card">
                            <div class="file-card-body" onclick="openFile('<?php echo htmlspecialchars($file['file_path']); ?>', '<?php echo htmlspecialchars($file['file_id']); ?>')">
                                <?php if (pathinfo($file['file_name'], PATHINFO_EXTENSION) === 'pdf'): ?>
                                    <img src="img/pdf-icon.png" alt="PDF Icon" class="file-thumbnail"> <!-- Add your PDF icon path -->
                                <?php else: ?>
                                    <img src="<?php echo htmlspecialchars($file['file_path']); ?>" alt="<?php echo htmlspecialchars($file['file_name']); ?>" class="file-thumbnail">
                                <?php endif; ?>
                                <p class="file-name"><?php echo htmlspecialchars($file['file_name']); ?></p>
                            </div>
                            <div class="file-actions">
                                <button onclick="openRenameModal(<?php echo $file['file_id']; ?>)">Rename</button>
                                <button onclick="openDeleteModal(<?php echo $file['file_id']; ?>)">Delete</button>
                            </div>

                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>No uploaded documents found for this patient.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Upload Document Modal -->
    <div class="modal" id="uploadDocumentModal" style="display: none;">
        <div class="modal-content">
            <span class="close" onclick="closeUploadDocumentModal()">&times;</span>
            <h2>Upload Document</h2>
            <form action="upload.php" method="POST" enctype="multipart/form-data">
                <input type="file" name="file" required />
                <button type="submit">Upload</button>
            </form>
        </div>
    </div>

    <!-- Modal Backdrop -->
    <div id="modalBackdrop" style="display: none;"></div>

    <!-- Rename Modal -->
    <div class="modal rename-modal">
    <div class="modal-content">
        <span class="close" onclick="closeRenameModal()">&times;</span>
        <h2>Rename File</h2>
        <input type="text" id="rename-input" placeholder="Enter new file name" />
        <div class="controls">
        <button onclick="confirmRename()">Rename</button>
        <button onclick="closeRenameModal()">Cancel</button>
        </div>
    </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal delete-modal">
    <div class="modal-content">
        <span class="close" onclick="closeDeleteModal()">&times;</span>
        <h2>Confirm Deletion</h2>
        <p>Are you sure you want to delete this file?</p>
        <div class="controls">
        <button onclick="confirmDelete()">Delete</button>
        <button onclick="closeDeleteModal()">Cancel</button>
        </div>
    </div>
    </div>

</main>
<?php include('partials/footer.php') ?>
