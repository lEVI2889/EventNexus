<?php
session_start();
require_once('DBconnect.php');
if (!isset($_SESSION['user_id']) || $_SESSION['type'] != 'Customer') {
    header("Location: index.php");
    exit();
}
$user_id = $_SESSION['user_id'];
$user_query = "SELECT full_name FROM Users WHERE user_id = '$user_id'";
$user_res = mysqli_query($conn, $user_query);
$user_data = mysqli_fetch_assoc($user_res);
$full_name = $user_data['full_name'];
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&display=swap" rel="stylesheet" />
    <title>Customer - Home | EventNexus</title>
  </head>
  <body>
    <header>
      <nav>
        <div class="nav_logo">
          <h1><a href="home_customer.php">EventNexus</a></h1>
        </div>
        <ul class="nav_link">
          <li><a href="book_ticket.php">Book Ticket</a></li>
          <li><a href="logout.php">Logout</a></li>
        </ul>
      </nav>
    </header>
    <main style="flex-direction: column; justify-content: flex-start; padding-top: 50px;">
        
        <section class="welcome_msg" style="text-align: center; margin-bottom: 40px;">
            <h1 style="color: white; font-weight:400; font-size: 2.5rem;">
                Welcome, <span style="color: green; font-weight: 600;"><?php echo htmlspecialchars($full_name); ?></span>!
            </h1>
            <p style="color: grey;">Find and book the most exciting events happening near you.</p>
        </section>
        <section class="students"> 
            <div class="student_box" style="max-width: 1200px;"> <h1 style="text-align: left; margin-bottom: 20px; color: cyan;">Upcoming Events</h1>
                
                <table class="student_table">
                    <thead>
                        <tr>
                            <th>Event Title</th>
                            <th>Host</th>
                            <th>Location / Venue</th> <th>Date</th>
                            <th>Time</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php                        
                        $sql = "SELECT e.*, u.full_name as host_display_name, v.name as venue_name, v.address as venue_address
                                FROM EventShow e 
                                JOIN Users u ON e.host_id = u.user_id 
                                JOIN Venue v ON e.venue_id = v.venue_id
                                WHERE e.status = 'Approved' 
                                ORDER BY e.event_date ASC";                        
                        $result = mysqli_query($conn, $sql);
                        if($result && mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>
                                    <td style="font-weight: 500; color: white;"><?php echo htmlspecialchars($row['title']); ?></td>
                                    <td><?php echo htmlspecialchars($row['host_display_name']); ?></td>
                                    <td>
                                        <strong><?php echo htmlspecialchars($row['venue_name']); ?></strong><br>
                                        <small style="color: grey;"><?php echo htmlspecialchars($row['venue_address']); ?></small>
                                    </td>
                                    <td><?php echo date("M d, Y", strtotime($row['event_date'])); ?></td>
                                    <td><?php echo $row['start_time']; ?> - <?php echo $row['end_time']; ?></td>
                                    <td style="font-size: 0.85rem; max-width: 200px;"><?php echo htmlspecialchars($row['description']); ?></td>
                                    <td>
                                        <a href="book_ticket.php?event_id=<?php echo $row['event_id']; ?>" class="btn" style="float: none; padding: 5px 15px; font-size: 0.8rem;">
                                            Book
                                        </a>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo "<tr><td colspan='7' style='text-align:center;'>No upcoming events found. Check back later!</td></tr>";
                        }
                        ?>
                    </tbody>
                    