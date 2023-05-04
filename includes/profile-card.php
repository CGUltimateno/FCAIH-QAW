

      
         <div class='card card-profile text-center'>
                <img alt='' class='card-img-top card-user-cover' src='img/user-cover.png'>
                <div class='card-block'>
               <?php if($_SESSION['username']=='admin'){
                        $r="Admin.php?login=success";
                    }
                    else{
                    $r="profile.php?login=success";
                    
                    }?>
                    
                    
                    <a href='<?php echo $r?> '>
                    <img src='img/<?php echo $_SESSION['img']  ?>' class='card-img-profile'>
                    </a>
                    <?php  
                        if ($_SESSION['username']=='admin')
                        {
                            echo '<img id="card-admin-badge" src="img/admin-badge.png">';
                        }
                    
                    
                    ?>
                    
                    <a href="edit.php">
                        <i class="fa fa-pencil fa-2x edit-profile" aria-hidden="true"></i>
                    </a>
                   
                    <h4 class='card-title'>
                    <?php echo ucwords($_SESSION['username']); ?>
                        <small class="text-muted">
                            <?php echo ucwords($_SESSION['f_name']." ".$_SESSION['l_name']); ?>
                        </small>
                        <br>
                        <small class="text-muted"><?php echo $_SESSION['bio']; ?></small>
                        
                        <div style='display: flex;
      align-items: center;
      justify-content: center;
      width: 50px;
      height: 50px;
      border-radius: 50%;
      background-color: #007bff;
      color:#fff;
      font-size: 24px;
       font-weight: bold;
        cursor:pointer;'>
        <?php echo $_SESSION["reputation"]?> </div>
                    </h4>
                </div>
            </div>