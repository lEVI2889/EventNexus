<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "eventnexus"; 
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}else{
    echo "";
    mysqli_select_db($conn, $dbname);
}
?>