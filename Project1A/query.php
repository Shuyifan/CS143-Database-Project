
<html>
<body>
<h2>CS143 Project1a</h2>
<h3>Winter 2018</h3>
<h3>Yifan Shu (uid: 005228229) & Chengshun Zhang (uid: )</h3>
</body>

<FORM METHOD = "POST" ACTION = "./query.php">
    <TEXTAREA NAME="query" ROWS=25 COLS=50></TEXTAREA>
    <input type="submit" name="submit" value="Submit">  
</FORM>


<?php 
$servername = "localhost";
$username = "cs143";
$password = "";
 
// 创建连接

$conn = mysql_connect($servername, $username, $password);
 
// 检测连接
if (!$conn) {
    echo "Unable to connect to the sql server.";
    die();
}

if (!mysql_select_db("CS143", $conn)){
    echo "Unable to select the data base 'CS143'";
    die();
}

echo $_POST["query"];
$output = mysql_query($_POST["query"], $conn);
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