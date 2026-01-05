<?php
session_start();
require_once('DBconnect.php');
if (!isset($_SESSION['user_id']) || $_SESSION['type'] !== 'Merchant') {
    die("Access Denied: Please login first as a Merchant to manage stalls.");
}
$current_merchant_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register_stall'])) {
    $stall_name = mysqli_real_escape_string($conn, $_POST['stall_name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    
    $sql_stall = "INSERT INTO Merch_Stall (stall_name, description, merchant_id) 
                  VALUES ('$stall_name', '$description', '$current_merchant_id')";

    if (mysqli_query($conn, $sql_stall)) {
        echo "<script>alert('Stall Registered Successfully!'); window.location.href='book_stall.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['assign_stall'])) {
    $event_id = mysqli_real_escape_string($conn, $_POST['event_id']);
    $stall_id = mysqli_real_escape_string($conn, $_POST['stall_id']);

    $sql_link = "INSERT INTO Available_At (event_id, stall_id) VALUES ('$event_id', '$stall_id')";

    if (mysqli_query($conn, $sql_link)) {
        echo "<script>alert('Stall successfully assigned to Event!');</script>";
    } else {
        echo "Error: This stall might already be assigned to this event.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Stalls | EventNexus</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
      <nav>
        <div class="nav_logo"><h1><a href="home_merchant.php">EventNexus</a></h1></div>
        <ul class="nav_link">
            <li><a href="home_merchant.php">Dashboard</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
      </nav>
    </header>
    <main>
        <div class="add_student_box">
            <h1>Step 1: Register New Stall</h1>
            <form action="" method="post">
                <label>Stall Name:</label>
                <input type="text" name="stall_name" placeholder="Enter stall name" required />
                <label>Description:</label>
                <textarea name="description" rows="2" style="width: 100%; padding: 10px;" required></textarea>
                <br><br>
                <input type="submit" name="register_stall" value="Register Stall">
            </form>
            <hr style="margin: 30px 0; border: 0; border-top: 1px solid #444;">
            <h1>Step 2: Assign Stall to Event</h1>
            <form action="" method="post">
                <label>Choose Your Stall:</label>
                <select name="stall_id" required style="width:100%; padding:10px; margin-bottom:15px;">
                    <?php 
                    $s_query = "SELECT stall_id, stall_name 
                                FROM Merch_Stall 
                                WHERE merchant_id = '$current_merchant_id' 
                                AND stall_id NOT IN (SELECT stall_id FROM Available_At)";
                    
                    $s_res = mysqli_query($conn, $s_query);
                    
                    if (mysqli_num_rows($s_res) > 0) {
                        while($s = mysqli_fetch_assoc($s_res)) {
                            echo "<option value='".$s['stall_id']."'>".$s['stall_name']."</option>";
                        }
                    } else {
                        echo "<option value='' disabled selected>No unassigned stalls available</option>";
                    }
                    ?>
                </select>

                <label>Select Approved Event:</label>
                <select name="event_id" required style="width:100%; padding:10px; margin-bottom:15px;">
                    <?php 
                    $e_query = "SELECT event_id, title FROM EventShow WHERE status = 'Approved'";
                    $e_res = mysqli_query($conn, $e_query);
                    while($e = mysqli_fetch_assoc($e_res)) {
                        echo "<option value='".$e['event_id']."'>".$e['title']."</option>";
                    }
                    ?>
                </select>
                <input type="submit" name="assign_stall" value="Confirm Stall Assignment">
            </form>
        </div>

        <section class="students">
            <div class="student_box">
                <h2>Your Stall Assignments</h2>
                <table class="student_table">
                    <thead>
                        <tr>
                            <th>Stall Name</th>
                            <th>Event Title</th>
                            <th>Location/Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $sql = "SELECT ms.stall_name, es.title, COALESCE(v.address, 'Venue Pending') as address 
                                FROM Available_At aa
                                JOIN Merch_Stall ms ON aa.stall_id = ms.stall_id
                                JOIN EventShow es ON aa.event_id = es.event_id
                                LEFT JOIN PayToSecure p ON es.event_id = p.event_id
                                LEFT JOIN Venue v ON p.venue_id = v.venue_id
                                WHERE ms.merchant_id = '$current_merchant_id'";
                                
                        $result = mysqli_query($conn, $sql);
                        
                        if($result && mysqli_num_rows($result) > 0){
                            while($row = mysqli_fetch_assoc($result)){
                                echo "<tr>
                                        <td>".$row['stall_name']."</td>
                                        <td>".$row['title']."</td>
                                        <td>".$row['address']."</td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='3'>No active assignments found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>
