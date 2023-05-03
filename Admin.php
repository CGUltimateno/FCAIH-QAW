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
    <h3 style='text-align:center'> welcome to your profile Admin </h3>
    <?php include 'includes/profile-card.php'; ?> 
</body>





  <ul style='list-style: none;
      margin: 0;
      padding: 0;
      text-align: center;'>
    <li style='display: inline-block;
      margin-right: 10px;
      vertical-align: middle;'><button style="display: inline-block;
      padding: 10px;
      background-color: #007bff;
      color: #fff;
      font-size: 16px;
      border: none;
      border-radius: 5px;
      cursor: pointer;" onclick="location.href='delete_users.php';"> 
DELETE USERS
</button>
</li>
    <li style='display: inline-block;
      margin-right: 10px;
      vertical-align: middle;'><button style="display: inline-block;
      padding: 10px;
      background-color: #007bff;
      color: #fff;
      font-size: 16px;
      border: none;
      border-radius: 5px;
      cursor: pointer;" onclick="location.href='delete_questions.php';"> 
DELETE QUESTIONS
</button>
</li>
    <li style='display: inline-block;
      margin-right: 10px;
      vertical-align: middle;'><button style="display: inline-block;
      padding: 10px;
      background-color: #007bff;
      color: #fff;
      font-size: 16px;
      border: none;
      border-radius: 5px;
      cursor: pointer;" onclick="location.href='delete_answers.php';"> 
DELETE ANSWERS
</button>
</li>
    <li style='display: inline-block;
      margin-right: 10px;
      vertical-align: middle;'><button style="display: inline-block;
      padding: 10px;
      background-color: #007bff;
      color: #fff;
      font-size: 16px;
      border: none;
      border-radius: 5px;
      cursor: pointer;" onclick="location.href='delete_community.php';"> 
DELETE community
</button>
</li>
    <li style='display: inline-block;
      margin-right: 10px;
      vertical-align: middle;'><button style="display: inline-block;
      padding: 10px;
      background-color: #007bff;
      color: #fff;
      font-size: 16px;
      border: none;
      border-radius: 5px;
      cursor: pointer;" onclick="location.href='delete_tags.php';"> 
DELETE TAGS
</button></li>
  </ul>












