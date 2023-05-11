<?php
require 'inc/dbh.inc.php';
require 'languages/lang.php';
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


$sql = "select * from users where id = ".$userid;
$stmt = mysqli_stmt_init($db);    

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


include 'inc/HTML-head.php';
?>
</head>
<body>
  <?php include 'inc/navbar.php'; ?>
  <h3 style='text-align:center' data-i18n="wlcome"> <?= __('Welcome to your profile,')?> <?php echo  $_SESSION['username'];?> </h3>
    <?php include 'inc/profile-card.php'; ?>

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
      cursor: pointer;" onclick="location.href='inc/delete_users.php';">DELETE USERS</button>
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
      cursor: pointer;" onclick="location.href='inc/delete_questions.php';">
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
      cursor: pointer;" onclick="location.href='inc/delete_answers.php';">
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
      cursor: pointer;" onclick="location.href='inc/delete_community.php';">
DELETE community
</button>
</li>
  </ul>
</body>









