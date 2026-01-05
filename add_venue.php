<?php
session_start();
require_once('DBconnect.php');

if (!isset($_SESSION['user_id']) || $_SESSION['type'] !== 'Admin') {
    header("Location: index.php");
    exit();
}

$current_admin_id = $_SESSION['user_id'];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $venue_name = mysqli_real_escape_string($conn, $_POST['venue_name']);
    $venue_address = mysqli_real_escape_string($conn, $_POST['venue_address']);
    
    $sql_venue = "INSERT INTO Venue (name, address) VALUES ('$venue_name', '$venue_address')";
    
    if(mysqli_query($conn, $sql_venue)) {
        echo "<script>alert('Venue added successfully!');</script>";
    } else {
        echo "Error adding venue: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Venue | EventNexus</title>
    <link rel="stylesheet" href="css/style.css" />
</head>
<body>
    <header>
      <nav>
        <div class="nav_logo">
          <h1><a href="home_admin.php">EventNexus</a></h1>
        </div>
        <ul class="nav_link">
          <li><a href="home_admin.php">Dashboard</a></li>
          <li><a href="index.php">Logout</a></li>
        </ul>
      </nav>
    </header>

    <div class="add_student_box">
        <h1>Add New Venue</h1>
        <form action="" method="post">
            <label>Venue Name:</label>
            <input type="text" name="venue_name" required />
            <label>Address:</label>
            <input type="text" name="venue_address" required />
            <br>
            <input type="submit" value="Add Venue">
        </form>
    </div>

    <main>
        <section class="students">
            <div class="student_box">
                <h2>Venue List</h2>
                <table class="student_table">
                    <thead>
                        <tr>
                            <th>Venue ID</th>
                            <th>Name</th>
                            <th>Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $sql = "SELECT * FROM Venue ORDER BY venue_id DESC";
                        $result = mysqli_query($conn, $sql);
                        if($result && mysqli_num_rows($result) > 0){
                            while($row = mysqli_fetch_array($result)){
                        ?>
                        <tr>
                            <td><?php echo $row["venue_id"]; ?></td>
                            <td><?php echo $row["name"]; ?></td>
                            <td><?php echo $row["address"]; ?></td>
                        </tr>
                        <?php
                            }
                        } else {
                            echo "<tr><td colspan='3'>No venues found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>