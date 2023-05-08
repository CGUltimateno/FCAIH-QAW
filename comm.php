
<?php

    session_start();
    require "languages/lang.php";
    require_once 'inc/dbh.inc.php';
    $comm_id = $_GET['comm_id'];

    //Getting the name of the community
    $sql2 = "SELECT name, description
            FROM communities
            WHERE comm_id = $comm_id;
            ";
    $result2 = mysqli_query($db, $sql2);
    if(mysqli_num_rows($result2) > 0){
        $row2 = mysqli_fetch_assoc($result2);
        
        $name = $row2['name'];
        $description = $row2['description'];

        define('TITLE',"$name");
    }

    
    
    if(!isset($_SESSION['id']))
    {
        header("Location: login.php");
        exit();
    }
    
    require_once 'inc/HTML-head.php';

?>

        <link href="css/list-page.css" rel="stylesheet">
    </head>
    
    <body>
        
        <div id="content">
            
            <?php require_once 'inc/navbar.php'; ?>
            
            <div class="container-fluid">
                <div class="row">
                    
                    <!---------------------------- Left Content -------------------------------->
					<div class="col-sm-3" >
                        
                        <?php require_once 'inc/profile-card.php'; ?>
                        
                    </div>
                    
                    <!-- ------------------------ Center Content ------------------------------>
                    <div class="col-sm-7" >

                        <div class="text-center p-3">
                            <h2 class='text-muted'><?php echo $name ?></h2>
                            <br>
                            <p class="text-muted"><?php echo $description ?></p>
                            <br>
                        </div>

                        <!----------------- Tabs --------------->
                        <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
                            <li class="nav-item">
                              <a class="nav-link active" id="forum-tab" data-toggle="tab" href="#forum" role="tab" 
                                 aria-controls="forum" aria-selected="true"><?= __('Top Questions')?></a>
                            </li>
                        </ul>

                        <br>

                        <!--------------------- Tab Contents --------------------->
                        <div class="tab-content" id="myTabContent">
                            
                            <!-- --------------------------- Communities Tab ----------------------------->
                            <div class="tab-pane fade show active" id="forum" role="tabpanel" aria-labelledby="forum-tab">

                                <div class="d-flex align-items-center p-3 my-3 text-white-50 bg-purple rounded shadow-sm">
                                    <img class="mr-3" src="image/400.png" alt="" width="48" height="48">
                                  <div class="lh-100">
                                    <h1 class="mb-0 text-white lh-100"><?= __("Top Questions in $name")?></h1>
                                  </div>
                                </div>  

                                <div class="row mb-2">

                                    <?php
                                        $sql = "SELECT questions.id, title, questions.created_at, upvotes, downvotes, users.username
                                                FROM questions
                                                INNER JOIN users ON users.id = user_id
                                                WHERE community_id = $comm_id
                                                ORDER BY upvotes DESC
                                                LIMIT 6";
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
                                                ?><div class="col-md-6">
                                                        <div class="card flex-md-row mb-4 shadow-sm h-md-250">
															<a href="posts.php?topic=<?php echo $row['id'] ?>">
															<img class="card-img-left flex-auto d-none d-lg-block blogindex-cover"
                                                                 src="image/forum-cover.png" alt="Card image cap">
															</a>
															<div class="card-body d-flex flex-column align-items-start">
																<strong class="d-inline-block mb-2 text-primary text-center  ml-auto">
																	<i class="fa fa-chevron-up" aria-hidden="true"></i><br><?php echo ($row['upvotes'] - $row['downvotes']) ?>
																</strong>
																<h6 class="mb-0">
																  <a class="text-dark" href="posts.php?topic=<?php echo $row['id'] ?>"><?php echo
																	substr($row['title'],0,20)?>...</a>
																</h6>
																<small class="mb-1 text-muted"><?php echo date("Y-m-d", strtotime($row['created_at'])) ?></small>
																<small class="card-text mb-auto">Created By: <?php echo $row['username'] ?></small>
																<a href="posts.php?topic= <?php echo $row['id'] ?>">Go To Forum</a>
															</div>

                                                        </div>
                                                    </div><?php
                                            }
                                        }
                                    ?>        


                                </div>

                            </div>
                        </div>
                    </div>
                    
                    <!-- ---------------------------- Right Content ------------------------>
                    <div class="col-sm-2">

                        <br><br><br>
                        <a href="communities.php" class="btn btn-primary btn-lg btn-block"><?= __('Communities')?></a>
                        <a href="question.php" class="btn btn-warning btn-lg btn-block"><?= __('Ask Question')?></a>
                        <a href="index.php" class="btn btn-secondary btn-lg btn-block"><?= __('Home')?></a>

                    </div>
                </div>
            </div>
            <?php require_once 'inc/footer.php'; ?>
        </div>
        

        
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js" ></script>
        
    </body>
</html>