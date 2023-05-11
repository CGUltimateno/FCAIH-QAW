
<?php
    require_once "languages/lang.php";
    require_once 'inc/dbh.inc.php';
    define('TITLE',"Home");

        function strip_bad_chars( $input ){
    $output = preg_replace( "/[^a-zA-Z0-9_-]/", "", $input);
    return $output;
}

    if(!isset($_SESSION['id']))
    {
        header("Location: login.php");
        exit();
    }
    
    require_once 'inc/HTML-head.php';


?>
<link href="css/list-page.css" rel="stylesheet">
<link href="css/loader.css" rel="stylesheet">
    </head>
    
    <body onload="pageLoad()">

    <div id="loader-wrapper">
        <img src='image/500.png' id='loader-logo'>
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
            
            <?php require_once 'inc/navbar.php'; ?>
            
            <div class="container-fluid">
                <div class="row">
                    
                    <!---------------------------- Left Content -------------------------------->
					<div class="col-sm-3" >

                        <?php require_once 'inc/profile-card.php'; ?>

                    </div>
                    
                    <!-- ------------------------ Center Content ------------------------------>
                    <div class="col-sm-7" >

                        <!------------- Middle picture ---------->
                        <div class="text-center p-3">
                            <img src="image/400.png" alt="#">
                            <h2 class='text-muted'><?= __('Dashboard')?></h2>
                            <br>
                        </div>
                        
                        <!----------------- Tabs --------------->
                        <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
                            <li class="nav-item">
                              <a class="nav-link active" id="forum-tab" data-toggle="tab" href="#forum" role="tab" 
                                 aria-controls="forum" aria-selected="true"><?= __('Top Questions')?></a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" id="poll-tab" data-toggle="tab" href="#poll" role="tab" 
                                 aria-controls="poll" aria-selected="false"><?= __('Top Users')?></a>
                            </li>
                        </ul>

                        <br>

                        <!--------------------- Tab Contents --------------------->
                        <div class="tab-content" id="myTabContent">
                            
                            <!-- --------------------------- Questions Tab ----------------------------->
                            <div class="tab-pane fade show active" id="forum" role="tabpanel" aria-labelledby="forum-tab">

                                <div class="d-flex align-items-center p-3 my-3 text-white-50 bg-purple rounded shadow-sm">
                                    <img class="mr-3" src="image/400.png" alt="" width="48" height="48">
                                  <div class="lh-100">
                                    <h1 class="mb-0 text-white lh-100"><?= __('Top Questions')?></h1>
                                  </div>
                                </div>  

                                <div class="row mb-2">

                                    <?php
                                        $sql = "SELECT questions.q_id, title, questions.created_at, upvotes, downvotes, users.username
                                                FROM questions
                                                INNER JOIN users ON users.id = user_id
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
															<a href="posts.php?topic=<?php echo $row['q_id'] ?>">
															<img class="card-img-left flex-auto d-none d-lg-block blogindex-cover"
                                                                 src="image/forum-cover.png" alt="Card image cap">
															</a>
															<div class="card-body d-flex flex-column align-items-start">
																<strong class="d-inline-block mb-2 text-primary text-center  ml-auto">
																	<i class="fa fa-chevron-up" aria-hidden="true"></i><br><?php echo ($row['upvotes'] - $row['downvotes']) ?>
																</strong>
																<h6 class="mb-0">
																  <a class="text-dark" href="posts.php?topic=<?php echo $row['q_id'] ?>"><?php echo
																	substr($row['title'],0,30)?></a>
																</h6>
																<small class="mb-1 text-muted"><?php echo date("Y-m-d", strtotime($row['created_at'])) ?></small>
																<small class="card-text mb-auto">Created By: <?php echo $row['username'] ?></small>
																<a href="posts.php?topic= <?php echo $row['q_id'] ?>">Go To Question</a>
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
                                    <img class="mr-3" src="image/400.png" alt="" width="48" height="48">
                                    <div class="lh-100">
                                        <h1 class="mb-0 text-white lh-100"><?= __('Top Users')?></h1>
                                    </div>
                                </div>  

                                <div class="my-3 p-3 bg-white rounded shadow-sm">

                                    <?php

                                        $sql = "SELECT id, username, created_at, img, reputation
                                                FROM users
                                                ORDER BY reputation DESC
                                                LIMIT 6;";

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
                                                ?>
                                                    <div class="media text-muted pt-3">
                                                        <a href="profile.php?id=<?PHP echo $row['id']; ?>" >
                                                            <img src="<?php echo $row['img']?>" alt="" class="mr-2 rounded div-img poll-img">
                                                        </a>
                                                        <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray ">
                                                            <a href="profile.php?id=<?PHP echo $row['id']; ?>" >
                                                                <strong class="d-block text-gray-dark" style="font-size: 26px;"><?php echo ucwords($row['username']); ?></strong>
                                                            </a>
                                                            <?= __('Member since')?>
                                                            <?php echo date("Y-m-d", strtotime($row['created_at'])); ?>
                                                            <br>
                                                            <span class="text-primary" >
                                                                    <?= __('Reputation')?>: <?php echo $row['reputation']; ?>
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

                        <a href="communities.php" class="btn btn-secondary btn-lg btn-block"><?= __('Communities')?></a>

                    </div>
                </div>
            </div>
            <?php require_once 'inc/footer.php'; ?>
        </div>
        

        
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js" ></script>

        <script>
            var myVar;
            var dropdown = document.querySelectorAll(".languageDropdown");
            for (var i = 0; i < dropdown.length; i++) {
              dropdown[i].addEventListener("click", function(e) {
              for(var x = 0; x < dropdown.length; x++) {
                  dropdown[x].querySelector(".languageDropdown").classList.add("hide");
              }
              e.currentTarget.querySelector(".languageDropdown").classList.toggle("hide");
              });
            }
            function pageLoad() {
              myVar = setTimeout(showPage, 2000);
            }

            function showPage() {
              document.getElementById("loader-wrapper").style.display = "none";
              document.getElementById("content").style.display = "block";
            }
        </script>
    <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.min.js"></script>

    </body>
</html>