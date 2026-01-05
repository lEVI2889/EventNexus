<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&display=swap" rel="stylesheet" />
    <title> Login | EventNexus </title>
    <style>
      .error-msg {
          color: #ff4d4d;
          background: rgba(255, 77, 77, 0.1);
          padding: 10px;
          border-radius: 4px;
          margin-bottom: 15px;
          text-align: center;
          font-size: 0.9rem;
      }
    </style>
  </head>
  <body>
    <header>
      <nav>
        <div class="nav_logo">
          <h1><a href="index.php">EventNexus</a></h1>
        </div>
        <ul class="nav_link">
          <li><a href="new_user.php">Sign Up</a></li>
        </ul>
      </nav>
    </header>
    <main>
      <section class="login">
        <div class="login_box">
          <h1>Login</h1>

          <?php if(isset($_GET['error']) && $_GET['error'] == 'invalid'): ?>
            <p class="error-msg">
                Invalid username or passcode. Please try again.
            </p>
          <?php endif; ?>

          <?php if(isset($_GET['error']) && $_GET['error'] == 'InvalidUserType'): ?>
            <p class="error-msg">
                Your account type is not recognized. Please contact Admin.
            </p>
          <?php endif; ?>

          <form class="login_form" action="login.php" method="post">
            <input
              type="text"
              id="username"
              name="username"
              placeholder="Username"
              required
            />
            <input
              type="password"
              id="password"
              name="password"
              placeholder="Password"
              required
            />
            <input type="submit" value="Login" />
          </form>
          <p style="text-align: center; margin-top: 15px; color: #ccc;">
            New here? <a href="new_user.php" style="color: #bb86fc;">Create New Account</a>
          </p>
        </div>
      </section>
    </main>
  </body>
</html>