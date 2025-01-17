<html>
<head>
	<link rel="stylesheet" type="text/css" href="main.css">
</head>
<body>

<h1> Search your favourite movies or actors!</h1>
<div class="nav">
	<a href="add_actor_director.php"> Add Actor/Director </a>
	<a href="add_movie.php"> Add a New Movie </a>
	<a href="add_comments.php"> Add New Comments </a>
	<a href="add_movieactor.php"> Add a New Actor to a Movie </a>
	<a href="add_moviedirector.php"> Add a New Director to a Movie </a>
	<a href="search.php"> Search </a>
</div>

<br>

<form method="GET" action="search.php">
	<input type="text" name="keyword">
	<input type="radio" name="radio" value="1" checked>Movie 
	<input type="radio" name="radio" value="2"> Actor
	<input type="submit" value="Search" /> 
	<br>
	Multi-word Search<input type="checkbox" NAME="type" VALUE="on">
</form>


<?php
$keyword = $_GET["keyword"];
$target = $_GET["radio"];
$multi_word = $_GET["type"];
$servername = "localhost";
$username = "cs143";
$password = "";

if($keyword) {
	$conn = mysql_connect($servername, $username, $password);
	if (!$conn) {
		echo "Unable to connect to the sql server.";
		die();
	}

	if (!mysql_select_db("CS143", $conn)){
		echo "Unable to select the data base 'CS143'";
		die();
	}

	if($target == 2) {
		// Do the non-multi-word search on actor
		if($multi_word != "on") {
			$pieces = explode(" ", $keyword);
			if(count($pieces) == 1) {
				$query = sprintf("SELECT id, CONCAT(first, ' ', last) AS name, sex, dob, dod
								FROM Actor
								WHERE LOWER(first) LIKE LOWER('%%%s%%')
								OR LOWER(last) like LOWER('%%%s%%')",
								$pieces[0], $pieces[0]);
				$output = mysql_query($query, $conn);
				if(mysql_num_rows($output) == 0) {
					echo "<h3>No such actor.</h3>";
				} else {
					echo "<h3>The searching result is shown as following:</h3>";
					displayResult($output, "actor");
				}
			} else if(count($pieces) == 2) {
				$query = sprintf("SELECT id, CONCAT(first, ' ', last) AS name, sex, dob, dod
								FROM Actor
								WHERE LOWER(first) LIKE LOWER('%%%s%%')
								AND LOWER(last) like LOWER('%%%s%%')",
								$pieces[0], $pieces[1]);
				$output = mysql_query($query, $conn);
				if(mysql_num_rows($output) == 0) {
					echo "<h3>No such actor.</h3>";
				} else {
					echo "<h3>The searching result is shown as following:</h3>";
					displayResult($output, "actor");
				}
			}
		} else { // Do the multi-word search on actor
			$pieces = explode(" ", $keyword);
			$query = sprintf("SELECT id, CONCAT(first, ' ', last) AS name, sex, dob
							FROM Actor
							WHERE LOWER(CONCAT(first, ' ', last)) LIKE LOWER('%%%s%%')",
							$pieces[0]);

			for($x=1; $x < count($pieces); $x++){
				$extend = sprintf(" AND LOWER(CONCAT(first, ' ', last)) LIKE LOWER('%%%s%%')", $pieces[$x]);
				$query = $query.$extend;
			}
			$output = mysql_query($query, $conn);
			if(mysql_num_rows($output) == 0) {
				echo "<h3>No such actor.</h3>";
			} else {
				echo "<h3>The searching result is shown as following:</h3>";
				displayResult($output, "actor");
			}
		}
	}

	if($target == 1) {
		// Do the non-multi-word search on movie
		if($multi_word != "on") {
			$query = sprintf("SELECT id, title, year, rating, company
							FROM Movie
							WHERE LOWER(title) LIKE LOWER('%%%s%%')",
							$keyword);
			$output = mysql_query($query, $conn);
			if(mysql_num_rows($output) == 0) {
				echo "<h3>No such movie.</h3>";
			} else {
				echo "<h3>The searching result is shown as following:</h3>";
				displayResult($output, "movie");
			}
		} else { // Do the multi-word search on movie
			$pieces = explode(" ", $keyword);
			$query = sprintf("SELECT id, title, year, rating, company
							FROM Movie
							WHERE LOWER(title) LIKE LOWER('%%%s%%')",
							$pieces[0]);

			for($x = 1; $x < count($pieces); $x ++){
				$extend = sprintf(" AND LOWER(title) LIKE LOWER('%%%s%%')", $pieces[$x]);
				$query = $query.$extend;
			}
			$output = mysql_query($query, $conn);
			if(mysql_num_rows($output) == 0) {
				echo "<h3>No such movie.</h3>";
			} else {
				echo "<h3>The searching result is shown as following:</h3>";
				displayResult($output, "movie");
			}
		}
	}

	mysql_close($conn);
}

function displayResult($data1, $type) {
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
				if($j == 1) {
					echo "<a href= '". $type . ".php" . "?" . $type . "=" . $row[$j] . "'>";
					echo $row[$j];
					echo "</a>";
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