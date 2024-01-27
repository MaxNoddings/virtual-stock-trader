<?php
	$mysqli = new mysqli("localhost", "root", "", "loginSignUp");
	if ($mysqli->connect_errno) {
		die("Connection Failed: ($mysqli->connect_errno) $mysqli->connect_error");
	}
?>

<?php
	// Select everything in the table
	$sql = "SELECT DISTINCT stock_ticker FROM stocks";
	
	// Issue the query
	$result = $mysqli->query($sql);
	if (!$result) {
		die("Query Error: ($mysqli->errno) $mysqli->error<br>SQL = $sql");
	}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title> Homepage </title>
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
    
    <br><br>

    <div class="content"> 
      <div class="left-column"> 
        <div class="column-header"> Buy Stocks </div> <br>

        <table class="ticker-table" style="border:solid;">
          <?php
          $var = ""
          ?>
          <?php while ($row = $result->fetch_row()) { ?>
            <?php
            $var = $row;
            ?>
            <tr>
              <?php $url = "stock-page.php?stock_ticker=".$row[0]; ?>
              <td> <a href="<?php echo $url; ?>"><?= $row[0]; ?></a></td>
            </tr>
          <?php } ?>
        </table>
        
        <br><br>
        <!-- Link to Add a stock (only shows up when the admin is logged in)-->
        <?php
          // Start or resume the session
          session_start();

          // Check if the user is logged in
          if (isset($_SESSION['user_id'])) {
              // Specific user's ID to compare
              $specificUserId = 4365; 

              // Check if the logged-in user is the specific user
              if ($_SESSION['user_id'] == $specificUserId) {
                  // Display the link for the specific user
                  echo '<a id="add-stock" href="http://localhost/finalProject/add-stock.php">Add Stock</a>';
              }
          }
        ?>
      </div>

      <div class="right-column">
        <div class="column-header">Order History</div> 
        <?php
          $sql = "SELECT t.user_id, u.user_name, t.stock_id, s.stock_ticker, t.purchase_price, t.shares, t.purchase_date, t.transaction_type,
                  t.purchase_price / t.shares AS stock_share_price
                  FROM transactions t
                  JOIN users u ON t.user_id = u.user_id
                  JOIN stocks s ON t.stock_id = s.stock_id
                  ORDER BY t.purchase_date DESC";

          // Issue the query
          $result = $mysqli->query($sql);
          if (!$result) {
            die("Query Error: ($mysqli->errno) $mysqli->error<br>SQL = $sql");
          }

          // Check if there are transactions
          if ($result->num_rows > 0) {
            echo "<table border='0' class='stock-table'>";
              echo "<tr><th>Username</th><th>Stock</th><th>Stock Share Price</th><th>Shares</th><th>Purchase Price</th><th>Purchase Date</th><th>Transaction Type</th></tr>";

              // Output data for each row
              while ($row = $result->fetch_assoc()) {
                  echo "<tr>";
                  echo "<td>{$row['user_name']}</td>";
                  echo "<td>{$row['stock_ticker']}</td>";
                  echo "<td>$".number_format($row['stock_share_price'], 2)."</td>";
                  echo "<td>{$row['shares']}</td>";
                  echo "<td>$"."{$row['purchase_price']}"."</td>";
                  echo "<td>{$row['purchase_date']}</td>";
                  echo "<td>{$row['transaction_type']}</td>";
                  echo "</tr>";
              }
            echo "</table>";
          } else {
            echo "No transactions found.";
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
