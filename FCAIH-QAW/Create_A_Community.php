<?php
require_once 'languages/lang.php';
require_once 'inc/dbh.inc.php';
define('TITLE',"Communities");

if(!isset($_SESSION['id']))
{
    header("Location: login.php");
    exit();
}

$commErrMsg = "";
if (isset($_POST['community_name']) && isset($_POST['community_description'])) {
    if (empty($_POST['community_name']) || empty($_POST['community_description'])) {
        $commErrMsg = '<div class="alert alert-danger" role="alert">
                            <strong>Error: </strong>Fill In All The Fields
                            </div>';
    } else {
        $commName = $_POST['community_name'];
        $commDescription = $_POST['community_description'];
        $sql2 = "INSERT INTO communities(name, description)
                    VALUES ('$commName', '$commDescription')";
        mysqli_query($db, $sql2);
        mysqli_close($db); // Close the database connection

        header("Location: Communities.php");
        exit();
    }
}

require_once 'inc/HTML-head.php';
?>

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
                <div class="text-center p-3">

                    <h3 class='text-muted'><?= __('Add Community')?></h3>
                    <br>
                    <form action="" method='post'>
                        <div class="form-group">

                            <label for="" class="text-muted"><?= __('Community Name')?></label>
                            <input class="form-control" type="text" id="" name="community_name"
                                   placeholder="<?= __('Community Name')?>" ><br>
                            <label for="" class="text-muted"><?= __('Community Description')?></label>
                            <textarea class="form-control" id="" rows="5" name="community_description" maxlength="200"
                                      placeholder="<?= __('Community Description')?>" >
                                    </textarea>
                            <br>
                            <?php
                            echo $commErrMsg;
                            ?>

                            <input type="submit" class="btn btn-primary" name="create_community" value="<?= __('Create Community')?>">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php require_once 'inc/footer.php'; ?>
</div>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js" ></script>
</body>
</html>
