<?php
 $db = mysqli_connect('localhost','root','root','venues_loc_test')
 or die('Error connecting to MySQL server.');


$query = "SELECT * FROM locations";
mysqli_query($db, $query) or die('Error querying database.');

$result = mysqli_query($db, $query);
$row = mysqli_fetch_array($result);

while ($row = mysqli_fetch_array($result)) {
 echo $row['post_title'].'<br />';
}
