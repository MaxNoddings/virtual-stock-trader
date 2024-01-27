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

Sell Stock Page 
<br>
<?php        
// Connect to the database
$mysqli = new mysqli("localhost", "root", "", "loginSignUp");
if ($mysqli->connect_errno) {
die("Connection Failed: ($mysqli->connect_errno) $mysqli->connect_error");
}

// Assuming you have session handling for user authentication
session_start();

// Get user ID from the session
$user_id = $_SESSION['user_id'];

// Get form data - get stock ticker
$stock_ticker = $_POST['stock_ticker'];
$_SESSION['stock_ticker'] = $stock_ticker;
$print = $stock_ticker." ";
echo $print;

// Get stock id
$sql = "SELECT stock_id FROM stocks WHERE stock_ticker='$stock_ticker'";
// Issue the query
$result = $mysqli->query($sql);
if (!$result) {
    echo "Dying";
  die("Query Error: ($mysqli->errno) $mysqli->error<br>SQL = $sql");
}
$row = $result->fetch_assoc();
echo $row["stock_id"]." ";
$_SESSION['stock_id'] = $row["stock_id"];
$stock_id = $_SESSION['stock_id'];

// Get stock id
$sql = "SELECT current_price FROM stocks WHERE stock_ticker='$stock_ticker'";
// Issue the query
$result = $mysqli->query($sql);
if (!$result) {
    echo "Dying";
  die("Query Error: ($mysqli->errno) $mysqli->error<br>SQL = $sql");
}
$row = $result->fetch_assoc();
echo $row["current_price"]." ";
$_SESSION['current_price'] = $row["current_price"];
$current_price = $_SESSION['current_price'];

$shares = $_POST['shares'];
$_SESSION['shares'] = $shares;
echo $shares." ";

$purchase_price = $shares * $current_price;
$_SESSION['purchase_price'] = $purchase_price;
echo "Total Selling Price: $" . number_format($purchase_price, 2)." ";
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title> Buy Stock Page </title>
	</head>
    <body>
        <br><br>
        <a href="javascript:void(0);" onclick="history.back();">Go Back to the Stock Page</a>
        <br><br>
        <a href="http://localhost/finalProject/sell-confirm.php"> Submit Stock Sell </a>
        
    </body>
</html>
