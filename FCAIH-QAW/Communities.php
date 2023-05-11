
<?php

    session_start();
require "languages/lang.php";
require_once 'inc/dbh.inc.php';
    define('TITLE',"Communities");
    
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

                        <!------------- Form ---------->

                        <!----------------- Tabs --------------->
                        <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
                            <li class="nav-item">
                              <a class="nav-link active" id="forum-tab" data-toggle="tab" href="#forum" role="tab"
                                 aria-controls="forum" aria-selected="true"><?= __('Communities')?></a>
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
                                        <h1 class="mb-0 text-white lh-100"><?= __('Communities')?></h1>
                                    </div>
                                </div>

                                <div class="my-3 p-3 bg-white rounded shadow-sm">

                                    <?php

                                    $sql = "SELECT name, description, comm_id
                                                FROM communities
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
                                            ?>

                                            <div class="media text-muted pt-3">
                                                <a href="comm.php?comm_id=<?php echo $row['comm_id']; ?>" >
                                                    <img src="image/forum-cover.png" alt="" class="mr-2 rounded div-img poll-img">
                                                </a>
                                                <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray ">
                                                    <a href="comm.php?comm_id=<?php echo $row['comm_id']; ?>" >
                                                        <strong class="d-block text-gray-dark" style="font-size: 26px;"><?php echo $row['name']; ?></strong>
                                                    </a>
                                                    <?php echo $row['description']; ?>
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
                        <a href="Create_A_Community.php" class="btn btn-primary btn-lg btn-block"><?= __('Create Community')?></a>
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