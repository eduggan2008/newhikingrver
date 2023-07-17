<?php
declare(strict_types = 1);                                     
include "../src/classes/Validate.php";                                  
include '../src/bootstrap.php';  
include "../src/classes/Member.php";                               

$error = false;                                                 // Error message
$sent  = false;       
$message = "";                                          // Has email been sent
$token = "";
$link = "";

//////////// NOTE: I need to work on the email part of this code ///////////

if ($_SERVER['REQUEST_METHOD'] == 'POST') {                     // If form submitted
    $email = $_POST['email'];                                            // Get email
    $error = Validate::isEmail($email) ? '' : 'Warning: There was a problem. Please enter a valid email!'; // Validate
    if ($error === '') {                                                 // If valid
        $id = $cms->getMember()->getIdByEmail($email);                   // Get member id  
        if ($id) {                                                       // If id found
            $token = $cms->getToken()->create($id, 'password_reset');    // Token

            $link  = DOMAIN . DOC_ROOT . 'password_reset.php?token=' . $token; // Link

            /* $subject = 'Reset Password Link';                            // Subject + body
            $body  = 'To reset password click: <a href="' . $link . '">' . $link . '</a>';
            $mail  = new \PhpBook\Email\Email($email_config);            // Email object 
            $sent  = $mail->sendEmail($email_config['admin_email'], $email, 
               $subject, $body); */                                         // Send mail
        }
    }
}

$navigation  = $cms->getCategory()->getAll(); 

$section = "";
$title = "Password Lost";
$description = "Password Lost";

?>


<?php include APP_ROOT . "/public/includes/header.php" ?>

<main class="container" id="content">

    <section class="header"><h1>Forgot Password?</h1></section>
    
    <br><hr>

    <?php if($error) { ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php } ?>

    <!-- <?php if ($sent == false) { ?>
        <form method="post" action="password_lost.php" class="form-membership">
            <label for="email">Enter your email address: </label>
            <input type="text" name="email" id="email" class="form-control"><br>
            <input type="submit" name="submit" value="Submit to reset password" class="btn btn-primary">
        </form>
    <?php } else { ?>    
        <div class="alert">
            <h3>Click on the link shown below to be able to reset your password!</h3>
            <br>
            <a href="password_reset.php?token=<?= $token ?>">Reset Password</a> 
        </div>
        <p class="form-membership">If your address is registered, we will email instructions to reset your password.</p>
    <?php } ?> -->


    <?php if ($token == false) { ?>
        <form method="post" action="password_lost.php" class="form-membership">
            <label for="email">Enter your email address: </label>
            <input type="text" name="email" id="email" class="form-control"><br>
            <input type="submit" name="submit" value="Submit to reset password" class="btn btn-primary">
        </form>
    <?php } else { ?>    
        <div class="alert">
            <h3>Click on the link shown below to be able to reset your password!</h3>
            <br>
            <a href="password_reset.php?token=<?= $token ?>">Reset Password</a> 
        </div>
        <p class="form-membership">If your address is registered, we will email instructions to reset your password.</p>
    <?php } ?>

</main> 


<?php include APP_ROOT . "/public/includes/footer.php" ?>




