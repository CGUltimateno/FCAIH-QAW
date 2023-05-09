<?php

    include_once 'inc/dbh.inc.php';
    require "languages/lang.php";

define('TITLE',"Ask A Question");
    
    if(!isset($_SESSION['id']))
    {
        header("Location: login.php");
        exit();
    }
    
    include 'inc/HTML-head.php';
?>  

        <link rel="stylesheet" type="text/css" href="css/comp-creation.css">
</head>

<body>

    <?php include 'inc/navbar.php'; ?>
    
    
    <div class="bg-contact2" style="background-image: url('img/banner.png');">
		<div class="container-contact2">
			<div class="wrap-contact2">
                <form class="contact2-form" method="post" action="inc/question.inc.php">
                    <input type="hidden" name="comm_id" value="<?php echo $_GET['comm_id']; ?>">
                    <span class="contact2-form-title">
<?= __('Ask Question')?>					</span>
                                    
                                        <span class="text-center">
                                        <?php
                                            if(isset($_GET['error']))
                                            {
                                                if($_GET['error'] == 'emptyfields')
                                                {
                                                    echo '<h5 class="text-danger">*Fill In All The Fields</h5>';
                                                }
                                                else if ($_GET['error'] == 'sqlerror')
                                                {
                                                    echo '<h5 class="text-danger">*Website Error: Contact admin to have the issue fixed</h5>';
                                                }
                                            }
                                            else if (isset($_GET['operation']) == 'success')
                                            {
                                                echo '<h5 class="text-success">*Question successfully created</h5>';
                                            }
                                        ?>
                                        </span>

					<div class="wrap-input2 validate-input" data-validate="Name is required">
                        <input class="input2" type="text" name="title">
						<span class="focus-input2" data-placeholder="<?= __('Question Title')?>"></span>
                    </div>
					<div class="wrap-input2 validate-input" data-validate = "Description is required">
						<textarea class="input2" name="body"></textarea>
						<span class="focus-input2" data-placeholder="<?= __('Question Body')?>"></span>
					</div>
					<div class="container-contact2-form-btn">
						<div class="wrap-contact2-form-btn">
							<div class="contact2-form-bgbtn"></div>
                            <button class="contact2-form-btn" type="submit" name="question"><?= __('Ask')?></button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
    
    
        
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
        <script src="js/creation-main.js"></script>
    </body>
</html>
