<?php 
include('partials/header.php'); 

include('config/connection.php');
 ?>
<div class="container">
    <h1 class="white-text">Clients</h1>
    <form action="" method="post">
        <input type="date" name="sheduledate" id="date" class="input-text filter-container-items" style="margin: 0;width: 95%;">
    </form>
    <br>

    <table class="table table-striped table-dark">
    <thead>
        <tr>
        <th scope="col">Appointment ID</th>
        <th scope="col">Patient Name</th>
        <th scope="col">Appointment Number</th>
        <th scope="col">Appointment Date</th>
        <th scope="col">QR Code</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        if(isset($_GET['search']))
        {
            $filtervalues = $_GET['search'];
            $query = "SELECT * 
                    FROM appointment 
                    JOIN pid ON appointment.pid = patient.pid
                    WHERE apponum LIKE '%$filtervalues%'";
            $query_run = mysqli_query($conn, $query);

            if(mysqli_num_rows($query_run) > 0)
            {
                foreach($query_run as $items)
                {
                    ?>
                    <tr>
                        <td><?= $items['appoid']; ?></td>
                        <td><?= $items['pname']; ?></td>
                        <td><?= $items['apponum']; ?></td>
                        <td><?= $items['appodate']; ?></td>
                        <td><?= $items['qrcode']; ?></td>
                    </tr>
                    <?php
                }
            }
            else
            {
                ?>
                <tr>
                    <td colspan="7">No Record Found</td>
                </tr>
                <?php
            }
            }
            else
            {
                //Query to Get all Admin
                $sql = "SELECT             
                        appointment.appoid, 
                        appointment.pid, 
                        appointment.apponum, 
                        appointment.appodate, 
                        appointment.qr_code,
                        patient.pname 
                        FROM 
                        appointment
                        JOIN 
                        patient
                        ON 
                        appointment.pid = patient.pid";
                //Execute the Query
                $res = $database->query($sql);

                //CHeck whether the Query is Executed of Not
                if($res==TRUE)
                {
                    // Count Rows to CHeck whether we have data in database or not
                    $count = mysqli_num_rows($res); // Function to get all the rows in database

                    //CHeck the num of rows
                    if($count>0)
                    {
                        //WE HAve data in database
                        while($rows=mysqli_fetch_assoc($res))
                        {
                            //Using While loop to get all the data from database.
                            //And while loop will run as long as we have data in database

                            //Get individual DAta
                            $appoid = $rows["appoid"];
                            $pid = $rows["pid"];
                            $apponum = $rows["apponum"];
                            $appodate = $rows["appodate"];
                            $qrcode = $rows["qr_code"];
                            $pname = $rows["pname"];

                            //Display the Values in our Table
                            ?>
                            
                            <tr>
                                <td><?php echo $appoid; ?></td>
                                <td><?php echo $pname; ?></td>
                                <td><?php echo $apponum; ?></td>
                                <td><?php echo $appodate; ?></td>
                                <td><?php echo $qrcode; ?></td>
                            </tr>

                            <?php

                        }
                    }
                    else
                    {
                        echo "<h2 class='white-text'> You have no current clients </h2>";
                        //We Do not Have Data in Database
                    }
                }
            }
        ?>
    </tbody>
    </table>
</div>
<?php 
include('partials/footer.php'); 

 ?>