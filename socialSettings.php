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
    $accountID = isset($_POST['accountID']) ? $_POST['accountID'] : 0;
    $messaging = isset($_POST['messaging']) ? $_POST['messaging'] : 0;
    $chatProfanity = isset($_POST['chat_profanity']) ? (float)$_POST['chat_profanity'] : 0;
    $partyChat = isset($_POST['party_chat']) ? (float)$_POST['party_chat'] : 0;
    $notifications = isset($_POST['notifications']) ? (float)$_POST['notifications'] : 0;
    $onlineStatus = isset($_POST['online_status']) ? (float)$_POST['online_status'] : 0;

    $updateSettingsQuery = "UPDATE settings_social
        SET messaging = '$messaging',
            chat_profanity = '$chatProfanity',
            party_chat = '$partyChat',
            notifications = '$notifications',
            online_status = '$onlineStatus'
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

    $getSocialSettingsQuery = "SELECT messaging, chat_profanity, party_chat, notifications, online_status 
    FROM settings_social
    WHERE accountID = '$accountID'";

    $result = mysqli_query($con, $getSocialSettingsQuery);

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