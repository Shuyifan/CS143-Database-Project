<html>

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
	
	echo "<h3>Actor's basic information:</h3>";
	$query = sprintf("SELECT id, title, year, rating AS `MPAA rating`, company
					  FROM Movie
					  WHERE LOWER(title) = LOWER('%s')",
		     		  $movie);
	$output = mysql_query($query, $conn);
	displayResult($output, "movie", false, 1);

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
	displayResult($output, "movie", false, 1);	

	$query = sprintf("SELECT genre
					  FROM Movie, MovieGenre
					  WHERE LOWER(title) = LOWER('%s')
					  AND id = mid",
					  $movie);
	$output = mysql_query($query, $conn);
	displayResult($output, "movie", false, 1);	

	$query = sprintf("SELECT imdb, rot
					  FROM Movie, MovieRating
					  WHERE LOWER(title) = LOWER('%s')
					  AND MovieRating.mid = Movie.id",
					  $movie);

	$output = mysql_query($query, $conn);
	displayResult($output, "actor", false, 1);

	$query = sprintf("SELECT target.aid, CONCAT(first, ' ', last), role
					  FROM Actor,
					  (
					  	SELECT MovieActor.aid, role
					  	FROM Movie, MovieActor
					  	WHERE LOWER(title) = LOWER('%s')
					  	AND MovieActor.mid = Movie.id
					  ) AS target
					  WHERE target.aid = Actor.id
					  ORDER BY aid",
					  $movie);

	$output = mysql_query($query, $conn);
	displayResult($output, "actor", true, 1);


	$query = sprintf("SELECT AVG(rating) AS `average score`
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
	displayResult($output, "actor", false, 1);
	
	$query = sprintf("SELECT name, time, rating, comment
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
	displayResult($output, "actor", false, 1);
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