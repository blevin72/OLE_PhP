<?php
include 'config.php';
$con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
// Check if the connection happened
if (mysqli_connect_errno()) {
    echo "1: Connection failed"; // Error code #1 = connection failed
    exit();
}

$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($action == "update") 
{
    // Get values from the form
    $accountID = isset($_POST['accountID']) ? $_POST['accountID'] : 0;
    $masterVolume = isset($_POST['master_volume']) ? (float)$_POST['master_volume'] : 0;
    $musicVolume = isset($_POST['music_volume']) ? (float)$_POST['music_volume'] : 0;
    $soundEffects = isset($_POST['sound_effects']) ? (float)$_POST['sound_effects'] : 0;
    $dialogVoice = isset($_POST['dialog_voice']) ? (float)$_POST['dialog_voice'] : 0;
    $proximityChat = isset($_POST['proximity_chat']) ? (int)$_POST['proximity_chat'] : 0;
    $subtitles = isset($_POST['subtitles']) ? (int)$_POST['subtitles'] : 0;
    $uiSoundFX = isset($_POST['ui_sound_fx']) ? (int)$_POST['ui_sound_fx'] : 0;

    // Update settings using the original format
    $updateSettingsQuery = "UPDATE settings_audio
        SET master_volume = '$masterVolume',
            music_volume = '$musicVolume',
            sound_effects = '$soundEffects',
            dialog_voice = '$dialogVoice',
            proximity_chat = '$proximityChat',
            subtitles = '$subtitles',
            ui_sound_fx = '$uiSoundFX'
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

    $getSettingsQuery = "SELECT master_volume, music_volume, sound_effects, dialog_voice, proximity_chat, subtitles, ui_sound_fx 
    FROM settings_audio 
    WHERE accountID = '$accountID'";

    $result = mysqli_query($con, $getSettingsQuery);

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
