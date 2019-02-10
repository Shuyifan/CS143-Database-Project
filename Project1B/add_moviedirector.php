<html>
	<head>
		<link rel="stylesheet" type="text/css" href="main.css">
	</head>
	<body>
		<h1> Add New Director to a movie! </h1>
		<div class="nav">
			<a href="add_actor_director.php"> Add Actor/Director </a>
			<a href="add_movie.php"> Add a New Movie </a>
			<a href="add_comments.php"> Add New Comments </a>
			<a href="add_movieactor.php"> Add a New Actor to a Movie </a>
			<a href="add_moviedirector.php"> Add a New Director to a Movie </a>
			<a href="search.php"> Search </a>
		</div>
		<h3> Adding a new director to the movie: </h3>
		<form action="add_moviedirector.php" method="GET">
		    FirstName: <input type="text" name="Firstname" placeholder="firstname" size=20 maxlength=20>
		    <br>
		    LastName: <input type="text" name="Lastname" placeholder="lastname" size=20 maxlength=20>
		    <br>
		    Movie: <?php
		    		   
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
					   $query = "select title from Movie";
					   $rs = mysql_query($query, $db_connection);
					   mysql_close($db_connection);

					   echo "<select name='Movie'>";
					   while($row = mysql_fetch_row($rs)) {
					   	   echo "<option>";
					   	   echo $row[0];
					   	   echo "</option>";
					   }
					   echo "</select>";
		    	       
		    	   ?>
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
			
			$sanitized_firstname = mysql_real_escape_string($_GET["Firstname"], $db_connection);
			$sanitized_lastname = mysql_real_escape_string($_GET["Lastname"], $db_connection);
			$query = "select id from Director where last = '$sanitized_lastname' and
					first = '$sanitized_firstname'";
			$rs = mysql_query($query, $db_connection);
			if($rs) {
				$did = mysql_fetch_row($rs)[0];
				$moviename = $_GET["Movie"];
				$query = "select id from Movie where title = '$moviename'";
				$mid = mysql_fetch_row(mysql_query($query, $db_connection))[0];
				$query = "insert into MovieDirector (mid, did) values
						($mid, $did)";
				$rs = mysql_query($query, $db_connection);
				if($rs) {
					echo "New director in a movie successfully added!";
				} else {
					echo "The director not found! Please add the director to database first!";
				}
			} else {
				echo "Insertion failed!";
			}
			

			mysql_close($db_connection);
		}
		
	?>

</html>