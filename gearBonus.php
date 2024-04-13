<?php
include 'config.php';
$con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
//check if connection happened
if(mysqli_connect_errno()){
    echo "1: Connection failed"; //error code #1 connection failed
    exit();
}

$action = isset($_GET['action']) ? $_GET['action'] : '';

if($action == 'select')
{
    $characterID = isset($_GET['characterID']) ? $_GET['characterID'] : 0;
    
    //-----------------------------Protection-----------------------------//
    //Retrieve protection modifier value from each table
    $feetProtectionQuery = "SELECT protectionModifier FROM gear_feet WHERE gearName = (SELECT equipped_feet FROM characters WHERE characterID = '$characterID');";
    $handsProtectionQuery = "SELECT protectionModifier FROM gear_hands WHERE gearName = (SELECT equipped_hands FROM characters WHERE characterID = '$characterID');";
    $headProtectionQuery = "SELECT protectionModifier FROM gear_head WHERE gearName = (SELECT equipped_head FROM characters WHERE characterID = '$characterID');";
    $legsProtectionQuery = "SELECT protectionModifier FROM gear_legs WHERE gearName = (SELECT equipped_legs FROM characters WHERE characterID = '$characterID');";
    $torsoProtectionQuery = "SELECT protectionModifier FROM gear_torso WHERE gearName = (SELECT equipped_torso FROM characters WHERE characterID = '$characterID');";

    //Execute queries
    $feetProtectionResult = mysqli_query($con,$feetProtectionQuery);
    $handsProtectionResult = mysqli_query($con,$handsProtectionQuery);
    $headProtectionResult = mysqli_query($con,$headProtectionQuery);
    $legsProtectionResult = mysqli_query($con,$legsProtectionQuery);
    $torsoProtectionResult = mysqli_query($con,$torsoProtectionQuery);

    //Fetch Protection
    $feetProtection = mysqli_fetch_assoc($feetProtectionResult)['protectionModifier'];
    $handProtection = mysqli_fetch_assoc($handsProtectionResult)['protectionModifier'];
    $headProtection = mysqli_fetch_assoc($headProtectionResult)['protectionModifier'];
    $legsProtection = mysqli_fetch_assoc($legsProtectionResult)['protectionModifier'];
    $torsoProtection = mysqli_fetch_assoc($torsoProtectionResult)['protectionModifier'];

    $protection = $feetProtection + $handProtection + $headProtection + $legsProtection + $torsoProtection;

    // Echo out the result
    echo json_encode(array('protection' => $protection));
    //-----------------------------End Protection-----------------------------//


    mysqli_close($con);
}

?>