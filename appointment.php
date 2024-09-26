<?php 
include('partials/header.php'); 

include('config/connection.php');

 ?>
<div class="">
    <h1 class="white-text">Clients</h1>
    <div class="app-buttons">
        <button class="btn btn-primary">Create New Appointment</button>

        <form action="" method="GET">
            <div class="input-group mb-3">
                <input type="text" name="search" class="form-control" placeholder="Search Patient" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
            </div>
            <div class="input-group mb-3">
                <input type="date" name="scheduledate" class="form-control" value="<?php echo isset($_GET['scheduledate']) ? $_GET['scheduledate'] : ''; ?>">
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>

    </div>
    <br>

    <table class="table table-striped table-light">
    <thead>
        <tr>
        <th scope="col">Appointment ID</th>
        <th scope="col">Patient Name</th>
        <th scope="col">Appointment Number</th>
        <th scope="col">Appointment Date</th>
        <th scope="col">Appointment Time</th>
        <th scope="col">QR Code</th>
        <th scope="col">QR Events</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            // Initialize variables for search and date
            $search = isset($_GET['search']) ? $_GET['search'] : '';
            $scheduledate = isset($_GET['scheduledate']) ? $_GET['scheduledate'] : '';

            // Start building the query
            $sql = "SELECT appointment.appoid, appointment.pid, appointment.apponum, appointment.appodate, appointment.start_time, appointment.end_time, appointment.qr_code, patient.pname 
                    FROM appointment
                    JOIN patient ON appointment.pid = patient.pid";

            // Initialize an array to hold the conditions
            $conditions = array();

            // Check if the user entered a patient name
            if (!empty($search)) {
                $conditions[] = "patient.pname LIKE '%$search%'";
            }

            // Check if the user entered a scheduled date
            if (!empty($scheduledate)) {
                $conditions[] = "appointment.appodate = '$scheduledate'";
            }

            // Append the conditions to the query, if any
            if (count($conditions) > 0) {
                $sql .= " WHERE " . implode(' AND ', $conditions);
            }

            // Order by appointment date
            $sql .= " ORDER BY appointment.appodate ASC";

            // Execute the query
            $res = $database->query($sql);

            // Check whether the query is executed successfully
            if ($res == TRUE) {
                // Count rows to check if data exists
                $count = mysqli_num_rows($res);

                // Check if there are rows returned from the database
                if ($count > 0) {
                    // Display the appointments
                    while ($rows = mysqli_fetch_assoc($res)) {
                        // Get individual data
                        $appoid = $rows["appoid"];
                        $pid = $rows["pid"];
                        $apponum = $rows["apponum"];
                        $appodate = $rows["appodate"];
                        $formatted_start_time = date('H:i', strtotime($rows['start_time']));
                        $formatted_end_time = date('H:i', strtotime($rows['end_time']));
                        $qrcode = $rows["qr_code"];
                        $pname = $rows["pname"];
                        ?>
                        
                        <tr>
                            <td><?php echo $appoid; ?></td>
                            <td><?php echo $pname; ?></td>
                            <td><?php echo $apponum; ?></td>
                            <td><?php echo $appodate; ?></td>
                            <td><?php echo $formatted_start_time; ?> - <?php echo $formatted_end_time; ?></td>
                            <td><?php echo $qrcode; ?></td>
                            <td>
                                <button class="btn btn-primary">Edit</button>
                                <button class="btn btn-danger">Delete</button>
                            </td>
                        </tr>

                        <?php
                    }
                } else {
                    // No records found message
                    echo "<tr><td colspan='6' class='text-center'>No appointments found for the given criteria.</td></tr>";
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