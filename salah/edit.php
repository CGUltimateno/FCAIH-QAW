<?php

    session_start();
    require 'includes/dbh.inc.php';
    
    define('TITLE',"Edit Profile | KLiK");
    
    if(!isset($_SESSION['id']))
    {
        header("Location: login.php");
        exit();
    }
    
    include 'includes/HTML-head.php';  
?> 

</head>

<body >

    <?php include 'includes/navbar.php'; ?>
      <div class="container">
        <div class="row">
            <div class="col-sm-3">
            
            <?php include 'includes/profile-card.php'; ?> 
                
            </div>
        <div class="col-sm-8 text-center" id="user-section">
              
              <img class="cover-img" id='blah-cover' src="img/user-cover.png">
              
              <form action="includes/Update.php" method='post' enctype="multipart/form-data"
                    style="padding: 0 30px 0 30px;">
                    
              
                    <label class="btn btn-primary">
                        Change Avatar <input type="file" id="imgInp" name='dp' hidden>
                    </label>
                    <img class="profile-img" id="blah"  src="img/<?php echo $_SESSION['img'] ?>" > 
                  

                    <?php  
                          if ($_SESSION['username'] == "admin")
                          {
                              echo '<img id="admin-badge" src="img/admin-badge.png">';
                          }
                    ?>

                    <h2><?php echo strtoupper($_SESSION['username']); ?></h2>
                    <br>
                  
                    <div class="form-row">
                      <div class="col">
                        <input type="text" class="form-control" name="f-name" placeholder="First Name"
                               value="<?php echo $_SESSION['f_name'] ?>" >
                        <small id="emailHelp" class="form-text text-muted">First Name</small>
                      </div>
                      <div class="col">
                        <input type="text" class="form-control" name="l-name" placeholder="Last Name" 
                               value="<?php echo $_SESSION['l_name'] ?>" >
                        <small id="emailHelp" class="form-text text-muted">Last Name</small>
                      </div>
                    </div>
                  
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" class="form-control" name="email" placeholder="email" 
                               value="<?php echo $_SESSION['email'] ?>" >
                        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                    </div>
                  
                    <div class="form-group">
                                <label >Gender</label><br>
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

                        <label for="edit-bio">Profile Bio</label>
                        <textarea class="form-control" id="edit-bio" rows="10" name="bio" maxlength="5000"
                            placeholder="What you want to tell people about yourself" 
                            ><?php echo $_SESSION['bio']; ?></textarea>
                    </div>
                  
                  <hr>
                  
                  <div class="form-group">
                       
                    </div>
                  
                    <div class="form-row">
                    <label for="old-pwd">Change Password</label>
                      <div class="col">
                        <input type="password" class="form-control" id="exampleInputPassword1" name="pwd"
                               placeholder="New Password">
                      </div>
                      
                    </div>
                  
                  <br><input type="submit" class="btn btn-primary" name="update-profile" value="Update Profile">
                  
              </form>
              
              
          </div>
          <div class="col-sm-1">
            
          </div>
        </div>


      </div>