<?php
session_start();
require_once('DBconnect.php');

// Security Check: Only allow logged-in Hosts
if (!isset($_SESSION['user_id']) || $_SESSION['type'] !== 'Host') {
    header("Location: index.php");
    exit();
}
$current_host_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm_booking'])) {
    $event_id = mysqli_real_escape_string($conn, $_POST['event_id']);
    $amount = mysqli_real_escape_string($conn, $_POST['amount']);
    
    // NEW: Check if this event has ALREADY been paid for
    $dup_check = "SELECT event_id FROM PayToSecure WHERE event_id = '$event_id'";
    $dup_res = mysqli_query($conn, $dup_check);

    if (mysqli_num_rows($dup_res) > 0) {
        // If a record exists, stop the payment process
        echo "<script>alert('Error: You have already paid for this event venue!'); window.location.href='book_venue.php';</script>";
    } else {
        // Proceed with your original verification and insertion logic
        $fetch_event = "SELECT venue_id, status FROM EventShow WHERE event_id = '$event_id'";
        $event_res = mysqli_query($conn, $fetch_event);
        $event_data = mysqli_fetch_assoc($event_res);

        if ($event_data) {
            if ($event_data['status'] !== 'Approved') {
                echo "<script>alert('Error: You cannot pay for an event that has not been Approved by the Admin yet!'); window.location.href='book_venue.php';</script>";
            } else {
                $venue_id = $event_data['venue_id'];
                $sql_book = "INSERT INTO PayToSecure (host_id, venue_id, event_id, amount, payment_status) 
                             VALUES ('$current_host_id', '$venue_id', '$event_id', '$amount', 'Confirmed')";
                
                if (mysqli_query($conn, $sql_book)) {
                    echo "<script>alert('Payment Successful! Venue is now confirmed.'); window.location.href='book_venue.php';</script>";
                } else {
                    echo "Error: " . mysqli_error($conn);
                }
            }
        } else {
            echo "<script>alert('Error: Event record not found.'); window.location.href='book_venue.php';</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book Venue | EventNexus</title>
    <link rel="stylesheet" href="css/style.css">
    <script>
        // Simple JavaScript to show the venue name when an event is selected
        function updateVenueDisplay() {
            var select = document.getElementById("event_id");
            var venueName = select.options[select.selectedIndex].getAttribute("data-venue");
            document.getElementById("venue_display").value = venueName ? venueName : "Select an event first";
        }
    </script>
</head>
<body>
    <header>
      <nav>
        <div class="nav_logo"><h1><a href="home_host.php">EventNexus</a></h1></div>
        <ul class="nav_link">
            <li><a href="home_host.php">Dashboard</a></li>
            <li><a href="add_events.php">Create Event</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
      </nav>
    </header>
    <main>
        <div class="add_student_box">
            <h1>Finalize Venue Payment</h1>
            <form action="" method="post">                
                <label>Select Your Created Event:</label>
                <select name="event_id" id="event_id" required onchange="updateVenueDisplay()" style="width:100%; padding: 10px; margin-bottom: 15px;">
                    <option value="">-- Choose Your Event --</option>
                    <?php
                        // We select events that are Approved AND haven't been paid for yet
                        $event_query = "SELECT e.event_id, e.title, v.name as venue_name 
                                       FROM EventShow e 
                                        JOIN Venue v ON e.venue_id = v.venue_id 
                                        WHERE e.host_id = '$current_host_id' 
                                        AND e.status = 'Approved'
                                        AND e.event_id NOT IN (SELECT event_id FROM PayToSecure)"; // The filter

                                        $event_res = mysqli_query($conn, $event_query);

                                        if ($event_res && mysqli_num_rows($event_res) > 0) {
                                        while($e = mysqli_fetch_assoc($event_res)) {
                                        echo "<option value='".$e['event_id']."' data-venue='".htmlspecialchars($e['venue_name'])."'>".htmlspecialchars($e['title'])."</option>";
                                    }
                                    } else {
                                            // Helpful feedback for the user
                                        echo "<option value=''>No pending venue payments found</option>";
                                    }
                    ?>
                </select>

                <label>Venue (Auto-selected from Event Creation):</label>
                <input type="text" id="venue_display" readonly style="background: rgba(255,255,255,0.1); color: #03dac6;" placeholder="Venue will appear here">

                <label>Security Deposit / Amount (৳):</label>
                <input type="number" name="amount" value="100.00" step="0.01" required>
                <br><br>
                <input type="submit" name="confirm_booking" value="Confirm Venue Booking">
            </form>
        </div>

        <section class="students">
            <div class="student_box">
                <h2>Your Current Venue Bookings</h2>
                <table class="student_table">
                    <thead>
                        <tr>
                            <th>Event Title</th>
                            <th>Venue Location</th>
                            <th>Amount Paid</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $sql = "SELECT p.amount, p.payment_status, e.title as event_name, v.name as venue_name 
                                FROM PayToSecure p
                                JOIN EventShow e ON p.event_id = e.event_id
                                JOIN Venue v ON p.venue_id = v.venue_id
                                WHERE p.host_id = '$current_host_id'
                                ORDER BY p.payment_date DESC";
                        
                        $result = mysqli_query($conn, $sql);
                        if($result && mysqli_num_rows($result) > 0){
                            while($row = mysqli_fetch_assoc($result)){
                                echo "<tr>
                                        <td>".htmlspecialchars($row['event_name'])."</td>
                                        <td>".htmlspecialchars($row['venue_name'])."</td>
                                        <td>৳ ".$row['amount']."</td>
                                        <td><strong>".$row['payment_status']."</strong></td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>No confirmed bookings found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div style="padding: 15px; background: rgba(255, 255, 255, 0.05); border-radius: 8px; border: 1px solid rgba(255,255,255,0.1); margin-top: 20px;">
              <p style="font-size: 0.9rem; color: #ccc;">
                In case of unwanted booking, call Admin HQ at +8801234-56789, ask for REFUND and CANCELLATION!
              </p>
            </div>
        </section>
    </main>
</body>
</html>