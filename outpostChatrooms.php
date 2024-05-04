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

    $insert = mysqli_query($con, $messageQuery);

    // Check if the query was successful
    if ($insert) {
        echo "Insertion successful";
    } else {
        echo "Error: " . mysqli_error($con);
    }

    mysqli_close($con);
}
else if($action == "select")
{
    $characterID = isset($_GET['characterID']) ? $_GET['characterID'] : 0;
    $chatType = isset($_GET['chat_type']) ? $_GET['chat_type'] : '';

    $query = "SELECT content FROM outpost_chatrooms WHERE outpostID = (SELECT outpostID FROM characters WHERE characterID = '$characterID') AND chat_type = '$chatType'
              ORDER BY message_time DESC
              LIMIT 500";

    $result = mysqli_query($con, $query);

    if($result)
    {
        $response = array();
        while($row = mysqli_fetch_assoc($result))
        {
            $response[] = $row['content'];
        }

        // Set response headers to indicate JSON content
        header('Content-Type: application/json');
        
        // Output JSON response
        echo json_encode($response);
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