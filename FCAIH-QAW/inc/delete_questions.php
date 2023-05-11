<?php
session_start();
require 'dbh.inc.php';

define('TITLE',"Profile | Discussio");

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

include 'HTML-head.php'; ?>
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

    <h3 style='font-size: 36px;
      color: #007bff;
      text-align: center;
      text-transform: uppercase;
      letter-spacing: 4px;
      margin-top: 50px;
      margin-bottom: 50px;
      text-shadow: 2px 2px #eee;'> welcome to the delete questions page</h3>
   
</body>
<hr>   
<h4 style='font-size: 36px;
      color: #007bff;
      text-align: center;
      text-transform: uppercase;
      letter-spacing: 4px;
      margin-top: 50px;
      margin-bottom: 50px;
      text-shadow: 2px 2px #eee;'>questions List</h4>
      </body>
<br><br>
  <table >
    <thead>
      <tr>
        <th>QUESTION_ID </th>
        <th>USER_ID </th>
        <th>TITLE </th>
        <th>BODY </th>
        <th>UPVOTES </th>
        <th>DOWNVOTES </th>
        <th>CREATED_AT </th>
        <th>DELETE</th>
      </tr>
    </thead>
    <tbody>
      <?php
        
        require 'dbh.inc.php';
        if (isset($_POST['delete'])) {
    
            $id = $_POST['id'];
            // SQL query to delete the user with the specified ID
            $sql = "DELETE FROM questions WHERE q_id='$id'";
            if ($db->query($sql) === TRUE) {
                echo "<script>";
                echo "alert('QUESTION DELETED SUCCESSFULLY.');";
                echo "</script>";
        
            } else {
                echo "Error deleting user: " . $db->error;
            }
        }
        
        

        $sql = "SELECT q_id,user_id,body,title,upvotes,downvotes,created_at FROM questions";
        $result = mysqli_query($db, $sql);

        if (mysqli_num_rows($result) > 0) {
          while($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td>' . $row['q_id'] . '</td>';
            echo '<td>' . $row['user_id'] . '</td>';
            echo '<td>' . $row['title'] . '</td>';
            echo '<td>' . $row['body'] . '</td>';
            echo '<td>' . $row['upvotes'] . '</td>';
            echo '<td>' . $row['downvotes'] . '</td>';
            echo '<td>' . $row['created_at'] . '</td>';
            echo '<td>';
            echo "<form method='POST'>";
            echo "<input type='hidden' name='id' value='" . $row["q_id"] . "'>";
            echo "<input type='submit' name='delete' value='Delete'>";
            echo "</form>";
            echo '</tr>';
          }
        } else {
          echo '<tr><td colspan="7">THERE IS NO QUESTIONS </td></tr>';
        }

        mysqli_close($db);
      ?>
    </tbody>
  </table>
  
  

