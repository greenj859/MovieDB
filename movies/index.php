<?php

function redirect($url) {
	$username = $_POST['username'];
	Header("Location: ".$url);
}

?>

<?php 
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

//Database credentials
$host = 'localhost';
$db = 'movies';
$usr = 'root';
$pass = '';

// Variables that will hold username and password
// entered by the user
$user = "";
$password = "";

//Create mysqli object
$mysqli = new mysqli($host, $usr, $pass, $db);

//Error handler
if($mysqli->connect_error) {
	printf("Connection to db failed: %s\n", $mysqli->connect_error);
	exit();
}

// Check that user name field is not empty
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST["username"])) {
		$user = $_POST['username'];
	}
}

// Check that password field is not empty
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST["password"])){
		$password = $_POST['password'];

	}
}
// Get list of usernames, passwords, and is_mgr from db
$sql = "SELECT username, password, is_manager FROM users ";
$res = $mysqli->query($sql) or die($mysqli->error.__LINE__);

// Check if entered text matches records
while ($dbusr = $res->fetch_assoc()) {
	//echo $dbusr['username'].$dbusr['password'].$dbusr['is_manager']."<br>";
	// user is a manager
	if($user == $dbusr['username'] && $password == $dbusr['password'] && $dbusr['is_manager'] == 'Y') {
		session_start();
		$_SESSION['username'] = $user;  // Pass current user to next page
		redirect("mgrsearch.php");
		exit;
	}
	// user is not a manager
	else if($user == $dbusr['username'] && $password == $dbusr['password'] && $dbusr['is_manager'] == 'N')
	{
		session_start();
		$_SESSION['username'] = $user;  // Pass current user to next page
		redirect("search.php");
		exit;
	}

}


if($res == false)
	echo 'failed to query'."<br>";

// Close connection
$mysqli->close();
?>
 


<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title> Movies DB</title>
		<link rel="stylesheet" href="css/style.css" type="text/css"/>
		<style>
			.error {color: #FF0000;}
		</style>
</head>
<body>


	<header>
		<div class="container">
			<div id="content">
    			<img src="reel.png" class="ribbon"/>
			</div>
			<h1><font size = "10">A Movie DB</font></h1>
			<h3>A Database for Movie Nerds</h3>
		</div>
	</header>
	<main>
		<div class="container">
			<h4>A Wasteland of Movie Information!</h4>
			<p>Login or sign up to browse</p>
			<form id='login' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method='POST' accept-charset='UTF-8'>
				<fieldset >
					<legend>Login</legend>
					<input type='hidden' name='submitted' id='submitted' value='1'/>
					<label for='username' >User Name:</label>
					<input type='text' name="username" value="<?php echo $user; ?>" required>
					<label for='password' >Password:</label>
					<input type='password' name="password" value="<?php echo $password; ?>" required>
					<input type='submit' name='Submit' value='Submit' />
				</fieldset>
			</form>
			<p> Not currently a user? <a href="signup.php">Sign on up!!</a></p>
			<?php if($user != $dbusr['username'] || $password != $dbusr['password']) : ?>
				<p><a style=color:#FF0000>Incorrect username/password</a></p>
			<?php endif; ?>
		</div>
	</main>
	<footer>
		<div class="container">
			Copyright &copy; 2017 
		</div>
	</footer>
</body>
</html>
