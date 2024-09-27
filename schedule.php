<?php 
include("partials/header.php");
include("config/connection.php"); 

$appointments = [];
$query = "SELECT a.pid, a.appodate, a.start_time, a.end_time, s.service_name 
          FROM appointment a 
          JOIN service s ON a.servid = 2"; // should be in forign key
$result = $database->query($query);

if ($result) { // Check if the result is valid
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $appointments[] = [
                'id' => $row['pid'], 
                'title' =>  $row['service_name'], 
                'start' => $row['appodate'] . 'T' . $row['start_time'],
                'end' => $row['appodate'] . 'T' . $row['end_time'],
                'description' => 'Details about the appointment...', 
            ];
        }
    }
} else {
    echo "Error: " . $database->error; 
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css" rel="stylesheet" />
  <link href="css/schedule.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script>
  <title>Schedule</title>
</head>
<body>
  <div id="calendar"></div>
  <div class="modal fade" id="appointmentModal" tabindex="-1" aria-labelledby="appointmentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="appointmentModalLabel">Appointment Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="modalDescription"></p>
                <img id="modalQRCode" src="" alt="QR Code" class="img-fluid" style="display: none;"/>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
</body>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: <?php echo json_encode($appointments); ?>,
        eventClick: function(info) {
            // Populate the modal with the clicked event's details
            document.getElementById('modalDescription').innerText = info.event.extendedProps.description;
            const qrCodeImg = document.getElementById('modalQRCode');
            qrCodeImg.src = info.event.extendedProps.qr_code;
            qrCodeImg.style.display = info.event.extendedProps.qr_code ? 'block' : 'none';

            // Show the modal
            var modal = new bootstrap.Modal(document.getElementById('appointmentModal'));
            modal.show();
        }
    });
    calendar.render();
});
</script>
