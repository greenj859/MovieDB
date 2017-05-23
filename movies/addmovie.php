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

// Variables that will hold movie information
$title = "";
$summary = "";
$duration = "";
$release = "";
$date = "";
$language = "";

//Create mysqli object
$mysqli = new mysqli($host, $usr, $pass, $db);

//Error handler
if($mysqli->connect_error) {
	printf("Connection to db failed: %s\n", $mysqli->connect_error);
	exit();
}

// Check that user name field is not empty
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST["title"])) {
		$title = $_POST['title'];
	}
}

// Check that password field is not empty
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST["summary"])){
		$summary = $_POST['summary'];

	}
}

// Check that user name field is not empty
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST["duration"])) {
		$duration = $_POST['duration'];
	}
}

// Check that password field is not empty
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST["release_date"])){
		$date = $_POST['release_date'];
		//$date = DateTime::createFromFormat('Y-m-d', $release);
	}
}

// Check that password field is not empty
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST["language"])){
		$language = $_POST['language'];

	}
}
// Get list of usernames, passwords, and is_mgr from db
if ($summary != '') {
	$sql = "INSERT INTO movies (title, summary, release_date, language, duration) VALUES ('$title', '$summary', '$date', '$language', '$duration' )";
	//echo $sql;
	if($res = $mysqli->query($sql) == false) {
		die($mysqli->error.__LINE__);
	}
	redirect("mgrsearch.php");
}
?>

<!DOCTYPE HTML> 
<html> 
<head> 
	<meta charset="utf-8" />
	<title>New Movie</title> 
	<link rel="stylesheet" href="css/signup.css" type="text/css"/>
</head> 
<body id="body-color"> 
	<div id="container">
	<header>
		<div class="container">
			<h1><font size = "10">A Movie DB</font></h1>
			<h3>A Database for Movie Nerds</h3>
		</div>
	</header> 
	<fieldset style="width:50%">	
	<legend>Add a Movie</legend> 
	<table border="0"> 
		<tr> 
		<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>"> 
			<td>Title</td><td><input type="text" name="title" value="<?php echo $title; ?>" required></td>
		</tr>
		<tr>
			<td>Summary</td><td> <input type="text" name="summary" value="<?php echo $summary; ?>" required></td>
		</tr> 
		<tr> 
			<td>Release Date ("yyyy-mm-dd")</td><td> <input type="text" name="release_date" value="<?php echo $release; ?>" required></td> 
		</tr> 
		<tr> 
			<td>Language</td><td> <input type="text" name="language" value="<?php echo $language; ?>" required></td> 
		</tr> 
		<tr> 
			<td>Duration (mins)</td><td> <input type="text" name="duration" value="<?php echo $duration; ?>" required></td> 
		</tr> 
		<tr> 
			<td><input id="button" type="submit" name="submit" value="Add Movie"></td> 
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




