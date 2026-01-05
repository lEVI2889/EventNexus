<?php
session_start();
require_once('DBconnect.php');

// Security Check: Only allow logged-in Hosts
if (!isset($_SESSION['user_id']) || $_SESSION['type'] !== 'Host') {
    header("Location: index.php");
    exit();
}

$current_host_id = $_SESSION['user_id'];

// Fetch the Host's full name from the central Users table
$query = "SELECT full_name FROM Users WHERE user_id = '$current_host_id'";
$result = mysqli_query($conn, $query);
$host_data = mysqli_fetch_assoc($result);
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
    <title>Host Dashboard | EventNexus</title>
    <style>
        /* Status styling for better visibility */
        .status-badge { padding: 5px 10px; border-radius: 4px; font-weight: bold; font-size: 0.85rem; color: white; }
        .bg-confirmed { background-color: #27ae60; } /* Green */
        .bg-pending { background-color: #f39c12; }   /* Orange */
        .bg-cancelled { background-color: #e74c3c; } /* Red */
    </style>
  </head>
  <body>
    <header>
      <nav>
        <div class="nav_logo">
          <h1><a href="home_host.php">EventNexus</a></h1>
        </div>
        <ul class="nav_link">
          <li><a href="add_events.php">Create Event</a></li>
          <li><a href="book_venue.php">Book Venue</a></li>
          <li><a href="logout.php">Logout</a></li>
        </ul>
      </nav>
    </header>
    <main>
      <section class="welcome_msg" style="text-align: center; margin-bottom: 40px;">
          <h1 style="color: white; font-weight:400; font-size: 2.5rem;">
            Welcome, <span style="color: #2ecc71; font-weight: 600;"><?php echo htmlspecialchars($host_data['full_name']); ?></span>!
          </h1>
           <h2 style="color: white; margin-top: 10px; font-weight:300;">Ready to host your next big event?</h2>
      </section>

      <section class="students">
        <div class="student_box">
            <h2>Your Current Venue Bookings & Payments</h2>
            <table class="student_table">
                <thead>
                    <tr>
                        <th>Event Title</th>
                        <th>Venue Name</th>
                        <th>Amount Paid</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    // JOIN PayToSecure with EventShow and Venue to get meaningful names
                    $sql = "SELECT p.amount, p.payment_status, e.title as event_name, v.name as venue_name 
                            FROM PayToSecure p
                            JOIN EventShow e ON p.event_id = e.event_id
                            JOIN Venue v ON p.venue_id = v.venue_id
                            WHERE p.host_id = '$current_host_id'
                            ORDER BY p.payment_date DESC";
                    
                    $result = mysqli_query($conn, $sql);
                    if($result && mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_assoc($result)){
                            // Determine CSS class based on payment status
                            $status = $row['payment_status'];
                            $badge_class = "bg-" . strtolower($status);
                            ?>
                            <tr>
                                <td><strong><?php echo htmlspecialchars($row['event_name']); ?></strong></td>
                                <td><?php echo htmlspecialchars($row['venue_name']); ?></td>
                                <td>৳ <?php echo number_format($row['amount'], 2); ?></td>
                                <td>
                                    <span class="status-badge <?php echo $badge_class; ?>">
                                        <?php echo $status; ?>
                                    </span>
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        echo "<tr><td colspan='4' style='text-align:center;'>No bookings found. Please <a href='book_venue.php' style='color:#03dac6;'>finalize a venue</a> for your events.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        
        <div style="padding: 15px; background: rgba(255, 255, 255, 0.05); border-radius: 8px; border: 1px solid rgba(255,255,255,0.1); margin-top: 20px;">
          <p style="font-size: 0.9rem; color: #ccc;">
            Approval taking too long? Call Admin HQ at +8801234-56789 and ask nicely!
          </p>
        </div>
      </section>
    </main>
  </body>
</html>