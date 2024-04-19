<?php
include 'config.php';
$con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
// Check if the connection happened
if (mysqli_connect_errno()) 
{
    echo "1: Connection failed"; // Error code #1 = connection failed
    exit();
}

$action = isset($_GET['action']) ? $_GET['action'] : '';

if($action  == "insert")
{
    //Get values from the form
    $characterID = isset($_POST['characterID']) ? $_POST['characterID'] : 0;
    $chatType = isset($_POST['chat_type']) ? $_POST['chat_type'] : '';
    $content = isset($_POST['content']) ? mysqli_real_escape_string($con, $_POST['content']) : '';

    $messageQuery = "INSERT INTO outpost_chatrooms(outpostID, characterID, chat_type, content)
                     VALUES ((SELECT outpostID FROM characters WHERE characterID = '$characterID'), '$characterID', '$chatType', '$content')";  
    
    // Echo the query
    echo "Query: " . $messageQuery . "<br>";

    $insert = mysqli_query($con, $messageQuery);

    // Check if the query was successful
    if ($insert) {
        echo "Insertion successful";
    } else {
        echo "Error: " . mysqli_error($con);
    }

    mysqli_close($con);
}
else 
{
    echo "Invalid action";
}

?>