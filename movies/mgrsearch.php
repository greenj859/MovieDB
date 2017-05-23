<?php

function redirect($url) {
	Header("Location: ".$url);
	exit;
}

function logout() {
	Header("Location: index.php");
	$_SESSION = array();
	session_destroy();
	exit;
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


// start session to recover username from sign-in page


// current user
$user = "";

// Retrieve current user
session_start();
$user = $_SESSION['username'];
if ($user != ""){
	//echo $user;
}
else {
	 echo "Url has no user";
}

// Returned from query
$data = "";
$query = "";

//Create mysqli object
$mysqli = new mysqli($host, $usr, $pass, $db);

//Error handler
if($mysqli->connect_error) {
	printf("Connection to db failed: %s\n", $mysqli->connect_error);
	exit();
}

// Build query based on user selection
$sql = '';

if(isset($_POST['searchq'])){
	$query=$_POST['searchq'];
	//echo $query;
	$menuval = $_POST['searchopt'];
	//echo $menuval;

	if($menuval == 'movies') {
		if ($query == ''){
			$sql = "SELECT * FROM movies";
		}
		else {
			$sql = "SELECT * FROM movies AS m WHERE m.title LIKE '%$query%'";
			//echo $sql;
		}
	}
	elseif ($menuval == 'genre') {
		if ($query == ''){
			$sql = "SELECT * FROM movies AS m INNER JOIN movie_genres as g ON m.movie_id = g.movie_id";
		}
		else {
			$sql = "SELECT *, g.genre FROM movies as m, movie_genres as g WHERE m.movie_id = g.movie_id AND g.genre LIKE '%$query%' ";
		}
	}
	elseif ($menuval == 'tag') {
		if($query == '') {
			$sql = "SELECT * FROM movies as m, tags AS t WHERE m.movie_id = t.movie_id";
		}
		else {
			$sql = "SELECT * FROM movies as m, tags AS t WHERE m.movie_id = t.movie_id AND t.tag LIKE '%$query%' ";
		}
	}
	elseif ($menuval == 'crew') {
		if($query == '') {
			$sql = "SELECT * FROM movies as m, crew AS c WHERE m.movie_id = c.movie_id";
		}
		else {
			$sql = "SELECT * FROM movies as m, crew AS c WHERE m.movie_id = c.movie_id AND CONCAT(fname, ' ', lname) LIKE '%$query%' ";
		}
	}
	elseif ($menuval == 'user') {
		if($query == '') {
			$sql = "SELECT * FROM users";
		}
		else {
			$sql = "SELECT * FROM users AS u WHERE username LIKE '%$query%' ";
		}
	}
}
//echo "<br>".$sql."<br>";
$numRows = "";
// Query the movie database
if($sql) {
	$data = $mysqli->query($sql) or die($mysqli->error.__LINE__);
	//print_r($data);
	$numFields = $data->field_count;
	//echo "<br>"."num fields = ".$numFields."<br>";
	$numRows = $data->num_rows;
   //echo "<br>"."num_rows = ".$numRows."<br>";
}
$fields = "";
if($data){
	$field = $data->fetch_fields();
//	foreach($field as $col) {
//		printf("field:  %s<br>", $col->name);
//	}
}
//print_r($fields);

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title> Movies DB</title>
	<link rel="stylesheet" href="css/search.css" type="text/css"/>
	<style>
		table {
    		font-family: arial, sans-serif;
    		border-collapse: collapse;
    		width: 100%;
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
		<form name="add" method="POST" action="addmovie.php">
			<input type="submit" value="Add a Movie" />
		</form>
		<div class="container">
			<form name="search" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				<input type="text" name="searchq" placeholder="Enter query..." size='60%'>
				<select name="searchopt" id="searchopt">
					<option value="movies">Movie Title</option>
					<option value="genre">Genre</option>
					<option value="tag">Tag</option>
					<option value="crew">Crew</option>
					<option value="user">Users</option>
				</select>
				<input type="submit" value="Search" />
			</form>
			<table border="1" width="80%">
				<?php if($numRows == 0) : ?>
					<tr>NO RESULTS</tr>
				<?php else : ?>
					<?php
						// Print table headers
						echo "<tr>";
						$fields = $data->fetch_fields();
						foreach($fields as $col) {
							printf("<th>%s</th>", $col->name);
						}
						echo "</tr>";

				// Print rows of table
						$j = 0;
						while($row = $data->fetch_row()) {
							echo "<tr>";
							//$i = 0;
							foreach($row as $cell) {
								//echo $i;
								if($j == 1 && $menuval != 'user') {
									echo "<td> <a href='mgrdetailed.php?serial=" .$cell. "'>$cell</a></td>";
							
								}
								elseif($j == 1 && $menuval == 'user') {
									echo "<td> <a href='manageuser.php?serial=" .$cell. "'>$cell</a></td>";
							
								}
								else{
									echo "<td>$cell</td>";
								}
								$j++;
							}
							$j=0;
							echo "</tr>";
						}
						//session_start();
						$_SESSION['username'] = $user;  // Pass current user to next page
					?>
				<?php endif; ?>
			</td>
			</table>
		</div>
	</main>
</body>
</html>
