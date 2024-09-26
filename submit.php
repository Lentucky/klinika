<?php
include('partials/header.php'); 
include('config/connection.php'); // This should properly set $conn

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prepare and bind
    $stmt = $database->prepare("INSERT INTO patientRecords (firstName, lastName, dob, contact, email, insurance, allergies, chronicConditions, medications, surgeries, familyHistory) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssss", $firstName, $lastName, $dob, $contact, $email, $insurance, $allergies, $chronicConditions, $medications, $surgeries, $familyHistory);

    // Set parameters
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $dob = $_POST['dob'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $insurance = $_POST['insurance'];
    $allergies = $_POST['allergies'];
    $chronicConditions = $_POST['chronicConditions']; // Fixed to match the form input name
    $medications = $_POST['medications'];
    $surgeries = $_POST['surgeries'];
    $familyHistory = $_POST['familyHistory'];

    // Execute the statement and check for success
    if ($stmt->execute()) {
        // Redirect to the display page after successful insertion
        header("Location: patients.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
