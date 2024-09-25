<?php include("partials/header.php");?>

<?php

    //learn from w3schools.com

    // session_start();

    // if(isset($_SESSION["user"])){
    //     if(($_SESSION["user"])=="" or $_SESSION['usertype']!='a'){
    //         header("location: ../login.php");
    //     }

    // }else{
    //     header("location: ../login.php");
    // }
    

    //import database
    include("config/connection.php");

    
    ?>
    <div class="container">
        <div class="dash-body" style="margin-top: 15px">
            <table border="0" width="100%">
                        
                        <tr >
                            
                            <td class="nav-bar" >
                                
                                <form action="doctors.php" method="post" class="header-search">
        
                                    <input type="search" name="search" class="input-text header-searchbar" placeholder="Search Doctor name or Email" list="doctors">&nbsp;&nbsp;
                    
                                    
                               
                                    <input type="Submit" value="Search" class="login-btn btn-primary btn">
                                
                                </form>
                                
                            </td>
                            <td width="15%">
                                <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">
                                    Today's Date
                                </p>
                                <p class="heading-sub12" style="padding: 0;margin: 0;">
                                    <?php 
                                date_default_timezone_set('Asia/Kolkata');
        
                                $today = date('Y-m-d');
                                echo $today;


                                $patientrow = $database->query("select  * from  patient;");
                                $appointmentrow = $database->query("select  * from  appointment where appodate>='$today';");


                                ?>
                                </p>
                            </td>
                            <td width="10%">
                                <button  class="btn-label"  style="display: flex;justify-content: center;align-items: center;"><img src="img/svg/calendar.svg" width="100%"></button>
                            </td>
        
        
                        </tr>
                <tr>
                    <td colspan="3">
                        <table class="filter-container" style="border: none;" border="0">
                            <tr>
                                <td>
                                    <p style="font-size: 20px;font-weight:600;padding-left: 12px;">Status</p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div  class="dashboard-items"  style="padding:20px;margin:auto;width:95%;display: flex;">
                                        <div>
                                                <div class="h1-dashboard">
                                                    <?php    echo $patientrow->num_rows  ?>
                                                </div><br>
                                                <div class="h3-dashboard">
                                                    Patients &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                </div>
                                        </div>
                                                <div class="btn-icon-back dashboard-icons" style="background-image: url('img/icons/patients-hover.svg');"></div>
                                    </div>
                                </td>
                                <td colspan="2">
                                    <div  class="dashboard-items"  style="padding:20px;margin:auto;width:95%;display: flex; ">
                                        <div>
                                                <div class="h1-dashboard" >
                                                    <?php    echo $appointmentrow ->num_rows  ?>
                                                </div><br>
                                                <div class="h3-dashboard" >
                                                    NewBooking &nbsp;&nbsp;
                                                </div>
                                        </div>
                                                <div class="btn-icon-back dashboard-icons" style="margin-left: 0px;background-image: url('img/icons/book-hover.svg');"></div>
                                    </div>
                                </td>      
                            </tr>
                        </table>
                    </td>
                </tr>






                <tr>
                    <td colspan="3">
                    <table width="100%" border="0" class="dashbord-tables">
                            <tr>
                                <td>
                                    <p style="padding:10px;padding-left:48px;padding-bottom:0;font-size:23px;font-weight:700;color:var(--primarycolor);">
                                        Upcoming Appointments today
                                    </p>
                                </td>

                                <td>
                                    <p style="text-align:right;padding:10px;padding-right:48px;padding-bottom:0;font-size:23px;font-weight:700;color:var(--primarycolor);">
                                        Appointments  until Next <?php  
                                        echo date("l",strtotime("+1 week"));
                                        ?>
                                    </p>

                                </td>
                            </tr>
                            <tr>
                                <td width="50%">
                                        <div class="abc scroll" style="height: 800px;">
                                        <table width="85%" class="sub-table scrolldown" border="0">
                                        <thead>
                                            <tr>    
                                                <th class="table-headin">
                                                        
                                                    Appointment number
                                                    
                                                </th>
                                                <th class="table-headin">
                                                    Patient name
                                                </th>
                                                <th class="table-headin">
                                                    
                                                
                                                    Appointment Date
                                                    
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        
                                            <?php
                                            $nextweek=date("Y-m-d",strtotime("+1 week"));
                                            $sqlmain= "SELECT 
                                                        appointment.appoid,
                                                        appointment.pid,
                                                        appointment.apponum,
                                                        appointment.appodate,
                                                        patient.pname
                                                    FROM 
                                                        appointment
                                                    INNER JOIN 
                                                        patient
                                                    ON 
                                                        appointment.pid = patient.pid
                                                    WHERE 
                                                        appointment.appodate = '$today'
                                                    ORDER BY 
                                                        appointment.appodate DESC";

                                                $result= $database->query($sqlmain);
                
                                                if($result->num_rows==0){
                                                    echo '<tr>
                                                    <td>
                                                    <br><br><br><br>
                                                    <center>
                                                    <img src="img/svg/notfound.svg" width="25%">
                                                    
                                                    <br>
                                                    <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">We couldnt find anything related to your keywords !</p>
                                                    <a class="non-style-link" href="appointment.php"><button  class="login-btn btn-primary-soft btn"  style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp; Show all Appointments &nbsp;</font></button>
                                                    </a>
                                                    </center>
                                                    <br><br><br><br>
                                                    </td>
                                                    </tr>';
                                                    
                                                }
                                                else{
                                                for ($x = 0; $x < $result->num_rows; $x++) {
                                                    $row = $result->fetch_assoc();
                                                    
                                                    // Retrieve the values from the appointment table
                                                    $appoid = $row["appoid"];
                                                    $pid = $row["pid"];
                                                    $apponum = $row["apponum"];
                                                    $appodate = $row["appodate"];
                                                    $pname=$row["pname"];
                                                    echo '<tr>


                                                        <td style="text-align:center;font-size:23px;font-weight:500; color: var(--btnnicetext);padding:20px;">
                                                            '.$apponum.'
                                                            
                                                        </td>

                                                        <td style="font-weight:600;"> &nbsp;'.
                                                        
                                                        substr($pname,0,25)
                                                        .'</td >
                                                        <td style="font-weight:600;"> &nbsp;'
                                                        .$appodate.
                                                        
                                                        '</td >
                                                           

                                                    </tr>';
                                                    
                                                }
                                            }
                                                 
                                            ?>
                 
                                            </tbody>
                
                                        </table>
                                </td>
                                <td width="50%">
                                        <div class="abc scroll" style="height: 800px;">
                                        <table width="85%" class="sub-table scrolldown" border="0">
                                        <thead>
                                            <tr>    
                                                <th class="table-headin">
                                                        
                                                    Appointment number
                                                    
                                                </th>
                                                <th class="table-headin">
                                                    Patient name
                                                </th>
                                                <th class="table-headin">
                                                    
                                                
                                                    Appointment Date
                                                    
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                            
                                            <!-- query for the appointments in the next 7 days, excluding today -->
                                             
                                            <?php
                                            $nextweek=date("Y-m-d",strtotime("+1 week"));
                                            $sqlmain= "SELECT 
                                                        appointment.appoid,
                                                        appointment.pid,
                                                        appointment.apponum,
                                                        appointment.appodate,
                                                        patient.pname
                                                    FROM 
                                                        appointment
                                                    INNER JOIN 
                                                        patient
                                                    ON 
                                                        appointment.pid = patient.pid
                                                    WHERE 
                                                        appointment.appodate > '$today'
                                                    AND 
                                                        appointment.appodate <= '$nextweek'
                                                    ORDER BY 
                                                        appointment.appodate ASC";

                                                $result= $database->query($sqlmain);
                
                                                if($result->num_rows==0){
                                                    echo '<tr>
                                                    <td >
                                                    <br><br><br><br>
                                                    <center>
                                                    <img src="img/svg/notfound.svg" width="25%">
                                                    
                                                    <br>
                                                    <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">No appointments for the next 7 days!</p>
                                                    <a class="non-style-link" href="appointment.php"><button  class="login-btn btn-primary-soft btn"  style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp; Show all Appointments &nbsp;</font></button>
                                                    </a>
                                                    </center>
                                                    <br><br><br><br>
                                                    </td>
                                                    </tr>';
                                                    
                                                }
                                                else{
                                                for ($x = 0; $x < $result->num_rows; $x++) {
                                                    $row = $result->fetch_assoc();
                                                    
                                                    // Retrieve the values from the appointment table
                                                    $appoid = $row["appoid"];
                                                    $pid = $row["pid"];
                                                    $apponum = $row["apponum"];
                                                    $appodate = $row["appodate"];
                                                    $pname=$row["pname"];
                                                    echo '<tr>


                                                        <td style="text-align:center;font-size:23px;font-weight:500; color: var(--btnnicetext);padding:20px;">
                                                            '.$apponum.'
                                                            
                                                        </td>

                                                        <td style="font-weight:600;"> &nbsp;'.
                                                        
                                                        substr($pname,0,25)
                                                        .'</td >
                                                        <td style="font-weight:600;"> &nbsp;'
                                                        .$appodate.
                                                        
                                                        '</td >
                                                           

                                                    </tr>';
                                                    
                                                }
                                            }
                                                 
                                            ?>

                                        </tbody>
                
                                        </table>
                                </td>
                            </tr>
                        </table>
                        </td>
                </tr>
            </table>
        </div>
    </div>


<?php include("partials/footer.php");?>