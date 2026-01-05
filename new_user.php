<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/style.css" />
    <title> Register | EventNexus </title>
  </head>
  <body>
    <header>
      <nav>
        <div class="nav_logo">
          <h1><a href="index.php">EventNexus</a></h1>
        </div>
        <ul class="nav_link">
          <li><a href="index.php">Sign In</a></li>
        </ul>
      </nav>
    </header>
    <main>
      <section class="add_student">
        <div class="add_student_box">
          <h1>Create Account</h1>
          <form class="add_student_form" action="insert_user.php" method="post">
            
            <label>Username</label>
            <input type="text" name="username" placeholder="Choose a unique username" required> 
            
            <label>Password</label>
            <input type="password" name="passcode" placeholder="Create a password" required> 
            
            <label>Full Name</label>
            <input type="text" name="full_name" placeholder="Enter your full name" required> 
            
            <label>Email</label>
            <input type="email" name="email" placeholder="Provide email address" required> 

            <label>User Type:</label>
            <select name="type" required style="width: 100%; padding: 10px; margin-bottom: 20px; border-radius: 5px;">
                <option value="" disabled selected>Select Account Type</option>
                <option value="Customer">Customer</option>
                <option value="Host">Host</option>
                <option value="Merchant">Merchant</option>
                <option value="Admin">Admin</option>
            </select>

            <input type="submit" value="Register" />
          </form>
        </div>
      </section>
    </main>
  </body>
</html>