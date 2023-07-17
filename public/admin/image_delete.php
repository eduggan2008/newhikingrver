<?php
declare(strict_types = 1);                        
include '../../src/bootstrap.php';                     

is_admin($session->session_role);

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT); 
$image = [];                                              

$success = $_GET['success'] ?? null;
$failure = $_GET['failure'] ?? null;

if (!$id) {                                               
    redirect('articles.php', ['failure' => 'Warning: The image was not found!']);            
}

$article = $cms->getArticle()->get($id, false);          
if (!$article['image_file']) {                           
    redirect('article.php', ['id' => $id]);        
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {              
    $path = APP_ROOT . '/public/uploads/' . $article['image_file']; 
    $cms->getArticle()->imageDelete($article['image_id'], $path, $id); 
    redirect('article.php', ['id' => $id]);       
    $success =  'Success: You have been successfully logged into your account!';      
}

$navigation  = $cms->getCategory()->getAll(); 

$section = "";
$title = "Admin Image Delete";
$description = "Admin Image Delete";

?>


<?php include APP_ROOT . "/public/includes/admin_header.php" ?>

<br><br>

<main class="container admin" id="content">
    <form action="image_delete.php?id=<?= $id ?>" method="POST" class="narrow">
        
        <div class="category-success-failure-messages col-lg-8">
            <?php if($success) {?> <div class="alert alert-success"><?= $success ?></div> <?php } ?>
            <?php if($failure) {?> <div class="alert alert-danger"><?= $failure ?></div> <?php } ?>
        </div>
        <br>

        <h1>Delete Image</h1>
        <p><img src="../uploads/<?= $article['image_file'] ?>" width="400px" alt="<?= $article['image_alt'] ?>"></p>
        <p>You must delete the image before you can add a new image!: </p>
        <input type="submit" name="delete" value="Confirm Delete Image" class="btn btn-danger" />
        <a href="article.php?id=<?= $id ?>" class="btn btn-warning">Cancel</a>
    </form>
</main>

  <?php include APP_ROOT . "/public/includes/admin_footer.php" ?>


