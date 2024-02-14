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
    $resolution = isset($_POST['resolution']) ? $_POST['resolution'] : 0;
    $graphics = isset($_POST['graphics']) ? $_POST['graphics'] : 0;
    $textures = isset($_POST['textures']) ? $_POST['textures'] : 0;
    $shaders = isset($_POST['shaders']) ? $_POST['shaders'] : 0;
    $screen = isset($_POST['screen']) ? $_POST['screen'] : 0;
    $aspectRatios = isset($_POST['aspect_ratios']) ? $_POST['aspect_ratios'] : 0;
    $contrast = isset($_POST['contrast']) ? (float)$_POST['contrast'] : 0;
    $brightness = isset($_POST['brightness']) ? (float)$_POST['brightness'] : 0;
    $shadows = isset($_POST['shadows']) ? (float)$_POST['shadows'] : 0;
    $antiAliasing = isset($_POST['anti_aliasing']) ? (float)$_POST['anti_aliasing'] : 0;
    $colorBlind = isset($_POST['color_blind']) ? (float)$_POST['color_blind'] : 0;

    $updateSettingsQuery = "UPDATE settings_visual
        SET resolution = '$resolution',
            graphics = '$graphics',
            textures = '$textures',
            shaders = '$shaders',
            screen = '$screen',
            aspect_ratios = '$aspectRatios',
            contrast = '$contrast',
            brightness = '$brightness',
            shadows = '$shadows',
            anti_aliasing = '$antiAliasing',
            color_blind = '$colorBlind'
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

    $getVisualSettingsQuery = "SELECT resolution, graphics, textures, shaders, screen, aspect_ratios, contrast, brightness, shadows, anti_aliasing, color_blind 
    FROM settings_visual 
    WHERE accountID = '$accountID'";

    $result = mysqli_query($con, $getVisualSettingsQuery);

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