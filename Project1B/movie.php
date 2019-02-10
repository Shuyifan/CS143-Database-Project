<html>
<head>
	<link rel="stylesheet" type="text/css" href="main.css">
</head>

<h1> Movie information </h1>
<div class="nav">
	<a href="add_actor_director.php"> Add Actor/Director </a>
	<a href="add_movie.php"> Add a New Movie </a>
	<a href="add_comments.php"> Add New Comments </a>
	<a href="add_movieactor.php"> Add a New Actor to a Movie </a>
	<a href="add_moviedirector.php"> Add a New Director to a Movie </a>
	<a href="search.php"> Search </a>
</div>
<body>
<?php

$movie = $_GET["movie"];
$servername = "localhost";
$username = "cs143";
$password = "";

if($movie) {
	$conn = mysql_connect($servername, $username, $password);
	if (!$conn) {
		echo "Unable to connect to the sql server.";
		die();
	}

	if (!mysql_select_db("CS143", $conn)){
		echo "Unable to select the data base 'CS143'";
		die();
	}

/**------------------------------------------------------------------------------------------------------- */
// Print basic movie information	
	
	echo "<h3>Movie's Basic Information:</h3>";
	$query = sprintf("SELECT id, title, year, rating AS `MPAA rating`, company
					  FROM Movie
					  WHERE LOWER(title) = LOWER('%s')",
		     		  $movie);
	$output = mysql_query($query, $conn);

	$row = mysql_fetch_row($output);

	echo "<font size=4>" . "<b>Title:</b> " . $row[1] . "<Br /></font>";
	echo "<font size=4>" . "<b>Year:</b> " . $row[2] . "<Br /></font>";
	echo "<font size=4>" . "<b>MPAA Rating:</b> " . $row[3] . "<Br /></font>";
	echo "<font size=4>" . "<b>Produce Company:</b> " . $row[4] . "<Br /></font>";

/**------------------------------------------------------------------------------------------------------- */
// Print movie's director

	$query = sprintf("SELECT CONCAT(first, ' ', last) AS name
					  FROM Director, 
					  (
					  SELECT did
					  FROM Movie, MovieDirector
					  WHERE LOWER(title) = LOWER('%s')
					  AND id = mid
					  ) AS directorID
					  WHERE directorID.did = Director.id",
					  $movie);
	$output = mysql_query($query, $conn);
	
	if(mysql_num_rows($output) == 0) {
		echo "<font size=4>" . "<b>Director:</b> " . "not available" . "<Br /></font>";
	} else {
		$row = mysql_fetch_row($output);
		echo "<font size=4>" . "<b>Director:</b> " . $row[0] . "<Br /></font>";
	}

/**------------------------------------------------------------------------------------------------------- */
// Print movie's genres

	$query = sprintf("SELECT genre
					  FROM Movie, MovieGenre
					  WHERE LOWER(title) = LOWER('%s')
					  AND id = mid",
					  $movie);
	$output = mysql_query($query, $conn);
	$rows = mysql_num_rows($output);
	if(mysql_num_rows($output) == 0) {
		echo "<font size=4>" . "<b>Genre:</b> " . "not available" . "<Br /></font>";
	} else {
		$row = mysql_fetch_row($output);
		echo "<font size=4>" . "<b>Genre:</b> " . $row[0];
		for ($i=1; $i < $rows; $i++){
			$row = mysql_fetch_row($output);
			echo ", " . $row[0];
		}
		echo "<Br /></font>";
	}

/**------------------------------------------------------------------------------------------------------- */
// Print IMDB and ROT score
	$query = sprintf("SELECT imdb, rot
					  FROM Movie, MovieRating
					  WHERE LOWER(title) = LOWER('%s')
					  AND MovieRating.mid = Movie.id",
					  $movie);

	$output = mysql_query($query, $conn);
	$row = mysql_fetch_row($output);
	echo "<font size=4>" . "<b>IMDB Score:</b> " . $row[0] . "<Br /></font>";
	echo "<font size=4>" . "<b>ROT Score:</b> " . $row[1] . "<Br /></font>";


/**------------------------------------------------------------------------------------------------------- */
// Print the list of actors for this movie
	
	echo "<h3>List of Actors for This Movie:</h3>";
	$query = sprintf("SELECT CONCAT(first, ' ', last) AS Name, role AS Role
					  FROM Actor,
					  (
					  	SELECT MovieActor.aid, role
					  	FROM Movie, MovieActor
					  	WHERE LOWER(title) = LOWER('%s')
					  	AND MovieActor.mid = Movie.id
					  ) AS target
					  WHERE target.aid = Actor.id
					  ORDER BY Name",
					  $movie);

	$output = mysql_query($query, $conn);
	displayResult($output, "actor", true, 0);

/**------------------------------------------------------------------------------------------------------- */
// Print the average score of the comment

	echo "<h3>Acerage Rating from the Comments:</h3>";
	$query = sprintf("SELECT AVG(rating) AS `Average Score`
					  FROM Review,
					  (
					  	SELECT id
					  	FROM Movie
					  	WHERE LOWER(title) = LOWER('%s')
					  ) AS target
					  WHERE target.id = Review.mid
					  GROUP BY target.id",
					  $movie);

	$output = mysql_query($query, $conn);
	if(!displayResult($output, "actor", false, 1)) {
		echo "<font size=4>" . "No user rating! <br>"  . "</font>";
	}
	
/**------------------------------------------------------------------------------------------------------- */
// Print all the comments
	echo "<h3>Comments:</h3>";
	$query = sprintf("SELECT name AS `User Name`, time AS `Time`, rating AS `Rating`, comment AS `Comment`
					  FROM Review,
					  (
					  	SELECT id
					  	FROM Movie
					  	WHERE LOWER(title) = LOWER('%s')
					  ) AS target
					  WHERE target.id = Review.mid
					  ORDER BY time",
					  $movie);

	$output = mysql_query($query, $conn);
	if(!displayResult($output, "actor", false, 1)) {
		echo "<font size=4>" . "No comments for now. <br>" . "</font>";
	}
}

function displayResult($data1, $type, $link, $linkColumn) {
	$notEmpty = 1;
    if (mysql_num_rows($data1) > 0) {
        echo "<table border=1  <tr>";
        for ($i=0; $i < mysql_num_fields($data1); $i++){
            echo "<th>";
            echo mysql_fetch_field($data1)->name;
            echo "</th>";
		}
        echo "</tr>";
        while ($row = mysql_fetch_row($data1)) {
            echo "<tr>";
            for ($j = 0; $j < mysql_num_fields($data1); $j ++) {
                echo "<td>";
				if($j == $linkColumn) {
					if($link) {
						echo "<a href= '". $type . ".php" . "?" . $type . "=" . $row[$j] . "'>";
						echo $row[$j];
						echo "</a>";
					} else {
						echo $row[$j];
					}
				} else {
					if ($row[$j] == null) {
						echo "NULL";
					} else {
						echo $row[$j];
					}
				}
                echo "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    }
    else {
        $notEmpty = 0;
    }
	mysql_free_result($data1);
	return $notEmpty;
}

?>
<br>
<a href="add_comments.php"> Add Comments </a>
</body>

</html>