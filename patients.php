<?php 
include('partials/header.php'); 

include('config/connection.php');

 ?>
<div class="">
    <h1 class="white-text">Patient Profiles</h1>
    <div class="app-buttons">
        <button class="btn btn-primary">
            <a href="patient-create.php">Create New Patient Profile</a>
        </button>

        <form action="" method="GET">
            <div class="input-group mb-3">
                <input type="text" name="search" class="form-control" placeholder="Search Patient" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>

    </div>
    <br>

    <table class="table table-striped table-light">
    <thead>
        <tr>
        <th scope="col">Patient Name</th>
        <th scope="col">First Name</th>
        <th scope="col">Last Name</th>
        <th scope="col">Date of Birth</th>
        <th scope="col">Contact</th>
        <th scope="col">Email</th>
        <th scope="col">Insurance</th>
        <th scope="col">Allergies</th>
        <th scope="col">Chronic Conditions</th>
        <th scope="col">Medications</th>
        <th scope="col">Surgeries</th>
        <th scope="col">Family History</th>
        <th scope="col">Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php 
// Initialize variables for search
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Start building the query
$sql = "SELECT id, firstName, lastName, dob, contact, email, insurance, allergies, chronicConditions, medications, surgeries, familyHistory 
        FROM PatientRecords";

// Initialize an array to hold the conditions
$conditions = array();

// Check if the user entered a patient name
if (!empty($search)) {
    $conditions[] = "(firstName LIKE '%$search%' OR lastName LIKE '%$search%')";
}

// Append the conditions to the query, if any
if (count($conditions) > 0) {
    $sql .= " WHERE " . implode(' AND ', $conditions);
}

// Order by last name
$sql .= " ORDER BY lastName ASC";

// Execute the query
$res = $database->query($sql);

// Check whether the query is executed successfully
if ($res == TRUE) {
    // Count rows to check if data exists
    $count = mysqli_num_rows($res);

    // Check if there are rows returned from the database
    if ($count > 0) {
        // Display the patient records
        while ($rows = mysqli_fetch_assoc($res)) {
            // Get individual data
            $id = $rows["id"];
            $firstName = $rows["firstName"];
            $lastName = $rows["lastName"];
            $dob = $rows["dob"];
            $contact = $rows["contact"];
            $email = $rows["email"];
            $insurance = $rows["insurance"];
            $allergies = $rows["allergies"];
            $chronicConditions = $rows["chronicConditions"];
            $medications = $rows["medications"];
            $surgeries = $rows["surgeries"];
            $familyHistory = $rows["familyHistory"];
            ?>
            
            <tr>
                <td><?php echo $id; ?></td>
                <td><?php echo $firstName; ?></td>
                <td><?php echo $lastName; ?></td>
                <td><?php echo $dob; ?></td>
                <td><?php echo $contact; ?></td>
                <td><?php echo $email; ?></td>
                <td><?php echo $insurance; ?></td>
                <td><?php echo $allergies; ?></td>
                <td><?php echo $chronicConditions; ?></td>
                <td><?php echo $medications; ?></td>
                <td><?php echo $surgeries; ?></td>
                <td><?php echo $familyHistory; ?></td>
                <td>
                    <a class="btn btn-primary" href="edit-patient.php?id=<?php echo $id; ?>">Edit</a>
                    <a class="btn btn-danger" href="delete-patient.php?id=<?php echo $id; ?>">Delete</a>
                </td>
            </tr>

            <?php
        }
    } else {
        // No records found message
        echo "<tr><td colspan='12' class='text-center'>No patient records found for the given criteria.</td></tr>";
    }
} else {
    echo "<h2 class='white-text'> Query failed. </h2>";
}
?>

    </tbody>
    </table>
</div>
<?php 
include('partials/footer.php'); 
?>
