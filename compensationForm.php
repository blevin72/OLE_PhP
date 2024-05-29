<?php
include 'config.php';
$con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
// Check if the connection happened
if (mysqli_connect_errno()) 
{
    echo "1: Connection failed"; // Error code #1 = connection failed
    exit();
}

$action = isset($_GET['action']) ? $_GET['action'] : '';

if($action  == "select")
{
    $distressCall_ID = isset($_GET['distressCall_ID']) ? $_GET['distressCall_ID'] : 0;

    $query = "SELECT rations, bandages, lock_picks, med_kits, water, ammo_boxes_one, ammo_boxes_two, ammo_boxes_three, ammo_type_one, ammo_type_two, ammo_type_three, request_message
    FROM radio_requests WHERE distressCall_ID = $distressCall_ID";

    $result = mysqli_query($con, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        echo json_encode($row); // Output settings as JSON
    } else {
        echo "2: Query failed. Error: " . mysqli_error($con); // Error code #2 = query failed
    }

    mysqli_close($con);
}
else 
{
    echo "Invalid action";
}
?>