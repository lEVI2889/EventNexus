<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&display=swap" rel="stylesheet" />
    <title>User Restricted | EventNexus</title>
  </head>
  <body>
    <header>
      <nav>
        <div class="nav_logo">
          <h1><a href="home_unverified.php">EventNexus</a></h1>
        </div>
        <ul class="nav_link">
          <li><a href="index.php">Logout</a></li>
        </ul>
      </nav>
    </header>
    <main>
      <section class="login_box" style="max-width: 600px; text-align: center;">
          <h1 style="color: #ff4d4d; margin-bottom: 20px;">Access Restricted</h1>
          
          <p style="color: white; line-height: 1.6; margin-bottom: 30px;">
            Your account is currently <strong>Blocked</strong> by an <strong>Admin</strong>. 
            You will not be able to access the dashboard until an <strong>Admin</strong> approves your status.
          </p>

          <div style="padding: 15px; background: rgba(255, 255, 255, 0.05); border-radius: 8px; border: 1px solid rgba(255,255,255,0.1);">
              <p style="font-size: 0.9rem; color: #ccc;">
                Call Admin HQ at +8801234-56789 and say SORRY! They may unblock you!
              </p>
          </div>

          <a href="index.php" class="btn" style="float: none; display: inline-block; margin-top: 30px; width: 200px;">
            Back to Login
          </a>
      </section>
    </main>
  </body>
</html>
