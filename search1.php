<?php
include 'inc/dbh.inc.php';

    define('TITLE',"Edit Profile | Discussio");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $query = $_POST['query'];
  $sql = "SELECT * FROM questions WHERE title LIKE '%$query%' OR body LIKE '%$query%'";
  $result = $db->query($sql);

  if ($result->num_rows > 0) {
    // Display search results
        echo "<table>";
        echo "<tr><th>Title : </th><th>Body</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr><td>".$row['title']." :</td><td>".$row['body']."</td></tr>";
        }
        echo "</table>";
    
  }
  else {
    echo "<p class='not-found'>No results found.</p>";
  }
}
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/search.css">
</head>
<body>
</body>
</html>
