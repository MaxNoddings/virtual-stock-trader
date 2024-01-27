<?php
    session_start();

    include("connection.php");

    
    if($_SERVER['REQUEST_METHOD'] == "POST") {
        // something was posted
        $stock_ticker = isset($_POST['stock_ticker']) ? $_POST['stock_ticker'] : '';
        $company_name = isset($_POST['company_name']) ? $_POST['company_name'] : '';
        $current_price = isset($_POST['current_price']) ? $_POST['current_price'] : '';
        $volume = isset($_POST['volume']) ? $_POST['volume'] : '';
        $market_cap = isset($_POST['market_cap']) ? $_POST['market_cap'] : '';

        if (!empty($stock_ticker) && !empty($company_name) && !empty($current_price) && !empty($volume) && !empty($market_cap)) {
            $query = "INSERT INTO stocks (stock_ticker, company_name, current_price, volume, market_cap) VALUES ('$stock_ticker', '$company_name', '$current_price', '$volume', '$market_cap')";
            mysqli_query($con, $query);

            header("Location: homepage-standard.php");
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
    <title> Add Stock </title>
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gabarito:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nanum+Gothic+Coding:wght@400;700&display=swap" rel="stylesheet">
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

        #numeric {
            height: 25px;
            border-radius: 5px;
            padding: 4px;
            border: solid thin #aaa;
            width: 100%;
        }

        #button {
            padding: 10px;
            width: 100px;
            color: black;
            background-color: white;
            border: none;
            cursor: pointer;
        }

        #button:hover {
            background-color: rgb(0, 207, 207);
        }

        #box {
            background-color: black;
            border-radius: 40px;
            margin: auto;
            margin-top: 30px;
            width: 300px;
            padding: 50px;
            font-family: 'Nanum Gothic Coding', monospace;
        }
    </style>

<div id="header">
      <div class="title-search">
        <div id="title"><a href="http://localhost/finalProject/homepage-standard.php" id="login">Stock Game</a></div>
      </div>
      <div class="login-signup">
        <div><a href="http://localhost/finalProject/my-portfolio.php" id="login">My Portfolio</a></div>
          <?php 
            session_start();

            if (isset($_SESSION['user_id'])) {
              echo '<div><a href="http://localhost/finalProject/logout.php" id="login">Logout</a></div>';
            }
            else {
              echo '<div><a href="http://localhost/finalProject/login.php" id="login">Login</a></div>';
            }
          ?>
      </div>
    </div>    

<div id="box">
        <form method="post">
            <div style="font-size: 20px; margin: 10px; color: white;">Company Name</div>
            <input id="text" type="text" name="company_name" placeholder="company name"><br><br>
        
            <div style="font-size: 20px; margin: 10px; color: white;">Stock Ticker</div>
            <input id="text" type="text" name="stock_ticker" placeholder="stock ticker"><br><br>

            <div style="font-size: 20px; margin: 10px; color: white;">Current Price</div>
            <input id="numeric" type="number" name="current_price" step="any" placeholder="current price"><br><br>

            <div style="font-size: 20px; margin: 10px; color: white;">Volume</div>
            <input id="numeric" type="number" name="volume" placeholder="volume"><br><br>

            <div style="font-size: 20px; margin: 10px; color: white;">Market Cap</div>
            <input id="numeric" type="number" name="market_cap" placeholder="market cap"><br><br>

            <input id="button" type="submit" value="Submit"><br><br>
        </form>
    </div>

    <div class="footer">
      <div>
        <div>Max Noddings</div>
        <div>mnodd4@gmail.com</div>
      </div>
      <div>
        <div><a class="footer-links" href="https://github.com/MaxNoddings">GitHub</a></div>
        <div><a class="footer-links" href="https://www.linkedin.com/in/max-noddings/">LinkedIn</a></div>
      </div>
    </div>
  </body>
</html> 