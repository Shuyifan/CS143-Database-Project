
<html>
<body>
<h2>CS143 Project1a</h2>
<h3>Winter 2019</h3>
<h3>Yifan Shu (uid: 005228229) & Chengshun Zhang (uid: 905061060)</h3>
</body>

<form action="query.php" method="GET">
    <textarea name="query" rows="8" cols="60"><?php print "$query" ?></textarea><br />
    <input type="submit" value="Submit" />  
</form>


<?php 
$servername = "localhost";
$username = "cs143";
$password = "";
 
// create connection

$conn = mysql_connect($servername, $username, $password);
 
// check the connection
if (!$conn) {
    echo "Unable to connect to the sql server.";
    die();
}

if (!mysql_select_db("CS143", $conn)){
    echo "Unable to select the data base 'CS143'";
    die();
}

echo $_GET["query"];
$output = mysql_query($_GET["query"], $conn);
mysql_close($conn);
displayResult($output);


function displayResult($data1) {

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
                echo "<th>";
                if ($row[$j] == null) {
                    echo "NULL";
                } else {
                    echo $row[$j];
                }
                echo "</th>";
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

</html>