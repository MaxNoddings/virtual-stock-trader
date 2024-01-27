<?php
    session_start();

    include("connection.php");
    include("functions.php");

    
    if($_SERVER['REQUEST_METHOD'] == "POST") {
        // something was posted
        $user_name = isset($_POST['user_name']) ? $_POST['user_name'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        if (!empty($user_name) && !empty($password) && !is_numeric($user_name)) {
            // save to database, hash the password
            $user_id = random_num(20);
            $query = "INSERT INTO users (user_id, user_name, password) VALUES ('$user_id', '$user_name', '$passwordHash')";
            mysqli_query($con, $query);

            header("Location: login.php");
            die;
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

    <title>Sign Up</title>
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
            <div style="font-size: 20px; margin: 10px; color: white;">Sign Up</div>
            <input id="text" type="text" name="user_name" placeholder="username"><br><br>
            <input id="text" type="password" name="password" placeholder="password"><br><br>

            <input id="button" type="submit" value="Signup"><br><br>
            <a href="login.php">Click to Login</a>
            <br>
            <a href="http://localhost/finalProject/homepage-standard.php">Go to Homepage</a>
        </form>
    </div>
  </body>
</html> 