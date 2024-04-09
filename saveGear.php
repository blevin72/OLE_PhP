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
else if($action == "getWeight")
{
    $characterID = isset($_GET['characterID']) ? $_GET['characterID'] : 0;
    
    $feetWeightQuery = "SELECT gearWeight FROM gear_feet WHERE gearName =  (SELECT equipped_feet FROM characters WHERE characterID = '$characterID');";
    $shoulderWeightQuery = "SELECT gearWeight FROM gear_flashlights WHERE gearName =  (SELECT equipped_flashlights FROM characters WHERE characterID = '$characterID');";
    $handWeightQuery = "SELECT gearWeight FROM gear_hands WHERE gearName =  (SELECT equipped_hands FROM characters WHERE characterID = '$characterID');";
    $headWeightQuery = "SELECT gearWeight FROM gear_head WHERE gearName =  (SELECT equipped_head FROM characters WHERE characterID = '$characterID');";
    $holsterWeightQuery = "SELECT gearWeight FROM gear_holster WHERE gearName =  (SELECT equipped_holster FROM characters WHERE characterID = '$characterID');";
    $legsWeightQuery = "SELECT gearWeight FROM gear_legs WHERE gearName =  (SELECT equipped_legs FROM characters WHERE characterID = '$characterID');";
    $torsoWeightQuery = "SELECT gearWeight FROM gear_torso WHERE gearName =  (SELECT equipped_torso FROM characters WHERE characterID = '$characterID');";

    // Execute queries
    $feetWeightResult = mysqli_query($con, $feetWeightQuery);
    $shoulderWeightResult = mysqli_query($con, $shoulderWeightQuery);
    $handWeightResult = mysqli_query($con, $handWeightQuery);
    $headWeightResult = mysqli_query($con, $headWeightQuery);
    $holsterWeightResult = mysqli_query($con, $holsterWeightQuery);
    $legsWeightResult = mysqli_query($con, $legsWeightQuery);
    $torsoWeightResult = mysqli_query($con, $torsoWeightQuery);

    // Fetch weights
    $feetWeight = mysqli_fetch_assoc($feetWeightResult)['gearWeight'];
    $shoulderWeight = mysqli_fetch_assoc($shoulderWeightResult)['gearWeight'];
    $handWeight = mysqli_fetch_assoc($handWeightResult)['gearWeight'];
    $headWeight = mysqli_fetch_assoc($headWeightResult)['gearWeight'];
    $holsterWeight = mysqli_fetch_assoc($holsterWeightResult)['gearWeight'];
    $legsWeight = mysqli_fetch_assoc($legsWeightResult)['gearWeight'];
    $torsoWeight = mysqli_fetch_assoc($torsoWeightResult)['gearWeight'];

    $totalWeight = $feetWeight + $shoulderWeight + $handWeight + $headWeight + $holsterWeight + $legsWeight + $torsoWeight;

    // Echo out the result
    echo json_encode(array('totalWeight' => $totalWeight));

    mysqli_close($con);
}
?>