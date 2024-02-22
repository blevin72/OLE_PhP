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
    //Get values from the form
    $characterID = isset($_POST['characterID']) ? $_POST['characterID'] : 0;
    $jawLength = isset($_POST['jaw_length']) ? (float)$_POST['jaw_length'] : 0;
    $jawWidth = isset($_POST['jaw_width']) ? (float)$_POST['jaw_width'] : 0;
    $cheekWiden = isset($_POST['cheek_widen']) ? (float)$_POST['cheek_widen'] : 0;
    $cheekNarrow = isset($_POST['cheek_narrow']) ? (float)$_POST['cheek_narrow'] : 0;
    $cheekBones = isset($_POST['cheek_bones']) ? (float)$_POST['cheek_bones'] : 0;
    $innerEyebrows = isset($_POST['inner_eyebrows']) ? (float)$_POST['inner_eyebrows'] : 0;
    $outerEyebrows = isset($_POST['outer_eyebrows']) ? (float)$_POST['outer_eyebrows'] : 0;
    $smile = isset($_POST['smile']) ? (float)$_POST['smile'] : 0;
    $chinWidth = isset($_POST['chin_width']) ? (float)$_POST['chin_width'] : 0;
    $chinLength = isset($_POST['chin_length']) ? (float)$_POST['chin_length'] : 0;
    $eyeHeight = isset($_POST['eye_height']) ? (float)$_POST['eye_height'] : 0;
    $eyeOpen = isset($_POST['eye_open']) ? (float)$_POST['eye_open'] : 0;
    $noseLength = isset($_POST['nose_length']) ? (float)$_POST['nose_length'] : 0;
    $earsSize = isset($_POST['ears_size']) ? (float)$_POST['ears_size'] : 0;
    $mouthWidth = isset($_POST['mouth_width']) ? (float)$_POST['mouth_width'] : 0;
    $mouthLength = isset($_POST['mouth_length']) ? (float)$_POST['mouth_length'] : 0;
    $lipsThick = isset($_POST['lips_thick']) ? (float)$_POST['lips_thick'] : 0;
    $lipsThin = isset($_POST['lips_thin']) ? (float)$_POST['lips_thin'] : 0;
    $noseTipsUp = isset($_POST['nose_tips_up']) ? (float)$_POST['nose_tips_up'] : 0;
    $noseTipsDown = isset($_POST['nose_tips_down']) ? (float)$_POST['nose_tips_down'] : 0;
    $noseRidge = isset($_POST['nose_ridge']) ? (float)$_POST['nose_ridge'] : 0;
    $noseWidth = isset($_POST['nose_width']) ? (float)$_POST['nose_width'] : 0;
    $noseNarrow = isset($_POST['nose_narrow']) ? (float)$_POST['nose_narrow'] : 0;

    $updateCharacterBlendshapesQuery = "UPDATE character_blendshapes
        SET jaw_length = '$jawLength',
            jaw_width = '$jawWidth',
            cheek_widen = '$cheekWiden',
            cheek_narrow = '$cheekNarrow',
            cheek_bones = '$cheekBones',
            inner_eyebrows = '$innerEyebrows',
            outer_eyebrows = '$outerEyebrows',
            smile = '$smile',
            chin_width = '$chinWidth',
            chin_length = '$chinLength',
            eye_height = '$eyeHeight',
            eye_open = '$eyeOpen',
            nose_length = '$noseLength',
            ears_size = '$earsSize',
            mouth_width = '$mouthWidth',
            mouth_length = '$mouthLength',
            lips_thick = '$lipsThick',
            lips_thin = '$lipsThin',
            nose_tips_up = '$noseTipsUp',
            nose_tips_down = '$noseTipsDown',
            nose_ridge = '$noseRidge',
            nose_width = '$noseWidth',
            nose_narrow = '$noseNarrow'
        WHERE characterID = '$characterID'";

        $result = mysqli_query($con, $updateCharacterBlendshapesQuery);

        if ($result) {
            echo "0: Update successful"; // Success
        } else {
            echo "2: Update query failed. Error: " . mysqli_error($con); // Error code #2 = update query failed
        }

    mysqli_close($con);
}
?>