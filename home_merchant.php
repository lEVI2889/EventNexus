<?php
session_start();
require_once('DBconnect.php');
if (!isset($_SESSION['user_id']) || $_SESSION['type'] !== 'Merchant') {
    header("Location: index.php");
    exit();
}
$user_id = $_SESSION['user_id'];
$query = "SELECT u.full_name, u.username FROM Users u 
          JOIN Merchant m ON u.user_id = m.user_id 
          WHERE u.user_id = '$user_id'";
$result = mysqli_query($conn, $query);
$merchant_data = mysqli_fetch_assoc($result);
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
    <title>Merchant Dashboard | EventNexus</title>
  </head>
  <body>
    <header>
      <nav>
        <div class="nav_logo">
          <h1><a href="home_merchant.php">EventNexus</a></h1>
        </div>
        <ul class="nav_link">
          <li><a href="book_stall.php">Book Stall</a></li>
          <li><a href="logout.php">Logout</a></li>
        </ul>
      </nav>
    </header>
    <main>
      <section class="welcome_msg" style="text-align: center; margin-bottom: 40px;">
            <h1 style="color: white; font-weight:400; font-size: 2.5rem;">
                Welcome, <span style="color: green; font-weight: 600;"><?php echo htmlspecialchars($merchant_data['full_name']); ?></span>!
          </h1>
          <p style="color: #ccc; margin-top: 10px;">Logged in as Merchant: <?php echo htmlspecialchars($merchant_data['username']); ?></p>
          <div style="margin-top: 20px;">
              <a href="book_stall.php" class="btn" style="background-color: #03dac6; color: black; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: 500;">
                  Browse Events & Book Stalls
              </a>
          </div>
      </section>
    </main>
  </body>
</html>