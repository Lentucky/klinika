<!-- <?php include('partials/header.php') ?> -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Calendar</title>
    <!-- Roboto Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/schedule.css">

    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
</head>
<main>
    <div id="calendar"></div>
    <!-- Modal structure -->
    <div id="modalBackdrop"></div>
    <div id="appointmentModal">
        <div class="modal-content">
            <h4>Appointment Details</h4>
            <p id="appointmentDetails"></p>
            <button id="closeModal">Close</button>
            <button id="checkAppointmentBtn">Check Appointment</button>
        </div>
    </div>
</main>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');

            // Initialize FullCalendar
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: 'fetch-events.php',  
                eventClick: function(info) {
                    var modal = document.getElementById('appointmentModal');
                    var modalBackdrop = document.getElementById('modalBackdrop');
                    
                    // Display appointment details
                    var details = "Patient: " + info.event.title + "<br>Date: " + info.event.start.toLocaleString();
                    document.getElementById('appointmentDetails').innerHTML = details;

                    // Show modal and backdrop
                    modal.style.display = 'block';
                    modalBackdrop.style.display = 'block';

                    // Handle the "Check Appointment" button click
                    document.getElementById('checkAppointmentBtn').onclick = function() {
                        window.location.href = '/appointment_details.php?id=' + info.event.id; // Redirect to appointment details page
                    };

                    // Close modal on button click
                    document.getElementById('closeModal').onclick = function() {
                        modal.style.display = 'none';
                        modalBackdrop.style.display = 'none';
                    };

                    // Close modal when clicking outside the modal
                    modalBackdrop.onclick = function() {
                        modal.style.display = 'none';
                        modalBackdrop.style.display = 'none';
                    };
                }
            });
            calendar.render();                   
        });
    </script>

<?php include('partials/footer.php') ?>
