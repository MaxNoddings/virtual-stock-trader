<?php
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  
  session_start();

  include("connection.php");
  include("functions.php");

  
  if($_SERVER['REQUEST_METHOD'] == "POST") {
      // something was posted
      $user_name = isset($_POST['user_name']) ? $_POST['user_name'] : '';
      $password = isset($_POST['password']) ? $_POST['password'] : '';

      if (!empty($user_name) && !empty($password) && !is_numeric($user_name)) {
          // read from database
          $query = "SELECT * FROM users WHERE user_name = '$user_name' LIMIT 1";
          $result = mysqli_query($con, $query);

          if ($result) {
            if ($result && mysqli_num_rows($result) > 0) {
              $user_data = mysqli_fetch_assoc($result);

              if (password_verify($password, $user_data['password'])) {
                $_SESSION['user_id'] = $user_data['user_id'];
                header("Location: my-portfolio.php");
                die;
              }
            }
          }
          echo "Wrong username or password";
      }
      else {
          echo "Enter valid username and password";
      }
    
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">

    <title>Login</title>
  </head>

  <body>
    <style type="text/css">
        #text {
            height: 25px;
            border-radius: 5px;
            padding: 4px;
            border: solid thin #aaa;
            width: 100%;
        }

        #button {
            padding: 10px;
            width: 100px;
            color: white;
            background-color: lightblue;
            border: none;
        }

        #box {
            background-color: grey;
            margin: auto;
            width: 300px;
            padding: 20px;
        }
    </style>

    <div id="box">
        <form method="post">
            <div style="font-size: 20px; margin: 10px; color: white;">Login</div>
            <input id="text" type="text" name="user_name" placeholder="username"><br><br>
            <input id="text" type="password" name="password" placeholder="password"><br><br>

            <input id="button" type="submit" value="Login"><br><br>
            <a href="signup.php">Click to Sign Up</a>
            <br>
            <a href="http://localhost/finalProject/homepage-standard.php">Go to Homepage</a>
        </form>
    </div>
  </body>
</html> 