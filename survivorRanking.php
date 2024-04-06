<?php
include 'config.php';
$con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
//check if connection happened
if(mysqli_connect_errno()){
    echo "1: Connection failed"; //error code #1 connection failed
    exit();
}

$action = isset($_GET['action']) ? $_GET['action'] : '';

if($action == 'get_characterStats')
{
    //get settings based off characterID
    $characterID = isset($_GET['characterID']) ? ($_GET['characterID']) : 0;

    $query = "SELECT character_name, `level`, exp, outpost_ranking, total_health, total_stamina, total_protection, total_progression, 
    strength, dexterity, intellect, endurance, charm, stealth, skill_points, characterID FROM characters
    WHERE characterID = '$characterID'";

    $result= mysqli_query($con, $query);

    if($result)
    {
        $row = mysqli_fetch_assoc($result);
        $response = array(
            'characterID' => $row['characterID'],
            'character_name' => $row['character_name'],
            'level' => $row['level'],
            'exp' => $row['exp'],
            'outpost_ranking' => $row['outpost_ranking'],
            'total_health'=> $row['total_health'],
            'total_stamina'=> $row['total_stamina'],
            'total_protection'=> $row['total_protection'],
            'total_progression'=> $row['total_progression'],
            'strength'=> $row['strength'],
            'dexterity'=> $row['dexterity'],
            'intellect'=> $row['intellect'],
            'endurance'=> $row['endurance'],
            'charm'=> $row['charm'],
            'stealth'=> $row['stealth'],
            //'skill_points' => $row['skill_points'], OFF for testing
        );   

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
else if($action == 'save_characterStats')
{
    $characterID = isset($_POST['characterID']) ? intval($_POST['characterID']) : 0;
    $strength = isset($_POST['strength']) ? intval($_POST['strength']) : 0;
    $dexterity = isset($_POST['dexterity']) ? intval($_POST['dexterity']) : 0;
    $intellect = isset($_POST['intellect']) ? intval($_POST['intellect']) : 0;
    $endurance = isset($_POST['endurance']) ? intval($_POST['endurance']) : 0;
    $charm = isset($_POST['charm']) ? intval($_POST['charm']) : 0;
    $stealth = isset($_POST['stealth']) ? intval($_POST['stealth']) : 0;
    $totalHealth = isset($_POST['total_health']) ? intval($_POST['total_health']) : 0;
    $totalStamina = isset($_POST['total_stamina']) ? intval($_POST['total_stamina']) : 0;
    $totalProtection = isset($_POST['total_protection']) ? intval($_POST['total_protection']) : 0;
    $totalProgression = isset($_POST['total_progression']) ? intval($_POST['total_progression']) : 0;

    $updateStatsQuery = "UPDATE characters
        SET strength = $strength,
            dexterity = $dexterity,
            intellect = $intellect,
            endurance = $endurance,
            charm = $charm,
            stealth = $stealth,
            total_health = $totalHealth,
            total_stamina = $totalStamina,
            total_protection = $totalProtection,
            total_progression = $totalProgression
        WHERE characterID = '$characterID'";
    
    $result = mysqli_query($con, $updateStatsQuery);

    if ($result) {
        echo "0: Update successful"; // Success
    } else {
        echo "2: Update query failed. Error: " . mysqli_error($con); // Error code #2 = update query failed
    }

    mysqli_close($con);
}
else 
{
    echo "Invalid action";
}
?>