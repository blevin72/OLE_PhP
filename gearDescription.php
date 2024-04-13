<?php
include 'config.php';
$con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
//check if connection happened
if(mysqli_connect_errno()){
    echo "1: Connection failed"; //error code #1 connection failed
    exit();
}

$action = isset($_GET['action']) ? $_GET['action'] : '';

if($action == 'fetch_details')
{
    $gearName = isset($_GET['gearName']) ? $_GET['gearName'] : 0;
    $itemName = isset($_GET['itemName']) ? $_GET['itemName'] : 0;

    // Check gear type to determine the appropriate query
    $gearTypeName = isset($_GET['gearTypeName']) ? $_GET['gearTypeName'] : '';

    // Initialize query variables
    $gearQuery = "";

    if($gearTypeName == "Torso")
    {
        //$gearQuery = "";
        $gearQuery = "SELECT gearName, gearImage, gearWeight, protectionModifier, speedModifier, rarity, `durability`
        FROM gear_torso
        WHERE gearName = '$gearName'";
    
        $result = mysqli_query($con,$gearQuery);
    }
    else if($gearTypeName == "Head")
    {
        //$gearQuery = "";
        $gearQuery = "SELECT gearName, gearImage, gearWeight, protectionModifier, immunityModifier, rarity, `durability`
        FROM gear_head
        WHERE gearName = '$gearName'";

        $result = mysqli_query($con,$gearQuery);
    }
    else if($gearTypeName == "Legs")
    {
        $gearQuery = "SELECT gearName, gearImage, gearWeight, protectionModifier, speedModifier, rarity, `durability`
        FROM gear_legs
        WHERE gearName = '$gearName'";

        $result = mysqli_query($con,$gearQuery);
    }
    else if($gearTypeName == "Hands")
    {
        $gearQuery = "SELECT gearName, gearImage, gearWeight, protectionModifier, meleeModifier, craftModifier, rarity, `durability`
        FROM gear_hands
        WHERE gearName = '$gearName'";

        $result = mysqli_query($con,$gearQuery);
    }
    else if($gearTypeName == "Shoulder")
    {
        $gearQuery = "SELECT gearname, gearImage, gearWeight, illuminateFOV, batteryLifeMin, rarity
        FROM gear_flashlights
        WHERE gearName = '$gearName'";

        $result = mysqli_query($con,$gearQuery);
    }
    else if($gearTypeName == "Feet")
    {
        $gearQuery = "SELECT gearName, gearImage, gearWeight, protectionModifier, agroModifier, speedModifier, staminaModifier, rarity, `durability`
        FROM gear_feet
        WHERE gearName = '$gearName'";

        $result = mysqli_query($con,$gearQuery);
    }
    else if($gearTypeName == "Item_Slot")
    {
        $gearQuery = "SELECT itemName, itemImage, itemDescription, itemProperties_1, itemProperties_2, rarity
        FROM items_consumables
        WHERE itemName = '$gearName'";

        $result = mysqli_query($con,$gearQuery);
    }
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        echo json_encode($row); // Output settings as JSON
    } 
    else 
    {
        echo "2: Query failed. Error: " . mysqli_error($con); // Error code #2 = query failed
    }

    mysqli_close($con);
}
else
{
    echo "Invalid Action";
}

?>