
<?php
include("config/connection.php");

if(isset($_POST['query'])) {
    $search = $database->real_escape_string($_POST['query']);
    $sql = "SELECT pname FROM service WHERE pname LIKE '%$search%' LIMIT 5";
    $result = $database->query($sql);

    if($result->num_rows > 0) {
        // Fetch each matching patient name
        while($row = $result->fetch_assoc()) {
            // Display each result as a clickable option
            echo '<a href="#" class="list-group-item list-group-item-action">' . $row['pname'] . '</a>';
        }
    } else {
        echo '<p class="list-group-item">No results found</p>';
    }
}
?>