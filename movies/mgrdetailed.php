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
$mgr = 'N';

// get current user
session_start();
$user = $_SESSION['username']; 
//echo $user;

// Retrieve movie title from url
$title = "";
if (isset($_SESSION['serial'])) {
	$title = $_SESSION['serial'];
}

if (isset($_GET["serial"])){
	$title = htmlspecialchars($_GET["serial"]);
}
//echo $title;
// Variables that will hold movie details
$mid = "";
$summary = "";
$release = "";
$duration = "";
$language = "";
$rating = "";
$avg = "";

//Number of genres and object to hold genres
$numGenres = "";
$genres = "";
$newGenre = "";

// Object to hold movie comments
$comments = "";
$numComs = "";
$comment = "";
$rate = "";

// Object to hold movie crew
$crew = "";
$numCrew = 0;

// Object to hold movie tags
$tags = "";
$newtag = "";

//Create mysqli object
$mysqli = new mysqli($host, $usr, $pass, $db);

//Error handler
if($mysqli->connect_error) {
	printf("Connection to db failed: %s\n", $mysqli->connect_error);
	exit();
}

// Query db and get movie details
$sql = "SELECT * FROM movies WHERE title = '$title'";
if($sql) {
	$data = $mysqli->query($sql) or die($mysqli->error.__LINE__);
	$details = mysqli_fetch_assoc($data);
	$mid = $details['movie_id'];
	$summary = $details['summary'];
	$release = $details['release_date'];
	$duration = $details['duration'];
	$language = $details['language'];

} 

// Get average score for movie
$sql = "SELECT AVG(score) avg FROM ratings WHERE movie_id = '$mid' ";
if($sql) {
	$data = $mysqli->query($sql) or die($mysqli->error.__LINE__);
	$details = mysqli_fetch_assoc($data);
	$rating = $details['avg'];
	$avg = number_format((float)$rating, 2, '.', '');
	//print_r($data);

} 

// Get comments and individual ratings

$sql = "SELECT comments, score FROM ratings WHERE movie_id = '$mid' ";
if($sql) {
	$data = $mysqli->query($sql) or die($mysqli->error.__LINE__);
	$numComs = $data->num_rows;
	$ratings = $data;
} 

// Get genres
$sql = "SELECT genre FROM movie_genres WHERE movie_id = '$mid' ";
if($sql) {
	$data = $mysqli->query($sql) or die($mysqli->error.__LINE__);
	$numGenres = $data->num_rows;
	//$details = mysqli_fetch_assoc($data);
	$genres = $data;
} 

// Get tags
$sql = "SELECT tag FROM tags WHERE movie_id = '$mid' ";
if($sql) {
	$data = $mysqli->query($sql) or die($mysqli->error.__LINE__);
	$tags = $data;
} 

// Get crew
$sql = "SELECT * FROM crew WHERE movie_id = '$mid' ";
if($sql) {
	$data = $mysqli->query($sql) or die($mysqli->error.__LINE__);
	$numCrew = $data->num_rows;
	//$details = mysqli_fetch_assoc($data);
	$crew = $data;
} 

$_SESSION['serial'] = $title;
$_SESSION['username'] = $user;

// Check if review was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST["comment"]) && $_POST["comment"] != ""){
		$comment = $_POST['comment'];
	}

	if (isset($_POST['searchopt'])) {
		$rate = $_POST['searchopt'];
	}

	// get user id first
	$uid = "";
	$sql = "SELECT usr_id FROM users WHERE username = '$user' ";
	if($sql) {
		$data = $mysqli->query($sql) or die($mysqli->error.__LINE__);
		$details = mysqli_fetch_assoc($data);
		$uid = $details['usr_id'];
		//echo "userid ".$uid;
	}

	if($comment != ""){
		$sql = "INSERT INTO ratings (usr_id, movie_id, score, comments) VALUES ('$uid', '$mid', '$rate', '$comment')";
	}
	if($sql) {
		if ($data = $mysqli->query($sql) == false) {
			die($mysqli->error.__LINE__);
		}
		refresh();
	}
} 

// Add new tag
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST["tag"])){
		$newtag = $_POST['tag'];
	}
	
	$sql = "INSERT INTO tags (movie_id, tag) VALUES ('$mid', '$newtag')";
	if($sql) {
		if ($data = $mysqli->query($sql) == false) {
			die($mysqli->error.__LINE__);
		}

	}
	refresh();
} 

// Add new genre
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST["genre"])){
		$newGenre = $_POST['genre'];
		echo $newGenre;
	}
	
	$sql = "INSERT INTO movie_genres (`movie_id`, `genre`) VALUES ('$mid', '$newGenre')";
	echo $sql;
	if($sql) {
		if ($data = $mysqli->query($sql) == false) {
			die($mysqli->error.__LINE__);
		}

	}
	refresh();
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
		<form name="delete" method="POST" >
			<input type="submit" name="delete" value="Delete This Movie" />
				<?php 
					
					/*
					*	Implementing cascading delete to remove entries 
					*	from all tables using this movie
					*/

					if ($_SERVER['REQUEST_METHOD'] == 'POST') {
						if(isset($_POST['delete'])) {

							// Delete this movie's crew
							$sql = "DELETE FROM crew WHERE movie_id = '$mid' ";
							//echo $sql."<br>";
							if($sql) {
								if ($data = $mysqli->query($sql) == false) {
									die($mysqli->error.__LINE__);
								}
							}

							// Delete delete this movie's associated genres
							$sql = "DELETE FROM `movie_genres` WHERE movie_id = '$mid'";
							//echo $sql."<br>";
							if($sql) {
								if ($data = $mysqli->query($sql) == false) {
									die($mysqli->error.__LINE__);
								}
							}

							// Delete this movie's ratins
							$sql = "DELETE FROM ratings WHERE movie_id = '$mid' ";
							//echo $sql."<br>";
							if($sql) {
								if ($data = $mysqli->query($sql) == false) {
									die($mysqli->error.__LINE__);
								}
							}

							// Delete this movie's tags
							$sql = "DELETE FROM `tags` WHERE movie_id = '$mid'";
							//echo $sql."<br>";
							if($sql) {
								if ($data = $mysqli->query($sql) == false) {
									die($mysqli->error.__LINE__);
								}
							}

							// Delete movie from db
							$sql = "DELETE FROM `movies` WHERE movie_id = '$mid'";
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
		<h1><strong><b><?php echo $title?></b></strong></h1>
		<h3><i><?php echo $summary?></i></h3>		
		<div class="row">
  			<div class="col-md-12">
    			<div class="well inline-headers">
      			<h4>Release Date: <?php echo $release?></h4>
      			<h4>Duration: <?php echo $duration?> min</h4>
      			<h4>Language: <?php echo $language?></h4>
      			<h4>Avg User Rating: <?php echo $avg?></h4>
    			</div>
  			</div>
		</div>
		<div class="row">
  			<div class="col-md-12">
    			<div class="well inline-headers">
    			<form name="comment" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				<input type="text" name="comment" value="<?php echo $comment; ?>" size='60%' required="">
		      		<select name="searchopt" id="rate">
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
					</select>
					<input type="submit" value="Rate This Movie" />
				</form>
				</div>
			</div>
		</div>	
		<br><br>
		<div class="row">
  			<div class="col-md-12">
    			<div class="well inline-headers">
					<form name="genre" method="POST" >
						<input type="text" name="genre" value="<?php echo $newGenre; ?>" size='30%' required="">
						<input type="submit" value="Add New Genre" />
					</form>
				</div>
			</div>
		</div>	
		<div class="row">
  			<div class="col-md-12">
    			<div class="well inline-headers">
					<h4><i>Associated Genres: </i></h4>
						<?php

							// Print rows of table
							while($row = $genres->fetch_row()) {
								foreach($row as $cell) {
									echo $cell."   ";
								}
							}
						?>
				</div>
			</div>
		</div><br>	
		<div class="row">
  			<div class="col-md-12">
    			<div class="well inline-headers">
					<form name="tag" method="POST" >
						<input type="text" name="tag" value="<?php echo $newtag; ?>" size='30%' required="">
						<input type="submit" value="Add New Tag" />
					</form>
				</div>
			</div>
		</div>			
		<div class="row">
  			<div class="col-md-12">
    			<div class="well inline-headers">
					<h4><i>Associated Tags: </i></h4>
						<?php
							// Print rows of table
							while($row = $tags->fetch_row()) {
								foreach($row as $cell) {
									echo $cell."    ";
								}
							}
						?>
				</div>
			</div>
		</div><br><br>		
		<table border="1" width="80%">
			<caption><font size="5"><b>Crew</b></font></caption>
			<tr>
				<th>Role</th>
				<th>First Name</th>
				<th>Last Name</th>
			</tr>

			<?php if($numCrew == 0) : ?>
			<tr>No Crew Listed</tr>
			<?php else : ?>
				<?php
				// Print rows of table

						while($row = $crew->fetch_row()) {
							echo "<tr>";
							$i =0;
							foreach($row as $cell) {
								if ($i != 0)
									echo "<td>$cell</td>";
								$i++;
							}
							echo "</tr>";
						}
					
					?>
				<?php endif; ?>
			</td>
			</table>
			<br>
			<h5 align="left"><font size="4"><b>What Users Think of This Film</b></font></h5>
			<table border="0" width="50%">
				<tr>
					<th align="left">Rating</th>
					<th align="left">comment</th>
				</tr>
				<?php if($numComs == 0) : ?>
				<tr>No Comments</tr>
					<?php else : ?>
					<?php
						// Print rows of table
						while($row = $ratings->fetch_assoc())
							printf("<tr><td>%s</td><td>%s</td></tr>", $row['score'], $row['comments']);
							//echo "<tr><td>$row['score']</td><td>$row['comments']</td></tr>";
					?>	
			</table>
				<?php endif; ?>
			</td>
			</table>
		</div>
	</main>
	<footer>
		<div class="container">
			Copyright &copy; 2017 
		</div>
	</footer>
</body>
</html>
