<?php
include 'config.php';

$con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
// Check if the connection happened
if(mysqli_connect_errno()) {
    echo "1: Connection failed"; // Error code #1 = connection failed
    exit();
}

$accountID = mysqli_real_escape_string($con, $_POST['accountID']);
$characterName = mysqli_real_escape_string($con, $_POST['character_name']);
$classID = mysqli_real_escape_string($con, $_POST['classID']);
$username = mysqli_real_escape_string($con, $_POST['username']);
$email = mysqli_real_escape_string($con, $_POST['email']); 
$password = mysqli_real_escape_string($con, $_POST['password']);

// Check if username exists
$usernamecheckquery = "SELECT username FROM accounts WHERE username = '$username'";
$usernamecheck = mysqli_query($con, $usernamecheckquery);

if(!$usernamecheck) {
    echo "2: Username check query failed: " . mysqli_error($con);
    exit();
}

if(mysqli_num_rows($usernamecheck) > 0) {
    echo "3: Name already exists";
    exit();
}

$salt = "\$5\$rounds=5000\$" . "steamedhams" . $username . "\$";
$hash = crypt($password, $salt); // You need to have $password defined somewhere

$insertuserquery = "INSERT INTO accounts (username, hash, salt, email, `account creation date`, status, email_subscription)
VALUES ('$username', '$hash', '$salt', '$email', CURDATE(), 'active', 1)";
$insertuser = mysqli_query($con, $insertuserquery);

if(!$insertuser) {
    echo "4: Insert player query failed: " . mysqli_error($con);
    exit();
}

echo "0"; // Successful registration

//creating rows for all settings tables using the newly generated ID from the accounts table
$newAccountID = mysqli_insert_id($con); //retrieving the new accountID

$insertSettings_AccountQuery = "INSERT INTO settings_account (accountID) VALUES ('$newAccountID')";
mysqli_query($con, $insertSettings_AccountQuery); //calling insertSettings_AccountQuery

$insertSettings_AudioQuery = "INSERT INTO settings_audio (accountID) VALUES ('$newAccountID')";
mysqli_query($con, $insertSettings_AudioQuery); //calling insertSettings_AudioQuery

$insertSettings_GameplayQuery = "INSERT INTO settings_gameplay (accountID) VALUES ('$newAccountID')";
mysqli_query($con, $insertSettings_GameplayQuery);

$insertSettings_PreferencesQuery = "INSERT INTO settings_preferences (accountID) VALUES ('$newAccountID')";
mysqli_query($con, $insertSettings_PreferencesQuery);

$insertSettings_SocialQuery = "INSERT INTO settings_social (accountID) VALUES ('$newAccountID')";
mysqli_query($con, $insertSettings_SocialQuery);

$insertSettings_VisualQuery = "INSERT INTO settings_visual (accountID) VALUES ('$newAccountID')";
mysqli_query($con, $insertSettings_VisualQuery);

mysqli_close($con); //closing the connection to the database

?>
