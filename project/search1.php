<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
  $conn = new mysqli('localhost', 'root', '', 'database');

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $query = $_POST['query'];
  $sql = "SELECT * FROM questions WHERE title LIKE '%$query%' OR body LIKE '%$query%'";
  $result = $conn->query($sql);

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
	<link rel="stylesheet" type="text/css" href="search.css">
</head>
<body>
</body>
</html>