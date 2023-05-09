<?php
require_once "languages/lang.php";
require 'inc/dbh.inc.php';
    
    define('TITLE',"Edit Profile | Discussio");
    
    if(!isset($_SESSION['id']))
    {
        header("Location: login.php");
        exit();
    }
    
    include 'inc/HTML-head.php';
?> 

</head>

<body >

    <?php include 'inc/navbar.php'; ?>
      <div class="container">
        <div class="row">
            <div class="col-sm-3">
            
            <?php include 'inc/profile-card.php'; ?>
                
            </div>
        <div class="col-sm-8 text-center" id="user-section">
              
              <img class="cover-img" id='blah-cover' src="image/user-cover.png">
              
              <form action="inc/Update.php" method='post' enctype="multipart/form-data"
                    style="padding: 0 30px 0 30px;">
                    
              
                    <label class="btn btn-primary">
                        <?= __('Change Avatar')?> <input type="file" id="imgInp" name='dp' hidden>
                    </label>
                    <img class="profile-img" id="blah"  src="<?php echo $_SESSION['img'] ?>" >
                  

                    <?php  
                          if ($_SESSION['username'] == "admin")
                          {
                              echo '<img id="admin-badge" src="image/admin-badge.png">';
                          }
                    ?>

                    <h2><?php echo strtoupper($_SESSION['username']); ?></h2>
                    <br>
                  
                    <div class="form-row">
                      <div class="col">
                        <input type="text" class="form-control" name="f-name" placeholder="<?= __('First name')?>"
                               value="<?php echo $_SESSION['f_name'] ?>" >
                        <small id="emailHelp" class="form-text text-muted"><?= __('First name')?></small>
                      </div>
                      <div class="col">
                        <input type="text" class="form-control" name="l-name" placeholder="<?= __('Last name')?>"
                               value="<?php echo $_SESSION['l_name'] ?>" >
                        <small id="emailHelp" class="form-text text-muted"><?= __('Last name')?></small>
                      </div>
                    </div>
                  
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?= __('Email Address')?></label>
                        <input type="email" class="form-control" name="email" placeholder="<?= __('Email Address')?>"
                               value="<?php echo $_SESSION['email'] ?>" >
                        <small id="emailHelp" class="form-text text-muted"><?= __('We will never share your email with anyone else.')?></small>
                    </div>
                  
                    <div class="form-group">
                                <label ><?= __('Gender')?></label><br>
                                <input id="toggle-on" class="toggle toggle-left" name="gender" value="m" type="radio" 
                                    <?php 
                                        if ($_SESSION['gender'] == 'm'){ ?> 
                                            checked="checked"
                                    <?php } ?>>
                                <label for="toggle-on" class="btn-r">M</label>
                                <input id="toggle-off" class="toggle toggle-right" name="gender" value="f" type="radio"
                                    <?php if ($_SESSION['gender'] == 'f'){ ?> 
                                            checked="checked"
                                    <?php } ?>>
                                <label for="toggle-off" class="btn-r">F</label>
                    </div>
                  
                  <hr>
                  
                    <div class="form-group">

                        <label for="edit-bio"><?= __('Profile Bio')?></label>
                        <textarea class="form-control" id="edit-bio" rows="10" name="bio" maxlength="5000"
                            placeholder="<?= __('What do you want to tell people about yourself')?>"
                            ><?php echo $_SESSION['bio']; ?></textarea>
                    </div>
                  
                  <hr>
                  
                  <div class="form-group">
                       
                    </div>
                  
                    <div class="form-row">
                    <label for="old-pwd"><?= __('Change Password')?></label>
                      <div class="col">
                        <input type="password" class="form-control" id="exampleInputPassword1" name="pwd"
                               placeholder="<?= __('New Password')?>">
                      </div>
                      
                    </div>
                  
                  <br><input type="submit" class="btn btn-primary" name="update-profile" value="<?= __('Update Profile')?>">
                  
              </form>
              
              
          </div>
          <div class="col-sm-1">
            
          </div>
        </div>

      </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

