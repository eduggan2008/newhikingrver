<?php 
declare(strict_types = 1);
include "../../src/bootstrap.php"; 

is_member($session->session_role);

/* $uploads = dirname(__DIR__, 1) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR;
$file_types = ['image/jpeg', 'image/png', 'image/gif'];
$file_extensions = ['jpg', 'jpeg', 'png', 'gif'];
$max_size = 5242880; */

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$temporary = $_FILES['image']['tmp_name'] ?? '';
$destination = '';
$saved = null;
/* $image_filenames = ''; */

$article = [
    'id' => $id,
    'title' => '',
    'filenames' => '',
    'published' => false,
];

$errors = [
    'warning' => '',
    'title' => '',
    'filenames' => '',
];

$success = $_GET['success'] ?? null;
$failure = $_GET['failure'] ?? null;

if($id) {
    $article = $cms->getArticle()->get($id, false);
    if(!$article) {
        redirect('article.php', ['failure' => 'Warning:  The article was not found!']);
    }
}

$saved_image = $article['filenames'] ? true : false;   
$authors    = $cms->getMember()->getAll();               
$categories = $cms->getCategory()->getAll();  


if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors['filenames'] = ($temporary and $_FILES['image']['error'] === 1) ? 'Warning, the image file size is too large' : '';

    if($temporary and $_FILES['image']['error'] == 0) {
        $errors['filenames'] .= in_array(mime_content_type($temporary), MEDIA_TYPES) ? '' : 'Warning: The image file type is wrong.';
        $extension = strtolower(pathinfo($_FILES['filenames'], PATHINFO_EXTENSION));
        $errors['filenames'] .= in_array($extension, FILE_EXTENSIONS) ? '' : 'Warning, the image file extension is wrong';
        $errors['filenames'] .= ($_FILES['image']['size'] <= MAX_SIZE) ? '' : 'Warning, the image file size is too large';
       

        if($errors['filenames'] === '') {
            $article['filenames'] = create_filename($_FILES['filenames']['name'], UPLOADS);
            $destination = UPLOADS . $article['filenames'];
        }
    }

    
    $article['title'] = $_POST['title'];
    $article['filenames'] = $_POST['filenames'];
    $article['published'] = (isset($_POST['published']) and ($_POST['published'] == 1)) ? 1 : 0;

    $errors['title'] = Validate::isText($article['title'], 1, 254) ? '' : 'Warning: The title must be between 1 and 254 characters long';
    /* $errors['filenames'] = Validate::isText($article['filenames'], 1, 10000) ? '' : 'Warning: The filenames must be between 1 and 10,000 characters long'; */
    $invalid = implode($errors);

    if($invalid) {
        $errors['warning'] = 'Warning:  Please correct any errors!';
    } else {                                                            
        $arguments = $article;                                          
        if ($id) {                                                     
            $saved = $cms->getArticle()->update($arguments, $temporary, $destination); 
        } else {                                                        
            unset($arguments['id']);                                    
            $saved = $cms->getArticle()->create($arguments, $temporary, $destination); 
        }

        if ($saved == true) {                             
            /* redirect('article.php', ['success' => 'Success: The article was saved successfully!']); */  
        
        } else {                                                       
            $errors['warning'] = 'Warning: The article title already in use';       
        }
    }

    $article['filenames'] = $saved_image ? $article['filenames'] : '';

}

$navigation  = $cms->getCategory()->getAll(); 

$section = "";
$title = "Member Article";
$description = "Member Article";

?>


<?php include APP_ROOT . "/public/includes/member_header.php" ?>

<br><br>

    <!-- Start New Article Page -->

    <form action="article.php?id=<?= $id ?>" method="POST" enctype="multipart/form-data">
        <main class="container admin" id="content">

        <div class="category-success-failure-messages col-lg-8">
            <?php if($success) {?> 
                <div class="alert alert-success"><?= $success ?></div>
            <?php } ?>
            <?php if($failure) { ?> 
                <div class="alert alert-danger"><?= $failure ?></div> 
            <?php } ?>
        </div>
        <br>

        <h1>Add/Edit Article</h1>
        <?php if ($errors['warning']) { ?>
            <div class="alert alert-danger"><?= $errors['warning'] ?></div>
        <?php } ?>

        <div class="member_article">

        <section class="image">
                <?php if (!$article['filenames']) { ?>
                    <div class="form-group image-placeholder">
                        <label for="filenames">Upload image: </label>
                        <input type="file" name="filenames[]" class="form-control-file" id="filenames" multiple>
                        <br>
                        <span class="errors"><?= $errors['filenames'] ?></span>
                    </div>
                    <br><br><br>
                <?php } else { ?>
                    <label>Image: </label>
                    <img src="../uploads/<?= $article['filenames'] ?>" width="400px">
                    <a href="alt_text_edit.php?id=<?= $article['id'] ?>" class="btn btn-secondary">Edit alt text</a>
                    <a href="image_delete.php?id=<?= $id ?>" class="btn btn-secondary">Delete image</a>
                    <br><br>
                <?php } ?>
            </section>

            <section class="text">

                <!-- <div class="form-group image-placeholder">
                    <label for="filenames">Upload image: </label>
                    <input type="file" name="filenames[]" class="form-control-file" id="filenames" multiple>
                    <br>
                    <span class="errors"><?= $errors['filenames'] ?></span>
                </div>
                <br><br><br> -->
                
                <div class="form-group">
                    <label for="title">Title: </label>
                    <input type="text" name="title" id="title" value="<?= $article['title'] ?>"
                        class="form-control">
                    <span class="errors"><?= $errors['title'] ?></span>
                </div>

                <div class="form-check">
                    <input type="checkbox" name="published" id="published" value="1" class="form-check-input" 
                        <?= ($article['published'] == 1) ? 'checked' : ''; ?>>
                    <label for="published" class="form-check-label">Published</label>
                </div>
                <input type="submit" name="update" value="Save" class="btn btn-primary">
            </section>  
        </div>   
        </main>
    </form>
    
</div>


<?php include APP_ROOT . "/public/includes/member_footer.php" ?>








