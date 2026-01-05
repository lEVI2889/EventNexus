<?php
require_once('DBconnect.php');
session_start();

if(isset($_POST['username']) && isset($_POST['password'])){
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $sql = "SELECT * FROM Users WHERE username = '$username' AND passcode = '$password'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['type'] = $row['type'];        
        $user_type = $row['type'];
        if($row['is_verified'] == 'blocked'){
            header("Location: home_unverified.php");
            exit();
        }
        else{
            switch ($user_type) {
                case 'Admin':
                    header("Location: home_admin.php");
                    break;
                case 'Host':
                    header("Location: home_host.php");
                    break;
                case 'Customer':
                    header("Location: home_customer.php");
                    break;
                case 'Merchant':
                    header("Location: home_merchant.php");
                    break;
                default:
                    header("Location: index.php?error=InvalidUserType");
                    break;
            }
        }
        exit();
    }
    else{
        header("Location: index.php?error=invalid");
        exit();
    }
}
?>