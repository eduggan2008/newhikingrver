<?php 
declare(strict_types = 1);
include "../src/bootstrap.php";

$navigation  = $cms->getCategory()->getAll(); 

$section = "";
$title = "Contact";
$description = $title . " on Hiking RVer";

?>

<?php include APP_ROOT . "/public/includes/header.php" ?>

<div class="container">

    <div class="flag">
        <img src="" alt="">
        <h1>Contact Me Form</h1>
        <h5>Send me an email</h5>
        <hr>
    </div>

    <br>

    <section class="col col-md-6">
        <form action="" method="post">
            <div class="mb-3">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" class="form-control" name="first_name" id="first_name" placeholder="Enter your first name">
            </div>
            <div class="mb-3">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Enter your last name">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control" name="email" id="email" placeholder="Enter your email address">
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Message</label>
                <br>
                <textarea name="message" id="message" placeholder="Type your message here!" cols="30" rows="10"></textarea>
            </div>
            <br>
            <button type="submit" name="contactMeBtn" class="btn btn-primary">Submit Message</button>
            <br><br>
        </form>
    </section>

</div>

<?php include APP_ROOT . "/public/includes/footer.php" ?>



