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
$mgr = 'N';

// Variables that will hold data
// entered by the user
$username = "";
$fname = "";
$mname = "";
$lname = "";
$dob = "";
$gender = "";
$password = "";
$confirm = "";
$newdob;
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
		$username = $_POST['username'];
	}
	//echo $username."<br>";
}

// Check that first name field is not empty
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST["fname"])){
		$fname = $_POST['fname'];
	}
	//echo $fname."<br>";
}

// Check that middle name field is not empty
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST["mname"])){
		$mname = $_POST['mname'];
	}
	else {
		$mname = "";
	}
	//echo $mname."<br>";
}

// Check that last name field is not empty
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST["lname"])){
		$lname = $_POST['lname'];
	}
	//echo $lname."<br>";
}

// Check that dob field is not empty
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST["dob"])){
		$dob = $_POST['dob'];
		$newerdob = strtotime($dob);
		$newdob = date('Y-m-d', $newerdob);

		//echo "<br>".$newdob."<br>";
	}
	//echo $dob."<br>";
}

// Check that gender field is not empty
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST["gender"])){
		$gender = $_POST['gender'];
	}
	//echo $gender."<br>";
}

// Check that password field is not empty
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST["pass"])){
		$password = $_POST['pass'];
	}
	//echo $password."<br>";
}

// Check that password matches
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST["confirm"])){
		$confirm = $_POST['confirm'];
	}
	//echo $confirm."<br>";
}
?>

<!DOCTYPE HTML> 
<html> 
<head> 
	<meta charset="utf-8" />
	<title>Sign-Up</title> 
	<link rel="stylesheet" href="css/signup.css" type="text/css"/>
</head> 
<body id="body-color"> 
	<div id="container">
	<header>
		<div class="container">
			<div id="content">
    			<img src="reel.png" class="ribbon"/>
			</div>
			<h1><font size = "10">A Movie DB</font></h1>
			<h3>A Database for Movie Nerds</h3>
		</div>
	</header> 
	<fieldset style="width:50%">	
	<legend>Registration Form</legend> 
	<table border="0"> 

		<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
		<tr>
			<td>Username</td><td> <input type="text" name="username" value="<?php echo $username; ?>" required></td>
		</tr> 
		<tr>
			<td>First Name</td><td> <input type="text" name="fname" value="<?php echo $fname; ?>" required></td>
		</tr> 
		<tr> 
			<td>Middle Name (optional)</td><td> <input type="text" name="mname" value="<?php echo $mname; ?>" required></td> 
		</tr> 
		<tr> 
			<td>Last Name</td><td> <input type="text" name="lname" value="<?php echo $lname; ?>" required></td> 
		</tr> 
		<tr> 
			<td>Date of Birth ("yyyy-mm-dd")</td><td> <input type="text" name="dob" value="<?php echo $dob; ?>" required></td> 
		<tr>
			<td>Gender</td>
				<td>
					<input type="radio" name="gender" value="F"> Female 
					<input type="radio" name="gender" value="M"> Male 
					<input type="radio" name="gender" value="N"> Nunya 
				</td>	
		</tr> 
		<tr> 
			<td>Password</td><td> <input type="password" name="pass" value="<?php echo $password; ?>" required></td> 
		</tr> 
		<tr> 
			<td>Confirm Password</td><td><input type="confirm" name="confirm" value="<?php echo $confirm; ?>" required></td> 
		</tr> 
		<tr>
			<?php if ($password != $confirm) {
						echo "<p><a style= color:#FF0000>Passwords Entered Do Not Match </a></p>";
						redirect("signup.php");
						exit;
					}
					else if ($password == $confirm && $password != ""){
						$sql = "INSERT INTO users (username, password, lname, fname, gender, dob, is_manager) VALUES ('$username', '$password', '$lname', '$fname', '$gender', '$newdob', '$mgr')";
						echo $sql;
						if ($res = $mysqli->query($sql) == false) {
							die($mysqli->error.__LINE__);
						}
						else{
							$mysqli->close();
							session_start();
							$_SESSION['username'] = $username;  // Pass current user to next page
							redirect("search.php");
							exit;
						}
					}


			//$mysqli->close();
			//exit;
			?>
		</tr>
		<tr> 
			<td><input id="button" type="submit" name="submit" value="Sign-Up"></td> 
		</tr> 
		</form> 
	</table> 
	</fieldset> 
	</div>
	<footer>
		<div class="container">
			Copyright &copy; 2017 
		</div>
	</footer> 
</body> 
</html>




