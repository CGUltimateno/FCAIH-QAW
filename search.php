<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
  $conn = new mysqli('localhost', 'root', '', 'store1');

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $query = $_POST['query'];
  $sql = "SELECT * FROM search WHERE title LIKE '%$query%' OR content LIKE '%$query%'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // Display search results
    {
        echo "<table>";
        echo "<tr><th>Title : </th><th>Content</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr><td>".$row['title']." :</td><td>".$row['content']."</td></tr>";
        }
        echo "</table>";
    }
  }
  else {
    echo "<p class='not-found'>No results found.</p>";
}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Search Example</title>
	<link rel="stylesheet" type="text/css" href="search.css">
</head>
<body>
	<h1>Search Example</h1>
	<form method="POST" action="search.php">
		<label for="query">Enter search query:</label>
		<input type="text" name="query" id="query" placeholder="Search">
		<button type="submit">Search</button>
	</form>
</body>
</html>