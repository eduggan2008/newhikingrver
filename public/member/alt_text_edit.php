<?php
declare(strict_types = 1);                                       
include '../../src/bootstrap.php';                      

is_member($session->session_role);

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT); 

$article = [];                                                     
$errors = [
    'alt' => '',
    'warning' => '',
];                                                        

$success = $_GET['success'] ?? null;
$failure = $_GET['failure'] ?? null;

if (!$id) {                                                
    redirect('articles.php', ['failure' => 'Warning: The article was not found']);            
}

$article = $cms->getArticle()->get($id, false);         
if (!$article['image_file']) {                           
    redirect('article.php', ['id' => $id]);        
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {               
    $article['image_alt'] = $_POST['image_alt'];                  

    $errors['alt'] = (Validate::isText($article['image_alt'], 1, 254))
        ? '' : 'Alt text for image should be 1 - 254 characters.'; 

    if ($errors['alt']) {                                   
        $errors['warning'] = 'Please correct errors below';  
    } else {                                                
        $cms->getArticle()->altUpdate($article['image_id'], $article['image_alt']); 
        redirect('article.php', ['id' => $id]);   
        $success = 'Success: The Alt-Text has been successfully updated!';    
    }
}

$navigation  = $cms->getCategory()->getAll(); 

$section = "";
$title = "Member Article Text Edit";
$description = "Member Article Text Edit";

?>

<?php include APP_ROOT . "/public/includes/member_header.php" ?>

<br>

  <main class="container admin" id="content">
        <form action="alt_text_edit.php?id=<?= $id ?>" method="POST" class="narrow">
            <br><br><br><br>
            
            <div class="category-success-failure-messages col-lg-8">
                <?php if($success) {?> <div class="alert alert-success"><?= $success ?></div> <?php } ?>
                <?php if($failure) {?> <div class="alert alert-danger"><?= $failure ?></div> <?php } ?>
            </div>
            <br>

        <h1>Update Alt Text for this Image</h1>
        <img src="../uploads/<?= $article['image_file'] ?>" width="400px" alt="<?= $article['image_alt'] ?>">

        <br><br>

        <?php if ($errors['warning']) { ?><div class="alert alert-danger"><?= $errors['warning'] ?></div><?php } ?>

        <div class="form-group">
            <label for="image_alt">Alt text: </label>
            <input type="text" name="image_alt" id="image_alt" value="<?= $article['image_alt'] ?>"  class="form-control">
            <span class="errors"><?= $errors['alt'] ?></span>
        </div>

        <div class="form-group">
            <input type="submit" name="delete" value="Confirm" class="btn btn-primary btn-save">
        </div>

        
        </form>
  </main>

  <?php include APP_ROOT . "/public/includes/member_footer.php" ?>


