<?php 
function logout() {
	Header("Location: index.php");
	$_SESSION = array();
	session_destroy();
	exit;
}

function redirect($url) {
	$username = $_POST['username'];
	Header("Location: ".$url);
}

function refresh() {
	header('Refresh: 0'); // 0 = seconds
}


error_reporting(E_ALL);
ini_set('display_errors', 1);

//Database credentials
$host = 'localhost';
$db = 'movies';
$usr = 'root';
$pass = '';
$mng = "";     // Manage

// get current user
session_start();
$user = $_SESSION['username']; 
//echo $user;

// Retrieve movie title from url
$title = "";
if (isset($_SESSION['serial'])) {
	$mng = $_SESSION['serial'];
}

if (isset($_GET["serial"])){
	$mng = htmlspecialchars($_GET["serial"]);
}
//echo $title;
// Variables that will hold user details
$uid = "";
$fname = "";
$mname = "";
$lname = "";
$dob = "";
$gender = "";
$is_manager = "";
$other = "";

//Create mysqli object
$mysqli = new mysqli($host, $usr, $pass, $db);

//Error handler
if($mysqli->connect_error) {
	printf("Connection to db failed: %s\n", $mysqli->connect_error);
	exit();
}

// Query db and get user information
$sql = "SELECT * FROM users WHERE username = '$mng'";
if($sql) {
	$data = $mysqli->query($sql) or die($mysqli->error.__LINE__);
	$details = mysqli_fetch_assoc($data);
	$uid = $details['usr_id'];
	$fname = $details['fname'];
	$mname = $details['mname'];
	$lname = $details['lname'];
	$dob = $details['dob'];
	$gender = $details['gender'];
	$is_manager = $details['is_manager'];

} 

?>

<!DOCTYPE html>
<html>
	<head>
	<meta charset="utf-8" />
	<title> Movies DB</title>
	<link rel="stylesheet" href="css/style.css" type="text/css"/>
	<style>
		.inline-headers h4 {
  				display: inline-block;
  				vertical-align: baseline;
  				padding-right: 1cm;
		}
		table {
    		font-family: arial, sans-serif;
    		border-collapse: collapse;
    		width: 80%;
		}

		td, th {
    		border: 1px solid #dddddd;
    		text-align: left;
    		padding: 8px;
		}

		tr:nth-child(even) {
    		background-color: #dddddd;
		}
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
		<h1><strong><b><?php echo $mng?></b></strong></h1>		
		<div class="row">
  			<div class="col-md-12">
    			<div class="well inline-headers">
      			<h4>First Name: <?php echo $fname?></h4>
      			<h4>Middle Name: <?php echo $mname?> </h4>
      			<h4>Last Name: <?php echo $lname?></h4>
    			</div>
  			</div>
		</div>
		<div class="row">
  			<div class="col-md-12">
    			<div class="well inline-headers">
      			<h4>Date of Birth: <?php echo $dob?></h4>
      			<h4>Gender: <?php echo $gender?> </h4>
      			<h4>Is Manager: <?php echo $is_manager?>
      		</div>
  			</div>
		</div>
      <h4>Make a Manager? </h4>
      	<form name="search" method="POST" >
				<select name="update" id="update">
					<option value="N">N</option>
					<option value="Y">Y</option>
				</select>
				<input type="submit" value="update" />
			</form>
			<?php
					if ($_SERVER['REQUEST_METHOD'] == 'POST') {
						if(isset($_POST['update'])) {
							$update = $_POST['update'];
							//echo "updated to ".$update;
							$sql = "UPDATE users SET is_manager='$update' WHERE usr_id = '$uid'";

							// Update is_manager for this user
							if($sql) {
								if ($data = $mysqli->query($sql) == false) {
									die($mysqli->error.__LINE__);
								}
							}
						}
						refresh();
					}
			?>
			<form name="delete" method="POST" >
				<input type="submit" name="delete" value="Delete This User" />
				<?php 
					if ($_SERVER['REQUEST_METHOD'] == 'POST') {
						if(isset($_POST['delete'])) {
							//echo "Deleting ".$mng;


							// Delete ratings and comments by this user
							$sql = "DELETE FROM `ratings` WHERE usr_id = '$uid' ";
							echo $sql."<br>";
							if($sql) {
								if ($data = $mysqli->query($sql) == false) {
									die($mysqli->error.__LINE__);
								}
							}

							// Delete user from db
							$sql = "DELETE FROM `users` WHERE usr_id = '$uid'";
							//echo $sql."<br>";
							if($sql) {
								if ($data = $mysqli->query($sql) == false) {
									die($mysqli->error.__LINE__);
								}
							}

							
							redirect("mgrsearch.php");
						}
					}
				?>
			</form>
	</main>
	<footer>
		<div class="container">
			Copyright &copy; 2017 
		</div>
	</footer>
</body>
</html>