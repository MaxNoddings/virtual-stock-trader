<?php 
    
    session_start();
    
    include("connection.php");
    include("functions.php");

    $user_data = check_login($con);

    $mysqli = new mysqli("localhost", "root", "", "loginSignUp");
    if ($mysqli->connect_errno) {
      die("Connection Failed: ($mysqli->connect_errno) $mysqli->connect_error");
    }
    
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title> My Portfolio </title>
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

    <div class="column-header">My Portfolio</div>

    <br>
    
    <div class="content" id="my-portfolio"> 
      <div class="left-column">
        <?php 
          // Get the user_id from the signed in user
          $user_id = $_SESSION['user_id'];

          // Select everything in the table
          $sql = "SELECT t.stock_id, s.stock_ticker, s.company_name,
                  SUM(CASE WHEN t.transaction_type = 'buy' THEN t.shares ELSE 0 END) AS total_buy_shares,
                  SUM(CASE WHEN t.transaction_type = 'sell' THEN t.shares ELSE 0 END) AS total_sell_shares,
                  (SUM(CASE WHEN t.transaction_type = 'buy' THEN t.shares ELSE 0 END) - 
                  SUM(CASE WHEN t.transaction_type = 'sell' THEN t.shares ELSE 0 END)) AS shares_owned,
                  s.current_price AS current_price,
                  s.current_price * (SUM(CASE WHEN t.transaction_type = 'buy' THEN t.shares ELSE 0 END) - 
                  SUM(CASE WHEN t.transaction_type = 'sell' THEN t.shares ELSE 0 END)) AS value
                  FROM transactions t
                  JOIN stocks s ON t.stock_id = s.stock_id
                  WHERE t.user_id = $user_id
                  GROUP BY t.stock_id, s.stock_ticker, s.company_name
                  HAVING shares_owned > 0
                  ORDER BY s.stock_ticker";

          // Issue the query
          $result = $mysqli->query($sql);
          if (!$result) {
            die("Query Error: ($mysqli->errno) $mysqli->error<br>SQL = $sql");
          }

          // Check if there are stocks
          if ($result->num_rows > 0) {
            echo "<table class='stock-table'>";
            echo "<tr><th>Stock Ticker</th><th>Company Name</th><th>Shares Owned</th><th>Current Stock Price</th><th>Value</th></tr>";

            // Output data for each row
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['stock_ticker']}</td>";
                echo "<td>{$row['company_name']}</td>";
                echo "<td>{$row['shares_owned']}</td>";
                echo "<td>$"."{$row['current_price']}"."</td>";
                echo "<td>$"."{$row['value']}"."</td>";  
                echo "</tr>";

                // Update total portfolio value
                $totalPortfolioValue += $row['value'];
            }

            echo "</table>";

            // Display the total portfolio value
            echo "<br><p class='bolded-text'>Total Portfolio Value: <span class='price'>$$totalPortfolioValue</span></p>";

            // Subtract the total portfolio value from the user's cash
            $updateCash = "UPDATE users SET cash = cash - $totalPortfolioValue WHERE user_id = $user_id";
            $resultUpdateCash = $mysqli->query($updateCash);

            if ($resultUpdateCash) {
                // good
            } else {
                echo "Error updating cash: ($mysqli->errno) $mysqli->error<br>SQL = $updateCash";
            }

            // Print out cash value
            $cash = 100000 - $totalPortfolioValue;
            echo "<p class='bolded-text'>Buying Power: <span class='price'>$$cash</span></p>";
            } 
            else {
                echo "No stocks found in the user's portfolio.";
            }
        ?>
      </div>
        
      <div class="right-column">
        <div class="column-header" id="page-title">Past Trades</div>
        <?php 
            // Get the user_id from the signed in user
            $user_id = $_SESSION['user_id'];

            // Select everything in the table
            $sql = "SELECT t.stock_id, s.stock_ticker, t.shares, t.purchase_price, t.purchase_date, t.transaction_type,
                    t.purchase_price / t.shares AS stock_share_price
                    FROM transactions t
                    JOIN stocks s ON t.stock_id = s.stock_id
                    WHERE t.user_id = $user_id
                    ORDER BY t.purchase_date DESC";

            // Issue the query
            $result = $mysqli->query($sql);
            if (!$result) {
              die("Query Error: ($mysqli->errno) $mysqli->error<br>SQL = $sql");
            }

            // Check if there are transactions
            if ($result->num_rows > 0) {
              echo "<table class='stock-table'>";
              echo "<tr><th>Stock Ticker</th><th>Shares</th><th>Purchase Price</th><th>Stock Share Price</th><th>Purchase Date</th><th>Transaction Type</th></tr>";

              // Output data for each row
              while ($row = $result->fetch_assoc()) {
                  echo "<tr>";
                  echo "<td>{$row['stock_ticker']}</td>";
                  echo "<td>{$row['shares']}</td>";
                  echo "<td>$"."{$row['purchase_price']}"."</td>";
                  echo "<td>$".number_format($row['stock_share_price'], 2)."</td>";  
                  echo "<td>{$row['purchase_date']}</td>";
                  echo "<td>{$row['transaction_type']}</td>";
                  echo "</tr>";
              }

              echo "</table>";
              } else {
                  echo "No transactions found for the user.";
              }

            // Close the database connection
            $mysqli->close();
          ?>
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