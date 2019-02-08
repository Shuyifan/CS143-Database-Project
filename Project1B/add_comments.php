<html>
	<body>
		<h1> Add New Comments </h1>
		<a href="add_actor_director.php"> Add Actor/Director </a>
		<a href="add_movie.php"> Add a New Movie </a>
		<a href="add_comments.php"> Add New Comments </a>
		<h3> Adding a new comment to the database: </h3>
		<form action="add_comments.php" method="GET">
		    UserName: <input type="text" name="Username" value="" size=20 maxlength=20>
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
		    Rating: <select name="Rating">
		    			<option> 5 </option>
		    			<option> 4 </option>
		    			<option> 3 </option>
		    			<option> 2 </option>
		    			<option> 1 </option>
		    		</select>
		    <br>
		    <br>
		    Comment: <textarea name="Comment" rows=8 cols=60 maxlength="500"></textarea>
		    <br>
		    <input type="submit" value="Submit">
		</form>
	</body>

	<?php
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
		
		$sanitized_username = mysql_real_escape_string($_GET["Username"], $db_connection);
		$moviename = $_GET["Movie"];
		$query = "select id from Movie where title = '$moviename'";
		$mid = mysql_fetch_row(mysql_query($query, $db_connection))[0];
		$rating = $_GET["Rating"];
		$comment = $_GET["Comment"];

		$query = "insert into Review (name, time, mid, rating, comment) values
					('$sanitized_username', NOW(), $mid, $rating, '$comment')";
		$rs = mysql_query($query, $db_connection);
		if($rs) {
			echo "New comment successfully added!";
		}

		mysql_close($db_connection);
	?>

</html>