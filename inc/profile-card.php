<div class='card card-profile text-center'>
    <img alt='' class='card-img-top card-user-cover' src='image/user-cover.jpg'>
    <div class='card-block'>
        <?php if($_SESSION['username']=='admin'){
            $r="Admin.php?login=success";
        }
        else{
            $r="profile.php?login=success";
        }
        ?>
        <a href='<?php echo $r?> '>
            <img src='<?php echo $_SESSION['img']  ?>' class='card-img-profile'>
        </a>
        <?php
        if ($_SESSION['username']=='admin')
        {
            echo '<img id="card-admin-badge" src="image/admin-badge.png">';
        }
        ?>
        <h4 class='card-title'>
            <div style='display: flex; align-items: center;'>
                <?php echo ucwords($_SESSION['username']); ?>
                <div style='display: flex; align-items: center; justify-content: center; margin-left: 10px; width: 30px; height: 30px; border-radius: 50%; background-color: #007bff; color:#fff; font-size: 14px; font-weight: bold; cursor:pointer;'>
                    <?php echo $_SESSION["reputation"]?>
                </div>
            </div>
            <small class="text-muted">
                <?php echo ucwords($_SESSION['f_name']." ".$_SESSION['l_name']); ?>
            </small>
            <br>
            <small class="text-muted"><?php echo $_SESSION['bio']; ?></small>
        </h4>
        <a href="edit.php">
            <i class="fa fa-pencil fa-2x edit-profile" aria-hidden="true"></i>
        </a>
    </div>
</div>