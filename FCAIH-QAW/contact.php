<?php
    define('TITLE',"Contact Us | Discussio");
    require "languages/lang.php";
    include 'inc/HTML-head.php';
require 'inc/email-server.php';
?>  

	<link rel="stylesheet" type="text/css" href="css/contact-util.css">
	<link rel="stylesheet" type="text/css" href="css/contact-main.css">
</head>
    
<body>

    
    <?php
    
        if(isset($_SESSION['id']))
        {
            include 'inc/navbar.php';
        }
        
        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\Exception; 
        
        require 'PHPMailer/src/Exception.php';
        require 'PHPMailer/src/PHPMailer.php';  
        require 'PHPMailer/src/SMTP.php';
        
        
        // check for header injection
        function has_header_injection($str){
            return preg_match('/[\r\n]/',$str);
        }
    
        if (isset($_POST['contact_submit'])){
            
            
            
            if(!isset($_SESSION['id']))
            {
                $email = trim($_POST['email']);
                $name = trim($_POST['first-name']).' '.trim($_POST['last-name']);
            }
            else
            {
                $email = trim($_SESSION['email']);
                $name = 'User: '.$_SESSION['username'];
            }
            
            $msg = $_POST['message'];
            
            
            if (has_header_injection($name) || has_header_injection($email)){
                die(); 
            }
            
            if (! $name || ! $email || ! $msg){
                echo '<h4 class="error">All Fields Required.</h4>'
                . '<a href="contact.php" class="button block">go back and try again</a>';
                exit;
            }
            
            
            $to = $email;
            
            $subject = "$name sent you a message via your contact form";
            
            $message = "<strong>Name:</strong> $name<br>" 
                    . "<strong>Email:</strong> <i>$email</i><br><br>"
                    . "<strong>Message:</strong><br><br>$msg";
            
            if (isset($_POST['subscribe']))
            {
                $message .= "<br><br><br>"
                            . "<strong>IMPORTANT:</strong> Please add <i>$email</i> "
                            . "to your mailing list.<br>";
            }
            
            
            $mail = new PHPMailer(true);            
            
            try {
                $mail->isSMTP();                                      
                $mail->Host = 'smtp.gmail.com';                      
                $mail->SMTPAuth = true;                              
                $mail->Username = $SMTPuser;                              
                $mail->Password = $SMTPpwd;             
                $mail->SMTPSecure = 'tls';                           
                $mail->Port = 587;                                    
                
                //Recipients
                $mail->setFrom($to, $SMTPtitle);
                $mail->addAddress($SMTPuser, $SMTPtitle);     

                //Content
                $mail->isHTML(true);                                  
                $mail->Subject = $subject;
                $mail->Body    = $message;
 
                $mail->send();
            } 
            catch (Exception $e) {
                echo '<h4 class="error">Message could not be sent. Mailer Error: '. $mail->ErrorInfo
                        .'</h4>';
            }
        }
    ?>

	<div class="container-contact100">
		<div class="wrap-contact100">
			<form class="contact100-form validate-form" method="post" action="">
				<span class="contact100-form-title">
					<?= __('Send us a Message')?>
				</span>

                                <?php 
                                    if(!isset($_SESSION['id']))
                                    {
                                ?>
                            
                                <label class="label-input100" for="first-name"><?= __('Tell us your name')?></label>
				<div class="wrap-input100 rs1-wrap-input100 validate-input" data-validate="Type first name">
					<input id="first-name" class="input100" type="text" name="first-name" placeholder="<?= __('First name')?>">
					<span class="focus-input100"></span>
				</div>
				<div class="wrap-input100 rs2-wrap-input100 validate-input" data-validate="Type last name">
					<input class="input100" type="text" name="last-name" placeholder="<?= __('Last name')?>">
					<span class="focus-input100"></span>
				</div>
                                
                                <label class="label-input100" for="email"><?= __('Enter your email')?></label>
				<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
					<input id="email" class="input100" type="text" name="email" placeholder="Eg. example@email.com">
					<span class="focus-input100"></span>
				</div>
                                
                                <?php
                                    }
                                ?>
				
                                
                                <div class="checkbox-animated my-4">
                                    <input id="checkbox_animated_1" type="checkbox" name="subscribe" value="subscribe">
                                    <label for="checkbox_animated_1">
                                        <span class="check"></span>
                                        <span class="box"></span>
                                        <?= __('Subscribe for Updates')?>
                                    </label>
                                </div>

				<label class="label-input100" for="message"><?= __('Message')?></label>
				<div class="wrap-input100 validate-input" data-validate = "Message is required">
                                    <textarea id="message" class="input100" name="message" rows="8"
                                                  placeholder="<?= __('Write us a message')?>"></textarea>
					<span class="focus-input100"></span>
				</div>
                                
				<div class="container-contact100-form-btn">
                                    
                                    <input type="submit" class="contact100-form-btn" 
                                           name="contact_submit" value="<?= __('Send Message')?>">
                                    
				</div>
			</form>

			<div class="contact100-more flex-col-c-m" style="background-image: url('img/contact.jpg');">
				<div class="flex-w size1 p-b-47">
					<div class="txt1 p-r-25">
						<span class="lnr lnr-map-marker"></span>
					</div>

					<div class="flex-col size2">
						<span class="txt1 p-b-20">
							<?= __('About us')?>
						</span>

						<span class="txt2">
                                                    <?= __('University Students stumbling onto new ambitions')?><br>
                                                    <?= __('Helwan University, Cairo')?>
						</span>
					</div>
				</div>

				<div class="dis-flex size1 p-b-47">
					<div class="txt1 p-r-25">
						<span class="lnr lnr-phone-handset"></span>
					</div>

					<div class="flex-col size2">
						<span class="txt1 p-b-20">
							<?= __('Star our Work')?>
						</span>
                        <a href="https://github.com/CGUltimateno/FCAIH-QAW"><span class="txt3">Discussio Github Page</span></a>
                    </div>
				</div>

				<div class="dis-flex size1 p-b-47">
					<div class="txt1 p-r-25">
						<span class="lnr lnr-envelope"></span>
					</div>

					<div class="flex-col size2">
						<span class="txt1 p-b-20">
							<?= __('General Support')?>
						</span>
                        <a href="mailto:discussio.website@gmail.com"><span class="txt3">discussio.website@gmail.com</span></a>
					</div>
				</div>
			</div>
		</div>
	</div>

        
        <?php include 'inc/footer.php'; ?>
        <script src="js/contact-main.js"></script>
	
<?php include 'inc/HTML-footer.php' ?>