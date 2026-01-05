<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once('DBconnect.php');

if(!isset($_SESSION['user_id'])){
    die("Please login first to add events.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $event_date = $_POST['event_date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $venue_id = $_POST['venue_id'];
    $host_id = $_SESSION['user_id']; 

    $current_date = date('Y-m-d');
    $minimum_date = date('Y-m-d', strtotime('+3 days')); // Calculates 3 days from today

    if ($event_date < $minimum_date) {
        echo "<script>alert('Error: Events must be scheduled at least 3 days in advance. The earliest available date is $minimum_date.'); window.history.back();</script>";
        exit(); // Stop further execution
    }

    // STEP 1: Collision Check - Look for approved events at the same venue and time
    $check_sql = "SELECT title FROM EventShow 
                  WHERE venue_id = '$venue_id' 
                  AND event_date = '$event_date' 
                  AND status = 'Approved'
                  AND (
                      ('$start_time' BETWEEN start_time AND end_time) OR 
                      ('$end_time' BETWEEN start_time AND end_time) OR
                      (start_time BETWEEN '$start_time' AND '$end_time')
                  )";

    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        // Collision detected: Stop the process
        $conflict = mysqli_fetch_assoc($check_result);
        $conflicting_name = htmlspecialchars($conflict['title']);
        echo "<script>alert('Error: This venue is already booked for \"$conflicting_name\" during this time!'); window.history.back();</script>";
    } else {
        // STEP 2: No collision found, proceed with insertion
        $sql_event = "INSERT INTO EventShow (title, description, event_date, start_time, end_time, host_id, venue_id, status) 
                      VALUES ('$title', '$description', '$event_date', '$start_time', '$end_time', '$host_id', '$venue_id', 'Pending')";

        if(mysqli_query($conn, $sql_event)) {
            echo "<script>alert('Event Created Successfully and sent for Approval!'); window.location.href='add_events.php';</script>";
        } else {
            die("Database Error: " . mysqli_error($conn));
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Host New Event | EventNexus</title>
    <link rel="stylesheet" href="css/style.css" />
</head>
<body>
    <header>
      <nav>
        <div class="nav_logo">
          <h1><a href="home_host.php">EventNexus</a></h1>
        </div>
        <ul class="nav_link">
          <li><a href="home_host.php">Dashboard</a></li>
          <li><a href="logout.php">Logout</a></li>
        </ul>
      </nav>
    </header>

    <div class="add_student_box">
        <h1>Host New Event</h1>
        <form action="" method="post">
            <label>Event Title:</label>
            <input type="text" name="title" required />
            
            <label>Description:</label>
            <textarea name="description" rows="2" style="width: 100%; padding: 10px;" required></textarea>
            
            <label>Prefered Venue:</label>
            <select name="venue_id" required style="width: 100%; padding: 10px; margin-bottom: 10px;">
                <option value="">-- Choose a Location --</option>
                <?php 
                $v_query = "SELECT venue_id, name, address FROM Venue";
                $v_res = mysqli_query($conn, $v_query);
                while($v = mysqli_fetch_assoc($v_res)) {
                    echo "<option value='".$v['venue_id']."'>".$v['name']." (".$v['address'].")</option>";
                }
                ?>
            </select>

            <label>Date:</label>
            <input type="date" name="event_date" required />

            <div style="display: flex; gap: 10px;">
                <div style="flex: 1;">
                    <label>Start Time:</label>
                    <input type="time" name="start_time" required />
                </div>
                <div style="flex: 1;">
                    <label>End Time:</label>
                    <input type="time" name="end_time" required />
                </div>
            </div>
            <br>
            <input type="submit" value="Create Event">
        </form>
    </div>

    <main>
        <section class="students">
            <div class="student_box">
                <h2>Your Events List</h2>
                <table class="student_table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Venue</th> <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $current_host = $_SESSION['user_id'];
                        $sql = "SELECT e.*, v.name as venue_name 
                                FROM EventShow e 
                                JOIN Venue v ON e.venue_id = v.venue_id 
                                WHERE e.host_id = '$current_host' 
                                ORDER BY e.event_id DESC";
                        $result = mysqli_query($conn, $sql);
                        
                        while($row = mysqli_fetch_array($result)){
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row["title"]); ?></td>
                            <td><?php echo htmlspecialchars($row["venue_name"]); ?></td>
                            <td><?php echo $row["event_date"]; ?></td>
                            <td><?php echo $row["status"]; ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>