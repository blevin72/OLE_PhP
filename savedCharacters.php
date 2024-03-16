<?php
include 'config.php';
$con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Check if the connection happened
if (mysqli_connect_errno()) {
    echo "1: Connection failed"; // Error code #1 = connection failed
    exit();
}

$action = isset($_GET['action']) ? $_GET['action'] : '';

if($action == "select")
{
    //Get values from the form
    $accountID = $_POST['accountID'];
    
    $selectCharacterDataQuery = "SELECT character_name, outpostID, level, ClassID, characterID FROM characters WHERE accountID = '$accountID'";
    $result = ($con->query($selectCharacterDataQuery));

    if($result->num_rows > 0)
    {
        $response = "";
        while ($row = $result->fetch_assoc()) 
        {
            $response .= $row['character_name'] . "," . $row['outpostID'] . "," . $row['level'] . "," . $row['ClassID'] . "," . $row['characterID'] . "|";
        }
        echo $response;
    }
    // else
    // {
    //     echo "No characters found for the given ID";
    // }
}
else
{
    echo "invalid action";
}
?>