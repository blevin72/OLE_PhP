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
// Get values from the form
    $accountID = isset($_POST['accountID']) ? $_POST['accountID'] : 0;
    $theDivision = isset($_POST['the_division']) ? $_POST['the_division'] : 0;
    $hudTheme = isset($_POST['HUD_theme']) ? $_POST['HUD_theme'] : 0;
    $hudLocation = isset($_POST['HUD_location']) ? $_POST['HUD_location'] : 0;
    $languages = isset($_POST['languages']) ? $_POST['languages'] : 0;
    //$server = isset($_POST['server']) ? $_POST['server'] : 0;
    $cameraSensitivity = isset($_POST['camera_sensitivity']) ? (float)$_POST['camera_sensitivity'] : 0;
    $cameraSway = isset($_POST['camera_sway']) ? (float)$_POST['camera_sway'] : 0;
    $hudTransparency = isset($_POST['HUD_transparency']) ? (float)$_POST['HUD_transparency'] : 0;
    $gamertags = isset($_POST['gamertags']) ? (float)$_POST['gamertags'] : 0;
    $gore = isset($_POST['gore']) ? (float)$_POST['gore'] : 0;
    $gameTips = isset($_POST['game_tips']) ? (float)$_POST['game_tips'] : 0;

    //add $server below once it has been set up
    $updateSettingsQuery = "UPDATE settings_preferences
        SET the_division = '$theDivision',
            HUD_theme = '$hudTheme',
            HUD_location = '$hudLocation',
            languages = '$languages',
            camera_sensitivity = '$cameraSensitivity',
            camera_sway = '$cameraSway',
            HUD_transparency = '$hudTransparency',
            gamertags = '$gamertags',
            gore = '$gore',
            game_tips = '$gameTips'
        WHERE accountID = '$accountID'";

    $result = mysqli_query($con, $updateSettingsQuery);

    if ($result) {
        echo "0: Update successful"; // Success
    } else {
        echo "2: Update query failed. Error: " . mysqli_error($con); // Error code #2 = update query failed
    }

    mysqli_close($con);
}

else if($action == "get_settings")
{
    // Get audio settings based on accountID
    $accountID = isset($_GET['accountID']) ? $_GET['accountID'] : 0;

    //add servers to SELECT query
    $getPreferencesSettingsQuery = "SELECT the_division, HUD_theme, HUD_location, languages, camera_sensitivity, camera_sway, HUD_transparency, gamertags, gore, game_tips
    FROM settings_preferences 
    WHERE accountID = '$accountID'";

    $result = mysqli_query($con, $getPreferencesSettingsQuery);

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