
<?php

    session_start();
    require_once 'includes/dbh.inc.php';
    define('TITLE',"Communities");
    
    if(!isset($_SESSION['userId']))
    {
        header("Location: login.php");
        exit();
    }
    
    require_once 'includes/HTML-head.php';


    //Connection to the database 'database'. remove later.

    //-------- Form Validation and querry----------
    $commErrMsg = "";
    if(isset($_POST['community_name']) && isset($_POST['community_description'])){
        if(empty($_POST['community_name']) || empty($_POST['community_description']))
        {
            $commErrMsg = '<div class="alert alert-danger" role="alert">
                            <strong>Error: </strong>Fill In All The Fields
                            </div>';
        }
        else{
            $commName = $_POST['community_name'];
            $commDescription = $_POST['community_description'];
            $sql2 = "INSERT INTO communities(name, description)
                    VALUES ('$commName', '$commDescription')";
            mysqli_query($conn, $sql2);
        }
    }
    

?>
        <link href="css/list-page.css" rel="stylesheet">
    </head>
    
    <body>
        
        <div id="content">
            
            <?php require_once 'includes/navbar.php'; ?> 
            
            <div class="container-fluid">
                <div class="row">
                    
                    <!---------------------------- Left Content -------------------------------->
					<div class="col-sm-3" >
                        
                        <?php //require_once 'includes/profile-card.php'; ?>
                        
                    </div>
                    
                    <!-- ------------------------ Center Content ------------------------------>
                    <div class="col-sm-7" >

                        <!------------- Form ---------->
                        <div class="text-center p-3">
                            
                            <h3 class='text-muted'>Add Community</h3>
                            <br>
                            <form action="" method='post'>
                                <div class="form-group">
                                    
                                    <label for="" class="text-muted">Community Name</label>
                                    <input class="form-control" type="text" id="" name="community_name" 
                                        placeholder="Community Name" ><br>
                                    <label for="" class="text-muted">Community Description</label>
                                    <textarea class="form-control" id="" rows="5" name="community_description" maxlength="200"
                                        placeholder="Community Description" >
                                    </textarea>
                                    <br>
                                    <?php 
                                        echo $commErrMsg;
                                    ?>

                                    <input type="submit" class="btn btn-primary" name="create_community" value="Create Community">
                                </div>
                            </form>
                        </div>

                        <!----------------- Tabs --------------->
                        <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
                            <li class="nav-item">
                              <a class="nav-link active" id="forum-tab" data-toggle="tab" href="#forum" role="tab" 
                                 aria-controls="forum" aria-selected="true">Communities</a>
                            </li>
                        </ul>

                        <br>

                        <!--------------------- Tab Contents --------------------->
                        <div class="tab-content" id="myTabContent">
                            
                            <!-- --------------------------- Communities Tab ----------------------------->
                            <div class="tab-pane fade show active" id="forum" role="tabpanel" aria-labelledby="forum-tab">

                                <div class="d-flex align-items-center p-3 my-3 text-white-50 bg-purple rounded shadow-sm">
                                    <img class="mr-3" src="img/200.png" alt="" width="48" height="48">
                                  <div class="lh-100">
                                    <h1 class="mb-0 text-white lh-100">COMMUNITIES</h1>
                                  </div>
                                </div>  

                                <div class="my-3 p-3 bg-white rounded shadow-sm">

                                    <?php

                                        $sql = "SELECT name, description
                                                FROM communities
                                                LIMIT 6";

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
                                                        <a href="#" >
                                                            <img src="img/com.png" alt="" class="mr-2 rounded div-img poll-img">
                                                        </a>
                                                        <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray ">
                                                            <a href="#" >
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
                        <a href="Ask_A_Question.php" class="btn btn-warning btn-lg btn-block">Ask Question</a>
                        <a href="index.php" class="btn btn-secondary btn-lg btn-block">Home</a>

                    </div>
                </div>
            </div>
            <?php require_once 'includes/footer.php'; ?>
        </div>
        

        
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js" ></script>
        
    </body>
</html>