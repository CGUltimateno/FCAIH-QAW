<?php

    session_start();
    require 'inc/dbh.inc.php';
    define('TITLE',"Questions");
    
    if(!isset($_SESSION['id']))
    {
        header("Location: login.php");
        exit();
    }
    
    include 'inc/HTML-head.php';
?>  


	<link rel="stylesheet" type="text/css" href="css/list-page.css">
    </head>
    <body style="background: #f1f1f1">

        <?php
            
            include 'inc/navbar.php';
        
            if(isset($_GET['cat']))
            {
                $sql = "select * from categories "
                        . "where cat_ID = ?";
                
                $stmt = mysqli_stmt_init($db);

                if (!mysqli_stmt_prepare($stmt, $sql))
                {
                    die('SQL error');
                }
                else
                {
                    mysqli_stmt_bind_param($stmt, "s", $_GET['cat']);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);

                    $category = mysqli_fetch_assoc($result);
                }
            }
        ?>
   

        <main role="main" class="container">
      <div class="d-flex align-items-center p-3 my-3 text-white-50 bg-purple rounded shadow-sm">
          <img class="mr-3" src="image/400.png" alt="" width="48" height="48">
        <div class="lh-100">
          <h1 class="mb-0 text-white lh-100">Questions</h1>
          <small>Spreading Ideas</small>
        </div>
      </div>  
            
            
      <div class="my-3 p-3 bg-white rounded shadow-sm">
          <h5 class="border-bottom border-gray pb-2 mb-0">
                <?php 
                    if(isset($_GET['cat']))
                    {
                        echo '<a href="forum.php">Forums</a>
                        / <span style="color: #709fea ">'.ucwords($category['cat_name'])."</span>";
                    }
                    else
                    {
                        echo 'All Forums';
                    }
                ?>
          </h5>
        
        <?php

            $sql = "select topic_id, topic_subject, topic_date, topic_cat, topic_by, userImg, idUsers, uidUsers, cat_name, (
                            select sum(post_votes)
                        from posts
                        where post_topic = topic_id
                        ) as upvotes
                    from topics, users, categories 
                    where ";
            
            if(isset($_GET['cat']))
            {
                $sql .= "cat_id = " . $_GET['cat'] . " and ";
            }
            
            $sql .= "questions.user_id = users.id
                    and questions.id = categories.cat_ID
                    order by id asc ";
            $stmt = mysqli_stmt_init($db);
            
            if (!mysqli_stmt_prepare($stmt, $sql))
            {
                die('SQL error');
            }
            else
            {
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                while ($row = mysqli_fetch_assoc($result))
                {
                    
                    echo '<a href="posts.php?topic='.$row['id']. '">
                        <div class="media text-muted pt-3">
                            <img src="../image/forum-cover.png" alt="" class="mr-2 rounded div-img">
                            <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                              <strong class="d-block text-gray-dark">' .ucwords($row['title']).'</strong></a>
                              <span class="text-warning">'.ucwords($row['uidUsers']).'</span><br><br>
                              '.date("F jS, Y", strtotime($row['created_at'])).'
                            </p>
                            <span class="text-primary text-center">
                                <i class="fa fa-chevron-up" aria-hidden="true"></i><br>
                                    '.$row['upvotes'].'<br>';
                    
                    if ($_SESSION['userLevel'] == 1 || $_SESSION['userId'] == $row['id'])
                    {
                        echo '<a href="includes/delete-forum.php?id='.$row['topic_id'].'&page=topics" >
                                <i class="fa fa-trash" aria-hidden="true" style="color: red;"></i>
                              </a>
                            </span>';
                    }
                    else
                    {
                        echo '</span>';
                    }
                    echo '</span>
                            </div>';
                }
           }
        ?>
        
        <small class="d-block text-right mt-3">
            <a href="create-topic.php" class="btn btn-primary">Ask A Question</a>
        </small>
        
      </div>
    </main>
        
        <?php include 'inc/footer.php'; ?>
    </body>
</html>