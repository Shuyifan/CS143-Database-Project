<html>
<head>
	<link rel="stylesheet" type="text/css" href="main.css">
</head>

<body>

<h1> Actor information </h1>
<div class="nav">
	<a href="add_actor_director.php"> Add Actor/Director </a>
	<a href="add_movie.php"> Add a New Movie </a>
	<a href="add_comments.php"> Add New Comments </a>
	<a href="add_movieactor.php"> Add a New Actor to a Movie </a>
	<a href="add_moviedirector.php"> Add a New Director to a Movie </a>
	<a href="search.php"> Search </a>
</div>

<?php

$actor = $_GET["actor"];
$servername = "localhost";
$username = "cs143";
$password = "";

if($actor) {
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
// Print basic actor information	
	
	echo "<h3>Actor's basic information:</h3>";
	
	$query = sprintf("SELECT id AS `Actor ID`, CONCAT(first, ' ', last) AS Name, sex AS Sex, dob AS `Date of Birth`, dod AS `Date of Dead`
					  FROM Actor
					  WHERE LOWER(CONCAT(first, ' ', last)) = LOWER('%s')",
		     		  $actor);
	$output = mysql_query($query, $conn);
	displayResult($output, "actor", false, 1);

/**------------------------------------------------------------------------------------------------------- */
// Print the movie list where the actor attend

	echo "<h3>The movies that the actor was in:</h3>";

	$query = sprintf("SELECT title AS Title, year AS Year, shownMovie.name As `Actor Name`, shownMovie.role AS `Actor Role`, rating AS Rating, company AS `Produce Company`
					  FROM Movie,
					  (
					  	SELECT mid, target.name, role
					  	FROM MovieActor,
					  	(
					  		SELECT id, CONCAT(first, ' ', last) AS name
					  		FROM Actor 
					  		WHERE LOWER(CONCAT(first, ' ', last)) = LOWER('%s')
					  	) AS target
					  	WHERE target.id = MovieActor.aid
					  ) AS shownMovie
					  WHERE Movie.id = shownMovie.mid
					  ORDER BY year",
					  $actor);
	
	$output = mysql_query($query, $conn);
	if(mysql_num_rows($output) == 0) {
		echo "This actor haven't been in any movie.";
	} else {
		displayResult($output, "movie", true, 0);
	}
}


function displayResult($data1, $type, $link, $linkColumn) {
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
        echo "The return data is empty";
    }
	mysql_free_result($data1);
}

?>
</body>

</html>