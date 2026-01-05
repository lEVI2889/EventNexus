<?php
session_start();
require_once('DBconnect.php');
if (!isset($_SESSION['user_id']) || $_SESSION['type'] !== 'Customer') {
    header("Location: index.php");
    exit();
}

$current_user_id = $_SESSION['user_id'];

if (isset($_GET['event_id']) && isset($_GET['action']) && $_GET['action'] == 'confirm') {
    $event_id = mysqli_real_escape_string($conn, $_GET['event_id']);
    $price = 50.00; 
    $sql_ticket = "INSERT INTO Ticket (price, event_id) VALUES ('$price', '$event_id')";
    if (mysqli_query($conn, $sql_ticket)) {
        $ticket_id = mysqli_insert_id($conn);        
        $sql_books = "INSERT INTO Books (user_id, ticket_id, event_id) 
                      VALUES ('$current_user_id', '$ticket_id', '$event_id')";

        if (mysqli_query($conn, $sql_books)) {
            echo "<script>alert('Ticket Booked Successfully! Ticket ID: #$ticket_id'); window.location.href='book_ticket.php';</script>";
        } else {
            echo "Error in Books table: " . mysqli_error($conn);
        }
    } else {
        echo "Error creating Ticket: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Book Tickets | EventNexus</title>
    <link rel="stylesheet" href="css/style.css" />
    <style>
        .status-badge { padding: 4px 8px; border-radius: 4px; font-size: 0.8em; font-weight: bold; }
        .bg-pending { background: #f39c12; color: white; }
        .bg-approved { background: #27ae60; color: white; }
        .btn-buy { background: #3498db; color: white; padding: 8px 15px; text-decoration: none; border-radius: 5px; display: inline-block; }
        .btn-buy:hover { background: #2980b9; }
        .btn-pdf { background: #27ae60; color: white; padding: 5px 10px; text-decoration: none; border-radius: 4px; font-size: 0.8em; }
        .btn-pdf:hover { background: #219150; }
    </style>
</head>
<body>
    <header>
      <nav>
        <div class="nav_logo"><h1><a href="home_customer.php">EventNexus</a></h1></div>
        <ul class="nav_link">
            <li><a href="home_customer.php">Dashboard</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
      </nav>
    </header>

    <main>
        <section class="students">
            <div class="student_box">
                <h1>Available Events</h1>
                <table class="student_table">
                    <thead>
                        <tr>
                            <th>Event Name</th>
                            <th>Host</th>
                            <th>Date & Time</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $sql = "SELECT e.*, u.full_name as host_name 
                                FROM EventShow e 
                                JOIN Users u ON e.host_id = u.user_id";
                        $result = mysqli_query($conn, $sql);
                        if($result && mysqli_num_rows($result) > 0){
                            while($row = mysqli_fetch_assoc($result)){
                                $status_class = ($row['status'] == 'Approved') ? 'bg-approved' : 'bg-pending';
                        ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($row["title"]); ?></strong></td>
                            <td><?php echo htmlspecialchars($row["host_name"]); ?></td>
                            <td><?php echo $row["event_date"]; ?><br><small><?php echo $row["start_time"]; ?></small></td>
                            <td><span class="status-badge <?php echo $status_class; ?>"><?php echo $row["status"]; ?></span></td>
                            <td>
                                <?php if($row['status'] == 'Approved'): ?>
                                    <a href="book_ticket.php?event_id=<?php echo $row['event_id']; ?>&action=confirm" 
                                       class="btn-buy" 
                                       onclick="return confirm('Confirm purchase for ৳ 50.00?');">
                                       Buy Ticket
                                    </a>
                                <?php else: ?>
                                    <span style="color: #999; font-style: italic;">Wait for Approval</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php
                            }
                        } else {
                            echo "<tr><td colspan='5'>No events scheduled yet.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>                
                <br />                
                <h2>Your Purchased Tickets</h2>
                <table class="student_table">
                    <thead>
                        <tr>
                            <th>Ticket ID</th>
                            <th>Event Title</th>
                            <th>Event Date</th>
                            <th>Download</th> </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $sql_my_tickets = "SELECT b.ticket_id, e.title, e.event_date 
                                           FROM Books b 
                                           JOIN EventShow e ON b.event_id = e.event_id 
                                           WHERE b.user_id = '$current_user_id'
                                           ORDER BY b.ticket_id DESC";
                        
                        $res_tickets = mysqli_query($conn, $sql_my_tickets);
                        if($res_tickets && mysqli_num_rows($res_tickets) > 0){
                            while($t = mysqli_fetch_assoc($res_tickets)){
                                echo "<tr>
                                        <td>#".$t['ticket_id']."</td>
                                        <td>".htmlspecialchars($t['title'])."</td>
                                        <td>".$t['event_date']."</td>
                                        <td>
                                            <a href='generate_ticket.php?ticket_id=".$t['ticket_id']."' class='btn-pdf'>
                                               Download PDF
                                            </a>
                                        </td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>You haven't bought any tickets yet.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>