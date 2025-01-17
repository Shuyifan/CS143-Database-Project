<html>
	<head>
		<link rel="stylesheet" type="text/css" href="main.css">
	</head>
	<body>
		<h1> Add New Movie </h1>
		<div class="nav">
			<a href="add_actor_director.php"> Add Actor/Director </a>
			<a href="add_movie.php"> Add a New Movie </a>
			<a href="add_comments.php"> Add New Comments </a>
			<a href="add_movieactor.php"> Add a New Actor to a Movie </a>
			<a href="add_moviedirector.php"> Add a New Director to a Movie </a>
			<a href="search.php"> Search </a>
		</div>
		<h3> Adding a new movie to the database: </h3>
		<form action="add_movie.php" method="GET">
		    Title: <input type="text" name="Title" value="" size=20 maxlength=20>
		    <br>
		    Year: <input type="text" name="Year" value="" size=20 maxlength=4> (YYYY)
		    <br>
		    MPAA Rating: <select name="Rating">
		    				<option> G </option>
		    				<option> NC-17 </option>
		    				<option> PG </option>
		    				<option> PG-13 </option>
		    				<option> R </option>
		    			 </select>
		    <br>
		    Company: <input type="text" name="Company" size=20 maxlength=20>
		    <br>
		    Genre: <input type="checkbox" name="Genre[]" value="Action"> Action
		    	   <input type="checkbox" name="Genre[]" value="Adult"> Adult
		    	   <input type="checkbox" name="Genre[]" value="Adventure"> Adventure
		    	   <input type="checkbox" name="Genre[]" value="Animation"> Animation
		    	   <input type="checkbox" name="Genre[]" value="Comedy"> Comedy
		    	   <input type="checkbox" name="Genre[]" value="Crime"> Crime
		    	   <input type="checkbox" name="Genre[]" value="Documentary"> Documentary
		    	   <input type="checkbox" name="Genre[]" value="Drama"> Drama
		    	   <input type="checkbox" name="Genre[]" value="Family"> Family
		    	   <input type="checkbox" name="Genre[]" value="Fantasy"> Fantasy
		    	   <input type="checkbox" name="Genre[]" value="Horror"> Horror
		    	   <input type="checkbox" name="Genre[]" value="Musical"> Musical
		    	   <input type="checkbox" name="Genre[]" value="Mystery"> Mystery
		    	   <input type="checkbox" name="Genre[]" value="Romance"> Romance
		    	   <input type="checkbox" name="Genre[]" value="Sci-Fi"> Sci-Fi
		    	   <input type="checkbox" name="Genre[]" value="Short"> Short
		    	   <input type="checkbox" name="Genre[]" value="Thriller"> Thriller
		    	   <input type="checkbox" name="Genre[]" value="War"> War
		    	   <input type="checkbox" name="Genre[]" value="Western"> Western
		    <br>
		    <input type="submit" name="add" value="Submit">
		</form>
	</body>

	<?php
		if(isset($_GET["add"])) {
			$db_connection = mysql_connect("localhost", "cs143", "");
			if(!$db_connection) {
			    $errmsg = mysql_error($db_connection);
			    print "Connection failed: " . $errmsg . "<br>";
			    exit(1);
			}

			$db_selected = mysql_select_db("CS143", $db_connection);
			if(!db_selected) {
				$errmsg = mysql_error($db_selected);
			    print "Unable to select the database: " . $errmsg . "<br>";
			    exit(1);
			}

			$query = "select * from MaxMovieID";
			$rs = mysql_query($query, $db_connection);
			$new_id = mysql_fetch_row($rs)[0] + 1;

			$sanitized_title = mysql_real_escape_string($_GET["Title"], $db_connection);
			$year = $_GET["Year"];
			$rating = $_GET["Rating"];
			$sanitized_company = mysql_real_escape_string($_GET["Company"], $db_connection);
			$genres = $_GET["Genre"];

			$query = "insert into Movie (id, title, year, rating, company) values
						($new_id, '$sanitized_title', $year, '$rating', '$sanitized_company')";
			$rs = mysql_query($query, $db_connection);

			for($i = 0; $i < count($genres); $i++) {
				$query = "insert into MovieGenre (mid, genre) values
						($new_id, '$genres[$i]')";
				$rs = mysql_query($query, $db_connection);
			}
			

			if($rs) {
				$query = "update MaxMovieID set id = $new_id";
				mysql_query($query, $db_connection);
				echo "New movie successfully added!";
			} else {
				echo "Insertion failed!";
			}
			
			mysql_close($db_connection);
		}
		
	?>
</html>