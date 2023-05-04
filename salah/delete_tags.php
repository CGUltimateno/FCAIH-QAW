<?php
session_start();
require 'includes/dbh.inc.php';

define('TITLE',"Profile | klik");

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

include 'includes/HTML-head.php'; ?>
<style>
    table {
      margin: 50px auto;
      text-align: center;
      border-collapse: collapse;
      width: 80%;
    }
    th, td {
      padding: 10px;
      border: 1px solid #ddd;
    }
    th {
      background-color: #f2f2f2;
    }
    .delete-btn {
      background-color: #ff0000;
      color: #fff;
      border: none;
      padding: 5px 10px;
      cursor: pointer;
    }
  </style>
</head>
<body>

<?php include 'includes/navbar.php'; ?>

    <h3 style='font-size: 36px;
      color: #007bff;
      text-align: center;
      text-transform: uppercase;
      letter-spacing: 4px;
      margin-top: 50px;
      margin-bottom: 50px;
      text-shadow: 2px 2px #eee;'> welcome to the delete tags page</h3>
   
</body>
<hr>   
<h4 style='font-size: 36px;
      color: #007bff;
      text-align: center;
      text-transform: uppercase;
      letter-spacing: 4px;
      margin-top: 50px;
      margin-bottom: 50px;
      text-shadow: 2px 2px #eee;'>tags List</h4>
      </body>
<br><br>
  <table >
    <thead>
      <tr>
        
        <th>TAGS_ID </th>
        <th>TAGS_NAME </th>
       
        
        <th>DELETE</th>
      </tr>
    </thead>
    <tbody>
      <?php
        // استدعاء الأسئلة من قاعدة البيانات وعرضها في الجدول
        
        require 'includes/dbh.inc.php';
        if (isset($_POST['delete'])) {
    
            $id = $_POST['id'];
            // SQL query to delete the user with the specified ID
            $sql = "DELETE FROM tags WHERE id='$id'";
            if ($conn->query($sql) === TRUE) {
                echo "<script>";
                echo "alert('TAG DELETED SUCCESSFULLY.');";
                echo "</script>";
        
            } else {
                echo "Error deleting user: " . $conn->error;
            }
        }
        
        

        $sql = "SELECT * FROM tags";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
          while($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td>' . $row['id'] . '</td>';
            echo '<td>' . $row['name'] . '</td>';
            
            
            echo '<td>';
            echo "<form method='POST'>";
            echo "<input type='hidden' name='id' value='" . $row["id"] . "'>";
            echo "<input type='submit' name='delete' value='Delete'>";
            echo "</form>";
            echo '</tr>';
          }
        } else {
          echo '<tr><td colspan="7">THERE IS NO tags </td></tr>';
        }

        mysqli_close($conn);
      ?>
    </tbody>
  </table>
  