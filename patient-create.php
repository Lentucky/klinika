<?php include("partials/header.php");
session_start();
include("config/connection.php"); ?>

<form action="submit.php" method="POST">
    <div class="form-group">
        <label for="firstName">First Name:</label>
        <input type="text" class="form-control" id="firstName" name="firstName" placeholder="Enter first name" required>

        <label for="lastName">Last Name:</label>
        <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Enter last name" required>

        <label for="dob">Date of Birth:</label>
        <input type="date" class="form-control" id="dob" name="dob" required>

        <label for="contact">Contact:</label>
        <input type="text" class="form-control" id="contact" name="contact" required>

        <label for="email">Email:</label>
        <input type="email" class="form-control" id="email" name="email">

        <label for="insurance">Insurance:</label>
        <input type="text" class="form-control" id="insurance" name="insurance">

        <label for="allergies">Allergies:</label>
        <select class="form-control" id="allergies" name="allergies" required>
            <option value="yes">Yes</option>
            <option value="no">No</option>
        </select>

        <label for="chronicConditions">Chronic Conditions:</label>
        <select class="form-control" id="chronicConditions" name="chronicConditions" required>
            <option value="yes">Yes</option>
            <option value="no">No</option>
        </select>

        <label for="medications">Currently Taking Medications:</label>
        <select class="form-control" id="medications" name="medications" required>
            <option value="yes">Yes</option>
            <option value="no">No</option>
        </select>

        <label for="surgeries">Previous Surgeries:</label>
        <select class="form-control" id="surgeries" name="surgeries" required>
            <option value="yes">Yes</option>
            <option value="no">No</option>
        </select>

        <label for="familyHistory">Family History of Conditions:</label>
        <select class="form-control" id="familyHistory" name="familyHistory" required>
            <option value="yes">Yes</option>
            <option value="no">No</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>

<?php include('partials/footer.php'); ?>
