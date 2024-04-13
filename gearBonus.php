<?php
include 'config.php';
$con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
//check if connection happened
if(mysqli_connect_errno()){
    echo "1: Connection failed"; //error code #1 connection failed
    exit();
}

$action = isset($_GET['action']) ? $_GET['action'] : '';
$characterID = isset($_GET['characterID']) ? $_GET['characterID'] : 0;   

//-----------------------------MELEE-----------------------------//
if($action == 'meleeQuery')
{
    $meleeQuery = "SELECT meleeModifier from gear_hands WHERE gearName = (SELECT equipped_hands FROM characters WHERE characterID = '$characterID')";
    $result = mysqli_query($con, $meleeQuery);
    $meleeData = mysqli_fetch_assoc($result);
    echo json_encode(array('meleeBonus' => $meleeData['meleeModifier']));
}

//-----------------------------PROTECTION-----------------------------//
if($action == 'protectionQuery')
{
    $protectionQuery = "SELECT 
                        f.protectionModifier AS feetProtection,
                        h.protectionModifier AS handsProtection,
                        hd.protectionModifier AS headProtection,
                        l.protectionModifier AS legsProtection,
                        t.protectionModifier AS torsoProtection
                        FROM 
                        characters c
                        LEFT JOIN 
                        gear_feet f ON c.equipped_feet = f.gearName
                        LEFT JOIN 
                        gear_hands h ON c.equipped_hands = h.gearName
                        LEFT JOIN 
                        gear_head hd ON c.equipped_head = hd.gearName
                        LEFT JOIN 
                        gear_legs l ON c.equipped_legs = l.gearName
                        LEFT JOIN 
                        gear_torso t ON c.equipped_torso = t.gearName
                        WHERE 
                        c.characterID = '$characterID'";

    $result = mysqli_query($con, $protectionQuery);

    // Fetch combined protection data
    $protectionData = mysqli_fetch_assoc($result);

    // Calculate total protection
    $protection = $protectionData['feetProtection'] +
    $protectionData['handsProtection'] +
    $protectionData['headProtection'] +
    $protectionData['legsProtection'] +
    $protectionData['torsoProtection'];

    // Echo out the result
    echo json_encode(array('protection' => $protection));
    //-----------------------------END PROTECTION-----------------------------//
    mysqli_close($con);
}

?>