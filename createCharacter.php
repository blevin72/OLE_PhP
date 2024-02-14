<?php
include 'config.php';
$con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Check if the connection happened
if (mysqli_connect_errno()) {
    echo "1: Connection failed"; // Error code #1 = connection failed
    exit();
}

$accountID = $_POST['accountID'];
$characterName = $_POST['character_name'];
$classID = $_POST['classID'];

$insertCharacterQuery = "INSERT INTO characters (accountID, character_name, classID)
VALUES ('$accountID', '$characterName', '$classID')";
$insertCharacter = mysqli_query($con, $insertCharacterQuery);

if(!$insertCharacter) {
    echo "4: Insert character query failed: " . mysqli_error($con);
    exit();
}

echo "0"; // Successfuly made character
mysqli_close($con); //closing the connection to the database
?>