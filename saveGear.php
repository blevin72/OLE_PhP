<?php
include 'config.php';
$con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
//check if connection happened
if(mysqli_connect_errno()){
    echo "1: Connection failed"; //error code #1 connection failed
    exit();
}

$action = isset($_GET['action']) ? $_GET['action'] : '';

if($action == 'update')
{
    $characterID = isset($_POST['characterID']) ? $_POST['characterID'] : 0;
    $gearHead = isset($_POST['equipped_head']) ? $_POST['equipped_head'] : 0;
    $gearHands = isset($_POST['equipped_hands']) ? $_POST['equipped_hands'] : 0;
    $gearShoulder = isset($_POST['equipped_flashlights']) ? $_POST['equipped_flashlights'] : 0;
    $gearTorso = isset($_POST['equipped_torso']) ? $_POST['equipped_torso'] : 0;
    $gearHolster = isset($_POST['equipped_holster']) ? $_POST['equipped_holster'] : 0;
    $gearLegs = isset($_POST['equipped_legs']) ? $_POST['equipped_legs'] : 0;
    $gearFeet = isset($_POST['equipped_feet']) ? $_POST['equipped_feet'] : 0;

    $updateGearQuery = "UPDATE characters
        SET equipped_head = '$gearHead',
            equipped_hands = '$gearHands',
            equipped_flashlights = '$gearShoulder',
            equipped_torso = '$gearTorso',
            equipped_holster = '$gearHolster',
            equipped_legs = '$gearLegs',
            equipped_feet = '$gearFeet'
        WHERE characterID = '$characterID'";

    $result = mysqli_query($con, $updateGearQuery);

    if ($result) {
        echo "0: Update successful"; // Success
    } else {
        echo "2: Update query failed. Error: " . mysqli_error($con); // Error code #2 = update query failed
    }

    mysqli_close($con);
}
?>