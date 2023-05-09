<?php
    require 'inc/dbh.inc.php';
    include "languages/lang.php";

define('TITLE',"Find People | Discussio");
    
    if(!isset($_SESSION['id']))
    {
        header("Location: login.php");
        exit();
    }
    
    include 'inc/HTML-head.php';
?>  


	<link rel="stylesheet" type="text/css" href="css/list-page.css">
    </head>
    
    <body style="background: #f1f1f1">

    
        <?php include 'inc/navbar.php'; ?>
        
        <main role="main" class="container">
            <div class="mx-5">
                <div class="d-flex align-items-center p-3 my-3 mx-5 text-white-50 bg-purple rounded shadow-sm">
                    <img class="mr-3" src="image/400.png" alt="" width="48" height="48">
                  <div class="lh-100">
                    <h1 class="mb-0 text-white lh-100"><?= __('Discussio Users')?></h1>
                  </div>
                </div>

                <div class="my-3 mx-5 p-3 bg-white rounded shadow-sm">
                  <h5 class="border-bottom border-gray pb-2 mb-0"><?= __('Find People on Discussio')?></h5>


                  <?php

                      $sql = "select id, username, reputation, f_name, l_name, email, img
                              from users
                              order by reputation desc, id asc";

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
                              echo '<div class="media text-muted pt-3">
          <img src="'.$row['img'].'" alt="" class="mr-2 rounded-circle div-img list-user-img">
          <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
              <strong class="d-block text-gray-dark">'.ucwords($row['username']).'</strong>
              <span class="text-primary">'.ucwords($row['f_name'].' '.$row['l_name']).'</span><br>
              '.$row['email'].'
          </p>
          <div class="align-self-center">
          <a href="#" class="btn btn-link text-danger" data-toggle="modal" data-target="#reportModal" data-id="'.$row['id'].'">
                  <i class="fa fa-flag" aria-hidden="true"></i>
              </a>
          </div>
      </div>';
                          }
                     }
                  ?>

                      <small class="d-block text-right mt-3">
                          <a href="profile.php" class="btn btn-primary"><?= __('Go to Profile')?></a>
                      </small>


                </div>
            </div>
        </main>
        <!-- Add this at the end of the page -->
        <div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="reportModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="reportModalLabel">Report User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <!-- Add the hidden form here -->
                    <div class="modal-body">
                        <form id="reportForm" action="report.php" method="post">
                            <label for="report_type">Report Type:</label>
                            <select id="report_type" name="report_type">
                                <option value="spam">Spam</option>
                                <option value="inappropriate_content">Inappropriate Content</option>
                                <option value="hate_speech">Hate Speech</option>
                                <option value="other">Other</option>
                            </select>
                            <br><br>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="5" cols="40" required></textarea>
                            </div>
                            <input type="hidden" id="reported_user_id" name="id" value="">
                            <button type="submit" class="btn btn-primary">Send</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php include 'inc/footer.php'; ?>
        <script>
            $('#reportModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                var modal = $(this);
                modal.find('#reported_user_id').val(id);
            });
        </script>
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
    </body>
</html>