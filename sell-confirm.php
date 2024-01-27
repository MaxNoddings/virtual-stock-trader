<!--
// Create Confirmation Page, Add link to go back to my portfolio or stock list
// Add/Insert stock to portfolio function
// Create form to sell a stock

// Delete stock from portfolio function
// Display portfolio in My Portfolio page, display Order and Timestamp on Main Stock List Homepage
// Calculate New Portfolio price with changing stock price function
// Make everything look pretty
// Hook up live stock API

// Pages should include images
// Every page should have a footer with contact information
// should be mobile friendly
// protect un-logged in users from buying a stock
// hash passwords
// Make sure the buy/sell stock form is sticky






// Fetch stock information from the database
// Calculate total purchase price based on stock price and number of shares

// Insert data into transactions table
// $insert_query = "INSERT INTO transactions (user_id, stock_id, shares_owned, purchase_price) VALUES ($user_id, $stock_id, $shares, $total_price)";

// Execute the query

// Update the user's portfolio and balance

// Redirect the user to a success page or back to the stock page
?>
-->

<?php
    // Connect to the database
    $mysqli = new mysqli("localhost", "root", "", "loginSignUp");
    if ($mysqli->connect_errno) {
    die("Connection Failed: ($mysqli->connect_errno) $mysqli->connect_error");
    }

    // Assuming you have session handling for user authentication
    session_start();

    // Session variables to php variables
    $user_id = $_SESSION['user_id'];
    $stock_id = $_SESSION['stock_id'];
    $shares = $_SESSION['shares'];
    $purchase_price = $_SESSION['purchase_price'];
    
    // Insert data into transactions table using SQL query
    $sql = "INSERT INTO transactions (user_id, stock_id, shares, purchase_price, transaction_type) VALUES ($user_id, $stock_id, $shares, $purchase_price, 'sell')";
    // Issue the query
    $result = $mysqli->query($sql);
    if (!$result) {
        echo "Dying";
    die("Query Error: ($mysqli->errno) $mysqli->error<br>SQL = $sql");
    }

    // Check the database to see if it shows up!
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title> Sell Confirmation Page </title>
	</head>
<body>
	<h3>
		Your sell order of ____ has been confirmed!
	</h3>

    <br><br>

	<a href="http://localhost/finalProject/homepage-standard.php"> Back to the Homepage </a>

    <br><br>

	<a href="http://localhost/finalProject/my-portfolio.php"> My Portfolio </a>
	
</body>
</html>