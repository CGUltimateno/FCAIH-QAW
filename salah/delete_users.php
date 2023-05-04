<?php
session_start();
require 'includes/dbh.inc.php';

define('TITLE',"Profile | KLiK");

if(!isset($_SESSION['id']))
{
    header("Location: login.php");
    exit();
}

if(isset($_GET['id']))
{
    $userid = $_GET['id'];
}
else
{
    $userid = $_SESSION['id'];
}


$sql = "select * from users where id = ".$userid;
$stmt = mysqli_stmt_init($conn);    

if (!mysqli_stmt_prepare($stmt, $sql))
{
    die('SQL error');
}
else
{
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);
    
}


include 'includes/HTML-head.php';   
?>
</head>
<body >
  <?php include 'includes/navbar.php'; ?>
    <h3 style='font-size: 36px;
      color: #007bff;
      text-align: center;
      text-transform: uppercase;
      letter-spacing: 4px;
      margin-top: 50px;
      margin-bottom: 50px;
      text-shadow: 2px 2px #eee;'> welcome to the delete page</h3>
   
</body>
<hr>   
<h4 style='font-size: 36px;
      color: #007bff;
      text-align: center;
      text-transform: uppercase;
      letter-spacing: 4px;
      margin-top: 50px;
      margin-bottom: 50px;
      text-shadow: 2px 2px #eee;'>Users List</h4>
<br><br>
<?php

if (isset($_POST['delete'])) {
    
    $id = $_POST['id'];
    // SQL query to delete the user with the specified ID
    $sql = "DELETE FROM users WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>";
        echo "alert('USER DELETED SUCCESSFULLY.');";
        echo "</script>";

    } else {
        echo "Error deleting user: " . $conn->error;
    }
}

// SQL query to retrieve user data
$sql = "SELECT id,username,email,img FROM users";
$result = $conn->query($sql);

// Check if any results were returned
if ($result->num_rows > 1 ) {
    // Output the user data in an HTML table
    echo "<table id='table1' cellpadding='10' cellspacing='13' style='
        margin: 50px auto;
        text-align: center;
        border-collapse: collapse;
        width: 80%;
      '>";
    while($row = $result->fetch_assoc()) {
        
       
        echo "<tr>";
        
        
        if($row["username"]!="admin"){
            ?>
         <td  >
         <img src='img/<?php echo $row['img'] ?>' class='card-img-profile'>
         <td>
            <?php
            
        echo "<td >" .$row["id"]. "</td>";
        echo "<td >" . $row["username"] . "</td>";
        echo "<td >" . $row["email"] . "</td>";
        echo "<td >";
          echo "<form method='POST'>";
        echo "<input type='hidden' name='id' value='" . $row["id"] . "'>";
        echo "<input type='submit' name='delete' value='Delete'>";
        echo "</form>";
        echo "</td>";
        echo "</tr>";}
    }
    echo "</table>";

} else {
    echo "No users found.";
}

?>

</hr>
<br>



