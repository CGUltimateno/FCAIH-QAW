
<?php

    session_start();
    require_once 'includes/dbh.inc.php';
    define('TITLE',"Home");
    
    if(!isset($_SESSION['userId']))
    {
        header("Location: login.php");
        exit();
    }
    
    require_once 'includes/HTML-head.php';


    //Connection to the database 'database'. remove later.

?>
        <link href="css/list-page.css" rel="stylesheet">
        <link href="css/loader.css" rel="stylesheet">
    </head>
    
    <body onload="pageLoad()">
        
        <div id="loader-wrapper">
        <img src='img/500.png' id='loader-logo'>
            <div class="loader">
                <div class="loader__bar"></div>
                <div class="loader__bar"></div>
                <div class="loader__bar"></div>
                <div class="loader__bar"></div>
                <div class="loader__bar"></div>
                <div class="loader__ball"></div>
            </div>
        </div>
        
        <div id="content" style="display: none">
            
            <?php require_once 'includes/navbar.php'; ?> 
            
            <div class="container-fluid">
                <div class="row">
                    
                    <!---------------------------- Left Content -------------------------------->
					<div class="col-sm-3" >

                        <?php //require_once 'includes/profile-card.php'; ?>

                    </div>
                    
                    <!-- ------------------------ Center Content ------------------------------>
                    <div class="col-sm-7" >

                        <!------------- Middle picture ---------->
                        <div class="text-center p-3">
                            <img src="img/200.png">
                            <h2 class='text-muted'>DASHBOARD</h2>
                            <br>
                        </div>
                        
                        <!----------------- Tabs --------------->
                        <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
                            <li class="nav-item">
                              <a class="nav-link active" id="forum-tab" data-toggle="tab" href="#forum" role="tab" 
                                 aria-controls="forum" aria-selected="true">Top Questions</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" id="poll-tab" data-toggle="tab" href="#poll" role="tab" 
                                 aria-controls="poll" aria-selected="false">Top Users</a>
                            </li>
                        </ul>

                        <br>

                        <!--------------------- Tab Contents --------------------->
                        <div class="tab-content" id="myTabContent">
                            
                            <!-- --------------------------- Questions Tab ----------------------------->
                            <div class="tab-pane fade show active" id="forum" role="tabpanel" aria-labelledby="forum-tab">

                                <div class="d-flex align-items-center p-3 my-3 text-white-50 bg-purple rounded shadow-sm">
                                    <img class="mr-3" src="img/200.png" alt="" width="48" height="48">
                                  <div class="lh-100">
                                    <h1 class="mb-0 text-white lh-100">TOP QUESTIONS</h1>
                                  </div>
                                </div>  

                                <div class="row mb-2">

                                    <?php
                                        $sql = "SELECT questions.id, title, questions.created_at, upvotes, downvotes, users.username
                                                FROM questions
                                                INNER JOIN users ON users.id = user_id
                                                ORDER BY upvotes DESC
                                                LIMIT 6";
                                        $stmt = mysqli_stmt_init($conn);  //make it $conn latter

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
																	src="img/forum-cover.png" alt="Card image cap">
															</a>
															<div class="card-body d-flex flex-column align-items-start">
																<strong class="d-inline-block mb-2 text-primary text-center  ml-auto">
																	<i class="fa fa-chevron-up" aria-hidden="true"></i><br><?php echo ($row['upvotes'] - $row['downvotes']) ?>
																</strong>
																<h6 class="mb-0">
																  <a class="text-dark" href="posts.php?topic=<?php echo $row['id'] ?>"><?php echo
																	substr($row['title'],0,30)?></a>
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
                            <!-- ----------------------------- Users Tab ------------------------------->
                            <div class="tab-pane fade" id="poll" role="poll" aria-labelledby="poll-tab">

                                <div class="d-flex align-items-center p-3 my-3 text-white-50 bg-purple rounded shadow-sm">
                                    <img class="mr-3" src="img/200.png" alt="" width="48" height="48">
                                    <div class="lh-100">
                                        <h1 class="mb-0 text-white lh-100">TOP USERS</h1>
                                    </div>
                                </div>  

                                <div class="my-3 p-3 bg-white rounded shadow-sm">

                                    <?php

                                        $sql = "SELECT id, username, created_at, img, reputation
                                                FROM users
                                                ORDER BY reputation DESC
                                                LIMIT 6;";

                                        $stmt = mysqli_stmt_init($conn);    

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
                                                ?>
                                                    <div class="media text-muted pt-3">
                                                        <a href="profile.php?id=<?PHP echo $row['id']; ?>" >
                                                            <img src="img/<?php echo $row['img']?>" alt="" class="mr-2 rounded div-img poll-img">
                                                        </a>
                                                        <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray ">
                                                            <a href="profile.php?id=<?PHP echo $row['id']; ?>" >
                                                                <strong class="d-block text-gray-dark" style="font-size: 26px;"><?php echo ucwords($row['username']); ?></strong>
                                                            </a>
                                                            Member Since: 
                                                            <?php echo date("Y-m-d", strtotime($row['created_at'])); ?>
                                                            <br>
                                                            <span class="text-primary" >
                                                                    Reputation: <?php echo $row['reputation']; ?>
                                                            </span>
                                                        </p>
                                                    </div>
                                                <?PHP
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

                        <a href="Ask_A_Question.php" class="btn btn-warning btn-lg btn-block">Ask Question</a>
                        <a href="communities.php" class="btn btn-secondary btn-lg btn-block">Communities</a>

                    </div>
                </div>
            </div>
            <?php require_once 'includes/footer.php'; ?>
        </div>
        

        
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js" ></script>

        <script>
            var myVar;

            function pageLoad() {
              myVar = setTimeout(showPage, 2000);
            }

            function showPage() {
              document.getElementById("loader-wrapper").style.display = "none";
              document.getElementById("content").style.display = "block";
            }
        </script>  
        
    </body>
</html>