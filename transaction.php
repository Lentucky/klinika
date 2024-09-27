<?php 
include('partials/header.php'); 

include('config/connection.php');

 ?>
<div class="">
    <h1 class="white-text">Clients</h1>
    <div class="app-buttons">
        <button class="btn btn-primary">
            <a href="add-appointment.php">Create New Appointment</a>
        </button>

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
        <th scope="col">Transaction from</th>
        <th scope="col">Date</th>
        <th scope="col">Amount</th>
        <th scope="col">Service</th>
        <th scope="col">Status</th>
        <th scope="col">Events</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            // Initialize variables for search and date
            
            $scheduledate = isset($_GET['scheduledate']) ? $_GET['scheduledate'] : '';

            // Start building the query
            $sql = "SELECT 
                    transaction.transid, 
                    transaction.pid,
                    transaction.price,
                    transaction.transdate,
                    transaction.status,
                    transaction.servid,
                    service.service_name,
                    patient.pname
                    FROM transaction
                    JOIN patient ON (transaction.pid = patient.pid)
                    LEFT JOIN service ON (transaction.servid = service.servid)";

            // Initialize an array to hold the conditions
            $conditions = array();


            // Check if the user entered a scheduled date
            if (!empty($scheduledate)) {
                $conditions[] = "appointment.appodate = '$scheduledate'";
            }

            // Append the conditions to the query, if any
            if (count($conditions) > 0) {
                $sql .= " WHERE " . implode(' AND ', $conditions);
            }

            // Order by appointment date
            $sql .= " ORDER BY transaction.transdate ASC";

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
                        $transid = $rows["transid"];
                        $pname  = $rows["pname"];
                        $transdate = $rows["transdate"];
                        $price = $rows["price"];
                        $service_name = $rows["service_name"];
                        $status = $rows["status"];
                        $servid = $rows["servid"];
                        $pid = $rows["pid"];
                        ?>
                        
                        <tr>
                            <td><?php echo $pname; ?></td>
                            <td><?php echo $transdate; ?></td>
                            <td><?php echo $price; ?></td>
                            <td><?php echo $service_name; ?></td>
                            <td><?php echo $status; ?></td>
                            <td>
                                <button class="btn btn-primary" href="edit-transaction.php?id=<?php echo $id; ?>" >Edit</button>
                                <button class="btn btn-danger" href="delete-transaction.php?id=<?php echo $id; ?>" >Delete</button>
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