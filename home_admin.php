<?php
session_start();
require_once('DBconnect.php');
if (!isset($_SESSION['user_id']) || $_SESSION['type'] !== 'Admin') {
    header("Location: index.php");
    exit();
}
if (isset($_GET['event_id']) && isset($_GET['new_status'])) {
    $event_id = mysqli_real_escape_string($conn, $_GET['event_id']);
    $new_status = mysqli_real_escape_string($conn, $_GET['new_status']);
    if (in_array($new_status, ['Approved', 'Cancelled', 'Pending'])) {
        $update_sql = "UPDATE EventShow SET status = '$new_status' WHERE event_id = '$event_id'";
        if (mysqli_query($conn, $update_sql)) {
            header("Location: home_admin.php?msg=updated");
            exit();
        }
    }
}
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
    <title>Admin - Home | EventNexus</title>
    <style>
        .status-badge { padding: 4px 8px; border-radius: 4px; font-size: 0.85em; font-weight: bold; color: white; }
        .bg-pending { background-color: #f39c12; }
        .bg-approved { background-color: #27ae60; }
        .bg-cancelled { background-color: #e74c3c; }
        .btn-approve { color: #27ae60; text-decoration: none; margin-right: 10px; font-weight: bold; }
        .btn-cancel { color: #e74c3c; text-decoration: none; font-weight: bold; }
    </style>
  </head>
  <body>
    <header>
      <nav>
        <div class="nav_logo">
          <h1><a href="home_admin.php">EventNexus</a></h1>
        </div>
        <ul class="nav_link">
          <li><a href="add_venue.php">Add Venues</a></li>
          <li><a href="verification.php">Verify Users</a></li>
          <li><a href="index.php">Logout</a></li>
        </ul>
      </nav>
    </header>
    
    <main>
      <section class="welcome_msg" style="text-align: center; margin-bottom: 40px;">
          <h1 style="color: white; font-weight:400; font-size: 2.5rem;">
            Admin Dashboard...
          </h1>
          <p style="color: grey;">Logged in as user: <span style="color: green; font-weight: bold"><?php echo htmlspecialchars($_SESSION['username']);?></span></p>
      </section>
      <section class="students">
        <div class="student_box">
            <h2>Running Events Status</h2>
            <table class="student_table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Host Name</th>
                        <th>Date</th>
                        <th>Start</th>
                        <th>End</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $sql = "SELECT e.*, u.full_name FROM EventShow e 
                            JOIN Users u ON e.host_id = u.user_id 
                            ORDER BY e.event_id DESC";
                    $result = mysqli_query($conn, $sql);

                    if($result && mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_assoc($result)){
                            $status_class = "bg-" . strtolower($row['status']);
                    ?>
                    <tr>
                        <td><strong><?php echo htmlspecialchars($row["title"]); ?></strong></td>
                        <td><?php echo htmlspecialchars($row["full_name"]); ?></td>
                        <td><?php echo $row["event_date"]; ?></td>
                        <td><?php echo $row["start_time"]; ?></td>
                        <td><?php echo $row["end_time"]; ?></td>
                        <td><span class="status-badge <?php echo $status_class; ?>"><?php echo $row["status"]; ?></span></td>
                        <td>
                            <?php if($row['status'] == 'Pending'): ?>
                                <a href="home_admin.php?event_id=<?php echo $row['event_id']; ?>&new_status=Approved" class="btn-approve">Approve</a>
                                <a href="home_admin.php?event_id=<?php echo $row['event_id']; ?>&new_status=Cancelled" class="btn-cancel">Cancel</a>
                            <?php else: ?>
                                <span style="color: #999;">Decision Made</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php
                        }
                    } else {
                        echo "<tr><td colspan='5'>No event requests found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div style="padding: 15px; background: rgba(255, 255, 255, 0.05); border-radius: 8px; border: 1px solid rgba(255,255,255,0.1);">
              <p style="font-size: 0.9rem; color: white;">
                Rules:
              </p>
              <p style="font-size: 0.9rem; color: white;">
                1. Approval/Cancellation can be only done once! Be careful!
              </p>
              <p style="font-size: 0.9rem; color: white;">
                2. Cancel if some idiot mistakenly added an event and informed HQ! If already approved no need to Refund! 
              </p>
        </div>
      </section>
    </main>
  </body>
</html>