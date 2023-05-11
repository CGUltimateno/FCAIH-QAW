<?php
    require 'inc/dbh.inc.php';
    include 'languages/lang.php';
    define('TITLE',"Questions");

    if(!isset($_SESSION['id']))
    {
        header("Location: login.php");
        exit();
    }

    if (isset($_GET['topic']))
    {
        $q_id = preg_replace("/[^0-9]/", "", $_GET['topic']);
    }
    else
    {
        header("Location: index.php");
        exit();
    }

    include 'inc/HTML-head.php';
?>

        <link href="css/forum-styles.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.vote-up, .vote-down').click(function(event) {
                event.preventDefault();

                var answerId = $(this).data('answer-id');
                var action = $(this).hasClass('vote-up') ? 'upvote' : 'downvote';

                $.ajax({
                    url: 'vote.php',
                    type: 'post',
                    data: { answer_id: answerId, action: action },
                    success: function(response) {
                        $('.vote-count[data-answer-id="' + answerId + '"]').html(response);
                    }
                });
            });
        });
    </script>
    </head>

<body>

<?php

    include 'inc/navbar.php';

    if (isset($_POST['submit-reply']))
    {
        $content = $_POST['reply-content'];

        if (!empty($content))
        {
            $sql = "insert into answers(body, created_at, question_id, user_id, upvotes, downvotes) "
                    . "values (?,now(),?,?,0,0)";
            $stmt = mysqli_stmt_init($db);

            if (!mysqli_stmt_prepare($stmt, $sql))
            {
                die('sql error');
            }
            else
            {
                mysqli_stmt_bind_param($stmt, "sss", $content, $q_id, $_SESSION['id']);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
            }
        }
    }

    


$sql = "SELECT questions.*, communities.name AS comm_name "
    . "FROM questions "
    . "INNER JOIN communities ON questions.comm_id = communities.comm_id "
    . "WHERE questions.q_id = ?";

$stmt = mysqli_stmt_init($db);

if (!mysqli_stmt_prepare($stmt, $sql))
{
    die('sql error');
}
else
{
    mysqli_stmt_bind_param($stmt, "s", $q_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (!($forum = mysqli_fetch_assoc($result)))
    {
        die('sql error');
    }

    // Get user details
    $user_query = "SELECT users.username, users.bio, users.img "
        . "FROM users "
        . "INNER JOIN questions ON users.id = questions.user_id "
        . "WHERE questions.q_id = ?";
    $user_stmt = mysqli_stmt_init($db);
    if (mysqli_stmt_prepare($user_stmt, $user_query))
    {
        mysqli_stmt_bind_param($user_stmt, "s", $q_id);
        mysqli_stmt_execute($user_stmt);
        $user_result = mysqli_stmt_get_result($user_stmt);
        if ($user_row = mysqli_fetch_assoc($user_result))
        {
            $username = $user_row['username'];
            $bio = $user_row['bio'];
            $img = $user_row['img'];
        }
    }
}
?>
    <br><Br>
    <div class="container">
    <div class="col-sm-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="Communities.php"><?= __('Communities')?></a></li>
                <li class="breadcrumb-item"><a href="comm.php"><?php echo ucwords($forum['comm_name']); ?></a></li>
                <li></li>
            </ol>
        </nav>
        <div class="card post-header">
            <div class="row">
                <div class="col-sm-3 user">
                    <div class="text-center">
                        <img src="<?php echo $img; ?>" class="img-fluid center-block user-img">
                        <h3><?php echo $username; ?></h3>
                        <small class="text-muted"><?php echo $bio; ?></small><br><br>
                        <a href="profile.php?id='.$row['id'].'">
                            <i class="fa fa-user fa-2x" aria-hidden="true"></i></a>
                    </div>
                </div>
                <div class="col-sm-9 title">
                    <h1><?php echo ucwords($forum['title']); ?></h1>
                    <p><?php echo($forum['body']); ?></p>
                    <div class="text-right">
                        <small class="text-muted"><?php echo date('F j, Y', strtotime($forum['created_at'])); ?></small>
                    </div>
                </div>
            </div>
            <div class="post-footer">
                <div class="row">
                    <div class="col-sm-9"></div>
                    <div class="col-sm-3">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12">



            <?php

                $sql = "select * from answers a, users u "
                        . "where a.question_id=? "
                        . "and a.user_id=u.id "
                        . "order by a.answer_id;";
                $stmt = mysqli_stmt_init($db);

                if (!mysqli_stmt_prepare($stmt, $sql))
                {
                    die('sql error');
                }
                else
                {
                    mysqli_stmt_bind_param($stmt, "s", $q_id);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);

                     $i = 1;
                     while ($row = mysqli_fetch_assoc($result))
                     {

                         $voted_u = false;
                        $voted_d = false;
                             $sql = "select question_id, user_id, type from votes "
                             . "where question_id=? "
                            . "and user_id=? "
                             . "and type=1";

                         $stmt = mysqli_stmt_init($db);

                         if (!mysqli_stmt_prepare($stmt, $sql))
                         {
                            die('sql error');
                         }
                         else
                         {
                            mysqli_stmt_bind_param($stmt, "ss", $row['post_id'], $_SESSION['id']);
                            mysqli_stmt_execute($stmt);
                             mysqli_stmt_store_result($stmt);

                             $resultCheck = mysqli_stmt_num_rows($stmt);

                             if ($resultCheck == 0)
                             {
                                $voted_u = true;
                             }
                         }

                         $sql = "select question_id, user_id, type from votes "
                             . "where question_id=? "
                             . "and user_id=? "
                             . "and type=1";

                         $stmt = mysqli_stmt_init($db);

                         if (!mysqli_stmt_prepare($stmt, $sql))
                         {
                             die('sql error');
                         }
                         else
                         {
                             mysqli_stmt_bind_param($stmt, "ss", $row['post_id'], $_SESSION['id']);
                             mysqli_stmt_execute($stmt);
                             mysqli_stmt_store_result($stmt);

                             $resultCheck = mysqli_stmt_num_rows($stmt);

                             if ($resultCheck == 0)
                             {
                                 $voted_u = true;
                             }
                         }

                         $sql = "select question_id, user_id, type from votes "
                             . "where question_id=? "
                             . "and user_id=? "
                             . "and type=1";
                         $stmt = mysqli_stmt_init($db);
                         if (!mysqli_stmt_prepare($stmt, $sql))
                         {
                             die('sql error');
                         }
                         else
                         {
                             mysqli_stmt_bind_param($stmt, "ss", $row['post_id'], $_SESSION['id']);
                             mysqli_stmt_execute($stmt);
                             mysqli_stmt_store_result($stmt);

                             $resultCheck = mysqli_stmt_num_rows($stmt);

                             if ($resultCheck == 0)
                             {
                                 $voted_d = true;
                             }
                         }

                        echo '<div class="card post">  
                                <span class="date">'.date("F jS, Y", strtotime($row['created_at']))
                                .'<span class="span-post-no">#'.$i.'</span> </span>
                                <div class="row">

                                    <div class="col-sm-3 user">
                                        <div class="text-center">
                                            <img src="'.$row['img'].'" class="img-fluid center-block user-img">
                                            <h3>'.$row['username'].'</h3>
                                            <small class="text-muted">'.$row['bio'].'</small><br><br>
                                            <a href="profile.php?id='.$row['id'].'">
                                                <i class="fa fa-user fa-2x" aria-hidden="true"></i></a>

                                        </div>
                                    </div>

                                    <div class="col-sm-9 title">
                                        <p>'.$row['body'].'</p>
                                            <div class="vote text-center">';

                        if ( ($row['id']==$_SESSION['id']) || ($_SESSION['username'] == 'admin'))
                        {  
                            ?><a href="inc/delete-post.php?answer_id=<?php echo $row['answer_id'] ?>&q_id=<?php echo $q_id ?>">
                            <i class="fa fa-trash fa-2x" aria-hidden="true"></i></a><br><?php
                        }
    // Upvote button
    echo '<a href="#" class="vote-up" data-answer-id="'.$row['answer_id'].'">
              <i class="fa fa-chevron-up fa-3x" aria-hidden="true"></i>
          </a>';
  
    // Vote count
    echo '<br><span class="vote-count" data-answer-id="'.$row['answer_id'].'">'.$row['upvotes'] - $row['downvotes'].'</span><br>';
  
    // Downvote button
    echo '<a href="#" class="vote-down" data-answer-id="'.$row['answer_id'].'">
              <i class="fa fa-chevron-down fa-3x" aria-hidden="true"></i>
          </a>';
  
    echo '</div>
          </div>
      </div>
      <span class="likes"><span class="span-post-no"></span> <span class="span-post-no"><a href="">Answers</a></span></span>
  </div>';
  
    $i++;
}
                 }

            ?>


    </div>


    <div class="col-sm-12">
        <form method="post" action="">
            <fieldset>
                <div class="form-group">
                    <textarea name="reply-content" class="form-control" id="reply-form" rows="7"></textarea>
                </div>
                <input type="submit" value="<?= __('Submit Reply')?>" class="btn btn-lg btn-dark" name="submit-reply">
            </fieldset>
        </form>
    </div>
</div>

    <?php include 'inc/footer.php'; ?>
        <script src="js/bootstrap.min.js" ></script>
    </body>
</html>