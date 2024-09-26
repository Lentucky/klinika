
<?php
include("config/connection.php");

if (isset($_GET['query'])) {
    $query = $database->real_escape_string($_GET['query']);
    
    // Fetch patient name and pid based on user input
    $sql = "SELECT pid, pname FROM patient WHERE pname LIKE '%$query%' LIMIT 10";
    $result = $database->query($sql);
    
    $response = array();
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $response[] = array("pid" => $row['pid'], "pname" => $row['pname']);
        }
    }
    
    // Return JSON response
    echo json_encode($response);
}
?>