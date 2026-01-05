<?php
require_once('DBconnect.php');
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['type'] !== 'Admin') {
    header("Location: index.php");
    exit();
}

if (isset($_GET['id']) && isset($_GET['new_status'])) {
    $user_id = mysqli_real_escape_string($conn, $_GET['id']);
    $new_status = mysqli_real_escape_string($conn, $_GET['new_status']);
    if ($new_status === 'verified' || $new_status === 'blocked') {
        $update_sql = "UPDATE Users SET is_verified = '$new_status' WHERE user_id = '$user_id'";
        
        if (mysqli_query($conn, $update_sql)) {
            header("Location: verification.php"); 
            exit();
        } else {
            die("Error updating record: " . mysqli_error($conn));
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Admin - User Verification | EventNexus</title>
    <link rel="stylesheet" href="css/style.css" />
    <style>
        .badge { padding: 5px 10px; border-radius: 4px; color: white; font-weight: bold; }
        .badge-verified { background-color: #27ae60; } 
        .badge-blocked { background-color: #e74c3c; }  
        .btn-action { text-decoration: none; padding: 5px 10px; border-radius: 4px; border: 1px solid #ccc; background: #f9f9f9; color: black; display: inline-block; }
        .btn-action:hover { background: #eee; }
    </style>
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
    <main>
        <section class="students">
            <div class="student_box">
                <h1>User Verification Status</h1>
                <table class="student_table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Current Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $current_admin = $_SESSION['user_id'];
                        $sql = "SELECT * FROM Users WHERE user_id != '$current_admin' ORDER BY user_id DESC";
                        $result = mysqli_query($conn, $sql);

                        if(mysqli_num_rows($result) > 0){
                            while($row = mysqli_fetch_assoc($result)){
                                $current_status = $row['is_verified'];
                                if ($current_status == 'verified') {
                                    $toggle_to = 'blocked';
                                    $btn_text = "Block User";
                                    $badge_class = "badge-verified";
                                    $btn_color = "color: #c0392b;";
                                } else {
                                    $toggle_to = 'verified';
                                    $btn_text = "Verify User";
                                    $badge_class = "badge-blocked";
                                    $btn_color = "color: #27ae60;";
                                }
                        ?>
                        <tr>
                            <td><?php echo $row["user_id"]; ?></td>
                            <td><?php echo htmlspecialchars($row["username"]); ?></td>
                            <td><?php echo htmlspecialchars($row["email"]); ?></td>
                            <td><?php echo $row["type"]; ?></td>
                            
                            <td>
                                <span class="badge <?php echo $badge_class; ?>">
                                    <?php echo ucfirst($current_status); ?>
                                </span>
                            </td>

                            <td>
                                <a href="verification.php?id=<?php echo $row['user_id']; ?>&new_status=<?php echo $toggle_to; ?>" 
                                   class="btn-action" 
                                   style="<?php echo $btn_color; ?>"
                                   onclick="return confirm('Are you sure you want to change status to <?php echo $toggle_to; ?>?');">
                                   <?php echo $btn_text; ?>
                                </a>
                            </td>
                        </tr>
                        <?php
                            }
                        } else {
                            echo "<tr><td colspan='6'>No other users registered.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>