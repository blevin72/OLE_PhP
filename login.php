<?php
include 'config.php';
$con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Check if the connection happened
if(mysqli_connect_errno()) {
    echo "1: Connection failed"; // Error code #1 = connection failed
    exit();
}

//check if the request is to logout
if(isset($_POST["logout"]) && $_POST["logout"] == true)
{
    echo "8: logout successful";
    exit();
}

$email = mysqli_real_escape_string($con, $_POST["email"]);
$emailclean = filter_var($email, FILTER_SANITIZE_EMAIL, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
$password = $_POST["password"];

// Check if email exists
$emailCheckQuery = "SELECT email, salt, hash FROM accounts WHERE email = '$emailclean'";
$emailCheck = mysqli_query($con, $emailCheckQuery);

if(!$emailCheck) {
    echo "2: Email check query failed: " . mysqli_error($con);
    exit();
}

if(mysqli_num_rows($emailCheck) != 1) {
    echo "5: Either no user with email, or more than one"; // Error code #5 - number of emails matching != 1
    exit();
}

// Get login info from query
$existingInfo = mysqli_fetch_assoc($emailCheck);
$salt = $existingInfo["salt"];
$hash = $existingInfo["hash"];

$accountIDQuery = "SELECT id FROM accounts WHERE email = '$emailclean'";
$accountIDResult = mysqli_query($con, $accountIDQuery);

if (!$accountIDResult) {
    echo "3: AccountID query failed: " . mysqli_error($con);
    exit();
}

if (mysqli_num_rows($accountIDResult) != 1) {
    echo "4: Error retrieving accountID";
    exit();
}

$accountIDRow = mysqli_fetch_assoc($accountIDResult);
$accountID = $accountIDRow["id"];

$loginhash = crypt($password, $salt);
if($hash != $loginhash)
{
    echo "6: Incorrect Password"; //error code #6 - password does not hash to match table
    exit();
}

$insertuserquery = "UPDATE accounts SET `last login date` = CURRENT_TIMESTAMP()
WHERE email = '$emailclean'";

$result = mysqli_query($con, $insertuserquery);

mysqli_close($con);

echo "0:$accountID"; //login successful

?>
