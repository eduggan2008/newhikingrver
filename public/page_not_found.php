<?php 
declare(strict_types = 1);                               
http_response_code(404);                              
include '../src/bootstrap.php';                     

$navigation  = $cms->getCategory()->getAll();            
$section     = '';                                       
$title       = 'Page not found';                         
$description = $title . " on Hiking RVer";                        
?>


<?php include APP_ROOT . '/public/includes/header.php'; ?>

  <main class="container" id="content">

    <br>

    <h1>Sorry! We cannot find that page.</h1>
    <p>Try the <a href="index.php">home page</a> or email us
      <a href="mailto:sample@youremail.com">sample@youremail.com</a></p>
  </main>

<?php include APP_ROOT . '/public/includes/footer.php'; ?>

<?php exit ?>