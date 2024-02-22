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

// Get the last inserted characterID
$lastInsertedID = mysqli_insert_id($con);

// Update the inventoryID with the last inserted characterID
$updateInventoryIDQuery = "UPDATE characters SET inventoryID = $lastInsertedID WHERE characterID = $lastInsertedID";
$updateInventoryID = mysqli_query($con, $updateInventoryIDQuery);

if (!$updateInventoryID) {
    echo "5: Update inventoryID query failed: " . mysqli_error($con);
    exit();
}

$insertCharacterDesignQuery = "INSERT INTO character_details (characterID) VALUES ('$lastInsertedID')";
mysqli_query($con, $insertCharacterDesignQuery); //calling insertCharacterDesignQuery

if (!$insertCharacterDesignQuery) {
    echo "6: Insert character_detail query failed: " . mysqli_error($con);
    exit();
}

$insertCharacterBlendshapesQuery = "INSERT INTO character_blendshapes (characterID) VALUES ('$lastInsertedID')";
mysqli_query($con, $insertCharacterBlendshapesQuery); //calling insertCharacterBlendshapesQuery

if (!$insertCharacterDesignQuery) {
    echo "7: Insert character_blendshapes query failed: " . mysqli_error($con);
    exit();
}

echo "0" . $lastInsertedID; // Successfuly made character
mysqli_close($con); //closing the connection to the database
?>