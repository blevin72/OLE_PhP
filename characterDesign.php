<?php
include 'config.php';
$con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Check if the connection happened
if (mysqli_connect_errno()) {
    echo "1: Connection failed"; // Error code #1 = connection failed
    exit();
}

$action = isset($_GET['action']) ? $_GET['action'] : '';

if($action == "update")
{
    //Get values from the form
    $characterID = isset($_POST['characterID']) ? $_POST['characterID'] : 0;
    $skinType = isset($_POST['skin_type']) ? $_POST['skin_type'] : 0;
    $skinTone = isset($_POST['skin_tone']) ? $_POST['skin_tone'] : 0;
    $hairType = isset($_POST['hair_type']) ? $_POST['hair_type'] : 0;
    $hairColor = isset($_POST['hair_color']) ? $_POST['hair_color'] : 0;
    $beardType = isset($_POST['beard_type']) ? $_POST['beard_type'] : 0;
    $beardColor = isset($_POST['beard_color']) ? $_POST['beard_color'] : 0;
    $hatType = isset($_POST['hat_type']) ? $_POST['hat_type'] : 0;
    $hatColor = isset($_POST['hat_color']) ? $_POST['hat_color'] : 0;
    $shirtType = isset($_POST['shirt_type']) ? $_POST['shirt_type'] : 0;
    $shirtColor = isset($_POST['shirt_color']) ? $_POST['shirt_color'] : 0;
    $outerwearType = isset($_POST['outerwear_type']) ? $_POST['outerwear_type'] : 0;
    $outerwearColor = isset($_POST['outerwear_color']) ? $_POST['outerwear_color'] : 0;
    $pantsType = isset($_POST['pants_type']) ? $_POST['pants_type'] : 0;
    $pantsColor = isset($_POST['pants_color']) ? $_POST['pants_color'] : 0;
    $shoesType = isset($_POST['shoes_type']) ? $_POST['shoes_type'] : 0;
    $shoesColor = isset($_POST['shoes_color']) ? $_POST['shoes_color'] : 0;
    $glasses = isset($_POST['glasses']) ? $_POST['glasses'] : 0;
    $glassesColor = isset($_POST['glasses_color']) ? $_POST['glasses_color'] : 0;
    $backpackColor = $_POST['backpack_color'];

    $updateCharacterDesignQuery = "UPDATE character_details
        SET skin_type = '$skinType',
            skin_tone = '$skinTone',
            hair_type = '$hairType',
            hair_color = '$hairColor',
            beard_type = '$beardType',
            beard_color = '$beardColor',
            hat_type = '$hatType',
            hat_color = '$hatColor',
            shirt_type = '$shirtType',
            shirt_color = '$shirtColor',
            outerwear_type = '$outerwearType',
            outerwear_color = '$outerwearColor',
            pants_type = '$pantsType',
            pants_color = '$pantsColor',
            shoes_type = '$shoesType',
            shoes_color = '$shoesColor',
            glasses = '$glasses',
            glasses_color = '$glassesColor',
            backpack_color = '$backpackColor'
        WHERE characterID = '$characterID'";

        $result = mysqli_query($con, $updateCharacterDesignQuery);

        if ($result) {
            echo "0: Update successful"; // Success
        } else {
            echo "2: Update query failed. Error: " . mysqli_error($con); // Error code #2 = update query failed
        }

    mysqli_close($con);
}


?>