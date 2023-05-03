
<?php

session_start();
require 'includes/dbh.inc.php';

define('TITLE',"Profile | KLiK");

if(!isset($_SESSION['username']))
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
    <h3 style='text-align:center' data-i18n="wlcome"> welcome to your profile <?php echo  $_SESSION['username'];?> </h3>
    <div class="container">
        <div class="row">
          <div class="col-sm-3">

           <?php include 'includes/profile-card.php'; ?> 



           </div>
            
            
            <div class="col-sm-8 text-center" id="user-section">
                <img class="cover-img" src="img/user-cover.png">
                <img class="profile-img" src="img/<?php echo $user['img']; ?>">
                
                
                
                <h2 data-i18n="username"><?php echo ucwords($user['username']); ?></h2>
                <h6 data-i18n="fl_name"><?php echo ucwords($user['f_name']) . " " . ucwords($user['l_name']); ?></h6>
                <h6><?php echo '<small class="text-muted">'.$user['email'].'</small>'; ?></h6>
                
                <?php 
                  if ($user['gender'] == 'm')
                  {
                      echo '<i class="fa fa-male fa-2x" aria-hidden="true" style="color: #709fea;"></i>';
                  }
                  else if ($user['gender'] == 'f')
                  {
                      echo '<i class="fa fa-female fa-2x" aria-hidden="true" style="color: #FFA6F5;"></i>';
                  }
                  ?>
                
                
                <br><br>
                <div class="profile-bio" style='text-align:center'>
                    <small><?php echo $user['bio'];?></small>
                </div>
                
                
                <hr>
                <h3>posted questions</h3>
                <br><br>
                
                <?php
                      $sql = "select * from questions "
                              . "where user_id = ?";
                      $stmt = mysqli_stmt_init($conn);    
  
                      if (!mysqli_stmt_prepare($stmt, $sql))
                      {
                          die('SQL error');
                      }
                      else
                      {
                          mysqli_stmt_bind_param($stmt, "s", $userid);
                          mysqli_stmt_execute($stmt);
                          $result = mysqli_stmt_get_result($stmt);
                          
                          echo '<div class="container">'
                                      .'<div class="row">';
                          
                          $row = mysqli_fetch_assoc($result);
                         
                          if(empty($row))
                          {
                              echo '<div class="col-sm-4" style="padding-bottom: 30px;"></div>
                                  <div class="col-sm-4">
                                      <img class="profile-empty-img" src="img/empty.png">
                                    </div>
                                    <div class="col-sm-4" style="padding-bottom: 30px;"></div>
                                      </div>
                                    </div>';
                          }
                          else
                          {
                              do
                              {       
                                      echo '<div class="col-sm-4" style="padding-bottom: 30px;">
                                          <div class="card user-blogs">
                                              <a href="Question.php?id='.$row['user_id'].'">
                                             
                                              <div class="card-block p-2">
                                                <p class="card-title">'.ucwords($row['title']).'</p>
                                                <p>'. ucwords($row['body']).'</p>
                                               <p class="card-text"><small class="text-muted">'
                                               .date("F jS, Y", strtotime($row['created_at'])).'</small></p>
                                              </div>
                                              </a>
                                            </div>
                                            </div>';
                              }while ($row = mysqli_fetch_assoc($result));
                              echo '</div>'
                                      .'</div>';
                          }
                      }
                ?>
                
                <br><br>



                <hr>
              <h3>posted answers</h3>
              <br><br>
              
              <?php
                    $sql = "select * from answers "
                            . "where user_id = ?";
                    $stmt = mysqli_stmt_init($conn);    

                    if (!mysqli_stmt_prepare($stmt, $sql))
                    {
                        die('SQL error');
                    }
                    else
                    {
                        mysqli_stmt_bind_param($stmt, "s", $userid);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        
                        
                        echo '<div class="container">'
                                    .'<div class="row">';
                        
                        $row = mysqli_fetch_assoc($result);
                        if(empty($row))
                        {
                            echo '<div class="col-sm-4" style="padding-bottom: 30px;"></div>
                                <div class="col-sm-4">
                                    <img class="profile-empty-img" src="img/empty.png">
                                  </div>
                                  <div class="col-sm-4" style="padding-bottom: 30px;"></div>
                                    </div>
                                  </div>';
                        }
                        else
                        {
                            do
                            {       
                                    echo '<div class="col-sm-4" style="padding-bottom: 30px;">
                                        <div class="card user-blogs">
                                            <a href="Answer.php?id='.$row['user_id'].'">
                                            
                                            <div class="card-block p-2">
                                              <p class="card-title">'.ucwords($row['body']).'</p>
                                             <p class="card-text"><small class="text-muted">'
                                             .date("F jS, Y", strtotime($row['created_at'])).'</small></p>
                                            </div>
                                            </a>
                                          </div>
                                          </div>';
                            }while ($row = mysqli_fetch_assoc($result));
                            echo '</div>'
                                    .'</div>';
                        }
                    }
              ?>
              
              <br><br>

              <hr>
              <h3>Available communities</h3>
              <br><br>
              
              <?php
                    $sql = "select * from communities ";
                            
                    $stmt = mysqli_stmt_init($conn);    

                    if (!mysqli_stmt_prepare($stmt, $sql))
                    {
                        die('SQL error');
                    }
                    else
                    {
                       
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        
                        
                        echo '<div class="container">'
                                    .'<div class="row">';
                        
                        $row = mysqli_fetch_assoc($result);
                        if(empty($row))
                        {
                            echo '<div class="col-sm-4" style="padding-bottom: 30px;"></div>
                                <div class="col-sm-4">
                                    <img class="profile-empty-img" src="img/empty.png">
                                  </div>
                                  <div class="col-sm-4" style="padding-bottom: 30px;"></div>
                                    </div>
                                  </div>';
                        }
                        else
                        {
                            do
                            {       
                                    echo '<div class="col-sm-4" style="padding-bottom: 30px;">
                                        <div class="card user-blogs">
                                            <a href="communities.php?id='.$row['comm_id'].'">
                                            
                                            <div class="card-block p-2">
                                              <p class="card-title">'.ucwords($row['name']).'</p>
                                              <p class="card-title">'.ucwords($row['description']).'</p>
                                            
                                            </div>
                                            </a>
                                          </div>
                                          </div>';
                            }while ($row = mysqli_fetch_assoc($result));
                            echo '</div>'
                                    .'</div>';
                        }
                    }
              ?>
              
              <br><br>





                
                
                
            </div>
            <div class="col-sm-1">
              
            </div>
          </div>
  
  
        </div> 






</body>