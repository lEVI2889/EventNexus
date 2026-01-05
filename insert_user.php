<?php
require_once('DBconnect.php');

if(isset($_POST['username']) && isset($_POST['passcode']) && isset($_POST['full_name']) && isset($_POST['type'])){
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $passcode = mysqli_real_escape_string($conn, $_POST['passcode']); 
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $type = $_POST['type'];
    $sql = "INSERT INTO Users (username, passcode, full_name, email, type) 
            VALUES ('$username', '$passcode', '$full_name', '$email', '$type')";
    if(mysqli_query($conn, $sql)){
        echo "<script>alert('Registration Successful! Your role as $type has been activated. Please Login.'); window.location.href='index.php';</script>";
    }
    else{
        echo "Error: " . mysqli_error($conn);
        echo "<br><a href='new_user.php'>Try Again</a>";
    }
}
else {
    echo "Missing required fields.";
}
?>