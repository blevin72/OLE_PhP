<?php
include 'config.php';

$con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
// Check if the connection happened
if (mysqli_connect_errno()) {
    echo "1: Connection failed"; // Error code #1 = connection failed
    exit();
}

$action = isset($_GET['action']) ? $_GET['action'] : '';

if($action == "insert")
{
    $characterID = isset($_POST['characterID']) ? $_POST['characterID'] : 0;
    $missionType = isset($_POST['mission_type']) ? $_POST['mission_type'] : 0;
    $commencement = isset($_POST['commencement']) ? $_POST['commencement'] : 0;
    $rations = isset($_POST['rations']) ? $_POST['rations'] : 0;
    $bandages = isset($_POST['bandages']) ? $_POST['bandages'] : 0;
    $lockpicks = isset($_POST['lock_picks']) ? $_POST['lock_picks'] : 0;
    $medkits = isset($_POST['med_kits']) ? $_POST['med_kits'] : 0;
    $water = isset($_POST['water']) ? $_POST['water'] : 0;
    $ammoBoxesOne = isset($_POST['ammo_boxes_one']) ? $_POST['ammo_boxes_one'] : 0;
    $ammoBoxesTwo = isset($_POST['ammo_boxes_two']) ? $_POST['ammo_boxes_two'] : 0;
    $ammoBoxesThree = isset($_POST['ammo_boxes_three']) ? $_POST['ammo_boxes_three'] : 0;
    $ammoTypeOne = isset($_POST['ammo_type_one']) ? $_POST['ammo_type_one'] : 0;
    $ammoTypeTwo = isset($_POST['ammo_type_two']) ? $_POST['ammo_type_two'] : 0;
    $ammoTypeThree = isset($_POST['ammo_type_three']) ? $_POST['ammo_type_three'] : 0;
    $requestMessage = isset($_POST['request_message']) ? $_POST['request_message'] : 0;

    $query = "INSERT INTO radio_requests (characterID, outpostID, mission_type, commencement, rations, bandages, lock_picks, med_kits, water, ammo_boxes_one, ammo_boxes_two, 
            ammo_boxes_three, ammo_type_one, ammo_type_two, ammo_type_three, request_message)
             VALUES ('$characterID', (SELECT outpostID FROM characters WHERE characterID = '$characterID'), '$missionType', '$commencement', '$rations', '$bandages', '$lockpicks', '$medkits', '$water', '$ammoBoxesOne', '$ammoBoxesTwo',
            '$ammoBoxesThree', '$ammoTypeOne', '$ammoTypeTwo', '$ammoTypeThree', '$requestMessage')";

    $insert = mysqli_query($con, $query);

    if ($insert) {
        echo "Insertion successful";
    } else {
        echo "Error: " . mysqli_error($con);
    }

    mysqli_close($con);
}
if($action == "select")
{
    $query = "SELECT radio_requests.distressCall_ID,
            (SELECT outpost_name FROM outpost WHERE outpostID = radio_requests.outpostID) AS outpost_name,
            (SELECT outpost_ranking FROM outpost WHERE outpostID = radio_requests.outpostID) AS outpost_ranking,
            radio_requests.mission_type,
            radio_requests.commencement
            FROM radio_requests";

    $result = mysqli_query($con, $query);

    if($result)
    {
        $response = array();
        while($row = mysqli_fetch_assoc($result))
        {
            $response[] = $row;
        }

        // Set response headers to indicate JSON content
        header('Content-Type: application/json');
        
        // Output JSON response
        echo json_encode($response);
    }
    else 
    {
        echo "2: Query failed. Error: " . mysqli_error($con); // Error code #2 = query failed
    }
    mysqli_close($con);
}
else 
{
    echo "Invalid action";
}
?>