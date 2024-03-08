<?php
include 'config.php';
$con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
//check if connection happened
if(mysqli_connect_errno()){
    echo "1: Connection failed"; //error code #1 connection failed
    exit();
}

$action = isset($_GET['action']) ? $_GET['action'] : '';

if($action = 'get_settings')
{
    //get settings based off characterID
    $characterID = isset($_GET['character_ID']) ? ($_GET['character_ID']) : 0;

    $getLevelAndExpQuery = "SELECT 'level', exp FROM characters
    WHERE characterID = '$characterID'";

    $result= mysqli_query($con, $getLevelAndExpQuery);

    if($result)
    {
        $row = mysqli_fetch_assoc($result);
        echo json_encode($row);
    }
    else 
    {
        echo "2: Query failed. Error: " . mysqli_error($con); // Error code #2 = query failed
    }
    mysqli_close($con);
}
else 
{
    echo "Invalid action";
}
?>