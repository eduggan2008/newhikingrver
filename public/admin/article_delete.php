<?php 
declare(strict_types = 1);
include "../../src/bootstrap.php"; 

is_admin($session->session_role);

$deleted = null;

$success = $_GET['success'] ?? null;
$failure = $_GET['failure'] ?? null;

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    if (!$id) {
        redirect('articles.php', ['failure' => 'Warning: The article was not found']);
    }

$article = $cms->getArticle()->get($id, false);
    if (!$article) {
        redirect('articles.php', ['failure' => 'Warning: The article was not found']);
    }

if ($_SERVER['REQUEST_METHOD'] == 'POST') {              
    if (isset($article['image_id'])) {                   
        $path = APP_ROOT . '/public/uploads/' . $article['image_file']; 
        $cms->getArticle()->imageDelete($article['image_id'], $path, $id); 
    }
    $deleted = $cms->getArticle()->delete($id);          
    if ($deleted === true) {                             
        redirect('articles.php', ['success' => 'Success: The article was deleted successfully']); 
    } else {                                            
        throw new Exception('Warning: Unable to delete article'); 
    }
}

$navigation  = $cms->getCategory()->getAll(); 

$section = "";
$title = "Admin Article Delete";
$description = "Admin Article Delete";

?>


<?php include APP_ROOT . "/public/includes/admin_header.php" ?>

<br><br><br><br>

<div class="container">
    <h1>Delete Article "<?= $article['title'] ?>"</h1>

    <form action="article_delete.php?id=<?= $id ?>" method="post" class="narrow">
        
        <div class="category-success-failure-messages col-lg-8">
            <?php if($success) {?> <div class="alert alert-success"><?= $success ?></div> <?php } ?>
            <?php if($failure) {?> <div class="alert alert-danger"><?= $failure ?></div> <?php } ?>
        </div>
        <br>

        <p>Click below confirm to delete: <i><?= $article['title'] ?></i></p>
        <input type="submit" name="delete" id="delete" class="btn btn-danger" value="Delete Article '<?= $article['title'] ?>'">
        &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
        <a href="articles.php" class="btn btn-warning">Cancel</a>
    </form>
</div>



<?php include APP_ROOT . "/public/includes/admin_footer.php" ?>





