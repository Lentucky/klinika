<?php include("partials/header.php");
session_start();
include("config/connection.php"); ?>

<form action="" method="POST">
    <div class="form-group">
        <label>Patient</label>
        <input type="text" class="form-control" id="patient" name="patient" placeholder="Enter patient name">
        <input type="hidden" id="patient_id" name="patient_id">

        <div id="patientList" class="list-group"></div>
    </div>

    <div class="form-group">
        <label>Appointment Date</label>
        <div class="input-group mb-3">
            <input type="date" name="scheduledate" class="form-control" value="<?php echo isset($_GET['scheduledate']) ? $_GET['scheduledate'] : ''; ?>">
        </div>
    </div>

    <div class="form-group">
        <label for="start_time">Appointment Start Time</label>
        <input type="time" class="form-control" id="start_time" name="start_time">

        <label for="end_time">Appointment End Time</label>
        <input type="time" class="form-control" id="end_time" name="end_time">
    </div>

    <div class="form-group">
        <label for="serviceSelect">Service</label>
        <select class="form-control" id="serviceSelect" name="service">
            <?php
            // Query to get the services from the database
            $sql = "SELECT * FROM service";
            $result = $database->query($sql);

            // Check if there are results and populate the options
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<option value="'.$row['servid'].'">'.$row['service_name'].'</option>';
                }
            } else {
                echo '<option>No services available</option>';
            }
            ?>
        </select>
    </div>

    <button type="submit" name="submit" id="submit_data" class="btn btn-primary" value="Submit">Submit</button>
</form>

<?php 

if(isset($_POST["submit"])){
    $pid = $_POST["patient_id"];
    $appodate = date('Y-m-d', strtotime($_POST["scheduledate"]));
    $start_time = $_POST["start_time"];
    $end_time = $_POST["end_time"];
    $qrcode = $_POST["qr_code"];
    $servid = $_POST["service"];
  
    $stmt = $database->prepare("INSERT INTO appointment (apponum, pid, appodate, start_time, end_time, servid,qr_code) 
    VALUES (?,?,?,?,?,?,?)");

    $apponum = 1;
    $qrcode = 'qr_code.png';

    $stmt->bind_param("iisssis",$apponum, $pid, $appodate, $start_time, $end_time, $servid,$qrcode);

    if($stmt->execute()){
        header('location: appointment.php');
    }else{
        echo"Error: ".$stmt->error;

    }

    $stmt->close();

  }

?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#patient').keyup(function() {
            let query = $(this).val();
            if (query != '') {
                $.ajax({
                    url: "fetch-patient.php",
                    method: "GET",
                    data: { query: query },
                    success: function(data) {
                        let patients = JSON.parse(data);
                        let patientList = $('#patientList');
                        patientList.empty(); // Clear previous results

                        // Loop through patients and create a list item for each one
                        patients.forEach(function(patient) {
                            patientList.append(`<a href="#" class="list-group-item list-group-item-action" data-pid="${patient.pid}">${patient.pname}</a>`);
                        });

                        // Set patient name and pid when a suggestion is clicked
                        $('.list-group-item').click(function(e) {
                            e.preventDefault();
                            $('#patient').val($(this).text());
                            $('#patient_id').val($(this).data('pid')); // Store pid in hidden input
                            $('#patientList').empty(); // Clear the list after selection
                        });
                    }
                });
            } else {
                $('#patientList').empty(); // Clear the list if input is empty
            }
        });
    });
</script>

<?php include('partials/footer.php'); ?>