<?php 
declare(strict_types = 1);
include "../src/bootstrap.php";

$navigation  = $cms->getCategory()->getAll(); 

$section = "";
$title = "Error";
$description = $title . " on Hiking RVer";

?>

<?php include APP_ROOT . "/public/includes/header.php" ?>

    <h1 class="logo">Hiking RVer</h1>

    <br>

    <h1>Sorry! An error occurred.</h1>
    <p>The site owners have been notified and will fix the problem as soon as possible.</p>
    <p><a href="index.php">Click here to go back to the home page</a>.</p>
    <p>If the problem persists <a href="mailto:sample@youremail.com">click here to email us</a>.</p>


    <?php include APP_ROOT . "/public/includes/footer.php" ?>
<?php exit ?>



