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
//get values from the form
    $accountID = isset($_POST['accountID']) ? $_POST['accountID'] : 0;
    $friendRequests = isset($_POST['friend_requests']) ? (float)$_POST['friend_requests'] : 0;
    $outpostRequests = isset($_POST['outpost_requests']) ? (float)$_POST['outpost_requests'] : 0;
    $assistanceRequests = isset($_POST['assistance_requests']) ? (float)$_POST['assistance_requests'] : 0;
    $messagesEveryone = isset($_POST['messages_everyone']) ? (float)$_POST['messages_everyone'] : 0;
    $messagesFriends = isset($_POST['messages_friends']) ? (float)$_POST['messages_friends'] : 0;
    $messagesOutpost = isset($_POST['messages_outpost']) ? (float)$_POST['messages_outpost'] : 0;
    $emailsAll = isset($_POST['emails_all']) ? (float)$_POST['emails_all'] : 0;
    $emailsSeasonEvents = isset($_POST['emails_seasonEvents']) ? (float)$_POST['emails_seasonEvents'] : 0;
    $emailsSpecialEvents = isset($_POST['emails_specialEvents']) ? (float)$_POST['emails_specialEvents'] : 0;
    $emailsNewsletters = isset($_POST['emails_newsletters']) ? (float)$_POST['emails_newsletters'] : 0;

    //add $server below
    $updateSettingsQuery = "UPDATE settings_account
        SET friend_requests = '$friendRequests',
            outpost_requests = '$outpostRequests',
            assistance_requests = '$assistanceRequests',
            messages_everyone = '$messagesEveryone',
            messages_friends = '$messagesFriends',
            messages_outpost = '$messagesOutpost',
            emails_all = '$emailsAll',
            emails_seasonEvents = '$emailsSeasonEvents',
            emails_specialEvents = '$emailsSpecialEvents',
            emails_newsletters = '$emailsNewsletters'
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
    $getAccountSettingsQuery = "SELECT friend_requests, outpost_requests, assistance_requests, messages_everyone, messages_friends, messages_outpost, emails_all, emails_seasonEvents, emails_specialEvents, emails_newsletters
    FROM settings_account
    WHERE accountID = '$accountID'";

    $result = mysqli_query($con, $getAccountSettingsQuery);

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