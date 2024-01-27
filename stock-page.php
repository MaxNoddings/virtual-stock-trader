<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title> Stock Page </title>
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gabarito:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nanum+Gothic+Coding:wght@400;700&display=swap" rel="stylesheet">   
  </head>

  <body>
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
    </div>

    <?php 
      // This is the link
      $stock_ticker = $_GET["stock_ticker"];
    ?> 

    <div class="column-header"><?php echo $stock_ticker ?></div>
    
    <div class="content"> 
      <div id="chart-area">
        <?php
          // Connect and sleect the "test" database
          $mysqli = new mysqli("localhost", "root", "", "loginSignUp");
          if ($mysqli->connect_errno) {
            die("Connection Failed: ($mysqli->connect_errno) $mysqli->connect_error");
          }
        ?>


        <?php
          // Select everything in the table
          $sql = "SELECT * FROM stocks WHERE stock_ticker='$stock_ticker'";
          
          // Issue the query
          $result = $mysqli->query($sql);
          if (!$result) {
            die("Query Error: ($mysqli->errno) $mysqli->error<br>SQL = $sql");
          }
        ?> 


        <table class="stock-info">
          <?php while ($row = $result->fetch_row()) { ?>
            <tr>
              <td>Company Name: <span class="bolded-text"><?php echo $row[2]; ?></span></td>
            </tr>
            <tr>
              <td>Share Price: <span class="price">$<?php echo $row[3]; ?></span></td>
            </tr>
            <tr>
              <td style=""><img class="fit-width" src="<?=$row[4];?>"></td>
            </tr>
          <?php } ?>
        </table>

      </div>
      <div id="stocks" style="font-family: 'Nanum Gothic Coding', monospace"> 
        <div class="bolded-text">Buy Stock</div>
        <form action="buy_stock.php" method="post">
          <input type="hidden" name="stock_ticker" value="<?php echo $stock_ticker; ?>">

          <label for="shares">Number of Shares:</label>
          <input type="number" name="shares" id="shares" required value="<?php echo isset($_POST['shares']) ? htmlspecialchars($_POST['shares']) : ''; ?>">

          <input type="submit" value="Buy" class="button">
        </form>

        <br><br>

        <div class="bolded-text">Sell Stock</div>
        <form action="sell_stock.php" method="post">
          <input type="hidden" name="stock_ticker" value="<?php echo $stock_ticker; ?>">

          <label for="shares">Number of Shares:</label>
          <input type="number" name="shares" id="shares" required value="<?php echo isset($_POST['shares']) ? htmlspecialchars($_POST['shares']) : ''; ?>">

          <input type="submit" value="Sell" class="button">
        </form>
      </div>
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
