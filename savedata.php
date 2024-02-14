<?php
include 'config.php';
$con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    // Check if the connection happened
    if(mysqli_connect_errno()) {
        echo "1: Connection failed"; // Error code #1 = connection failed
        exit();
    }

    $email = $_POST["email"];
    $experience = $_POST["experience"];

    $emailCheckQuery = "SELECT email, salt, hash, experience FROM accounts WHERE email = '$email'";

    $emailCheck = mysqli_query($con,$emailCheckQuery) or die ("2: Email check  query failed");
    if(mysqli_num_rows($emailCheck) != 1) {
        echo "5: Either no user with email, or more than one"; // Error code #5 - number of emails matching != 1
        exit();
    }

    $updatequery = "UPDATE accounts SET experience = " . $newexperience . " WHERE username = '" . $username . "';";
    mysqli_query($con, $updatequery) or die ("7: Save query failed"); //error code #7 - UPDATE query failed

    echo"0";
?>