<?php 
declare(strict_types = 1);
include "../../src/bootstrap.php"; 

is_member($session->session_role);

/* $uploads = dirname(__DIR__, 1) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR;
$file_types = ['image/jpeg', 'image/png', 'image/gif'];
$file_extensions = ['jpg', 'jpeg', 'png', 'gif'];
$max_size = 5242880; */

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$temp = $_FILES['image']['tmp_name'] ?? '';
$destination = '';
$saved = null;

$article = [
    'id' => $id,
    'title' => '',
    'subtitle' => '',
    'summary' => '',
    'content' => '',
    'image_id' => null,
    'category_id' => 0,
    'member_id' => 0,
    'published' => false,
    'image_file' => '',
    'image_alt' => '',
];

$errors = [
    'warning' => '',
    'title' => '',
    'subtitle' => '',
    'summary' => '',
    'content' => '',
    'category' => '',
    'author' => '',
    'image_file' => '',
    'image_alt' => '',
];

$success = $_GET['success'] ?? null;
$failure = $_GET['failure'] ?? null;

if($id) {
    $article = $cms->getArticle()->get($id, false);
    if(!$article) {
        redirect('article.php', ['failure' => 'Warning:  The article was not found!']);
    }
}

$saved_image = $article['image_file'] ? true : false;   
$authors    = $cms->getMember()->getAll();               
$categories = $cms->getCategory()->getAll();  


if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors['image_file'] = ($temp and $_FILES['image']['error'] === 1) ? 'Warning, the image file size is too large' : '';

    if($temp and $_FILES['image']['error'] == 0) {
        $article['image_alt'] = $_POST['image_alt'];
        $errors['image_file'] .= in_array(mime_content_type($temp), MEDIA_TYPES) ? '' : 'Warning: The image file type is wrong.';
        $extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $errors['image_file'] .= in_array($extension, FILE_EXTENSIONS) ? '' : 'Warning, the image file extension is wrong';
        $errors['image_file'] .= ($_FILES['image']['size'] <= MAX_SIZE) ? '' : 'Warning, the image file size is too large';
        $errors['image_alt'] = (Validate::isText($article['image_alt'], 1, 254)) ? '' : 'Warning: The image alt must be between 1 and 254 characters long';

        if($errors['image_file'] === '' and $errors['image_alt'] === '') {
            $article['image_file'] = create_filename($_FILES['image']['name'], UPLOADS);
            $destination = UPLOADS . $article['image_file'];
        }
    }

    $article['title'] = $_POST['title'];
    $article['subtitle'] = $_POST['subtitle'];
    $article['summary'] = $_POST['summary'];
    $article['content'] = $_POST['content'];
    $article['category_id'] = $_POST['category_id'];
    $article['member_id'] = $_POST['member_id'];
    $article['published'] = (isset($_POST['published']) and ($_POST['published'] == 1)) ? 1 : 0;

    $errors['title'] = Validate::isText($article['title'], 1, 254) ? '' : 'Warning: The title must be between 1 and 254 characters long';
    $errors['subtitle'] = Validate::isText($article['subtitle'], 1, 254) ? '' : 'Warning: The subtitle must be between 1 and 254 characters long';
    $errors['summary'] = Validate::isText($article['summary'], 1, 254) ? '' : 'Warning: The summary must be between 1 and 254 characters long';
    $errors['content'] = Validate::isText($article['content'], 1, 100000) ? '' : 'Warning: The title must be between 1 and 100,000 characters long';
    $errors['category'] = Validate::isCategoryId($article['category_id'], $categories) ? '' : 'Warning: You must select a category';
    $errors['member'] = Validate::isMemberId($article['member_id'], $authors) ? '' : 'Warning: You must select an author';
    $invalid = implode($errors);

    if($invalid) {
        $errors['warning'] = 'Warning:  Please correct any errors!';
    } else {                                                            
        $arguments = $article;                                          
        if ($id) {                                                     
            $saved = $cms->getArticle()->update($arguments, $temp, $destination); 
        } else {                                                        
            unset($arguments['id']);                                    
            $saved = $cms->getArticle()->create($arguments, $temp, $destination); 
        }

        if ($saved == true) {                                          
            redirect('article.php', ['success' => 'Success: The article was saved successfully!']); 
        } else {                                                       
            $errors['warning'] = 'Warning: The article title already in use';       
        }
    }

    $article['image_file'] = $saved_image ? $article['image_file'] : '';

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
            <?php if($success) {?> <div class="alert alert-success"><?= $success ?></div> <?php } ?>
            <?php if($failure) {?> <div class="alert alert-danger"><?= $failure ?></div> <?php } ?>
        </div>
        <br>

        <h1>Add/Edit Article</h1>
        <?php if ($errors['warning']) { ?>
            <div class="alert alert-danger"><?= $errors['warning'] ?></div>
        <?php } ?>

        <div class="member_article">
            <section class="image">
                <?php if (!$article['image_file']) { ?>
                    <label for="image">Upload image:</label>
                    <div class="form-group image-placeholder">
                    <input type="file" name="image" class="form-control-file" id="image" multiple><br>
                    <span class="errors"><?= $errors['image_file'] ?></span>
                    </div>
                    <div class="form-group">
                    <label for="image_alt">Alt text: </label>
                    <input type="text" name="image_alt" id="image_alt" value="" class="form-control">
                    <span class="errors"><?= $errors['image_alt'] ?></span>
                    </div>
                    <br><br><br>
                <?php } else { ?>
                    <label>Image:</label>
                    <img src="../uploads/<?= $article['image_file'] ?>" width="400px"
                        alt="<?= $article['image_alt'] ?>">
                    <p class="alt"><strong>Alt text:</strong> <?= $article['image_alt'] ?></p>
                    <a href="alt_text_edit.php?id=<?= $article['id'] ?>" class="btn btn-secondary">Edit alt text</a>
                    <a href="image_delete.php?id=<?= $id ?>" class="btn btn-secondary">Delete image</a><br><br>
                <?php } ?>
            </section>

            <section class="text">
                <div class="form-group">
                    <label for="title">Title: </label>
                    <input type="text" name="title" id="title" value="<?= $article['title'] ?>"
                        class="form-control">
                    <span class="errors"><?= $errors['title'] ?></span>
                </div>
                <div class="form-group">
                    <label for="subtitle">Subtitle: </label>
                    <input type="text" name="subtitle" id="subtitle" value="<?= $article['subtitle'] ?>"
                        class="form-control">
                    <span class="errors"><?= $errors['title'] ?></span>
                </div>
                <div class="form-group">
                    <label for="summary">Summary: </label>
                    <textarea name="summary" id="summary"
                            class="form-control"><?= $article['summary'] ?></textarea>
                    <span class="errors"><?= $errors['summary'] ?></span>
                </div>
                <div class="form-group">
                    <label for="content">Content: </label>
                    <textarea name="content" id="content"
                            class="form-control"><?= $article['content'] ?></textarea>
                    <span class="errors"><?= $errors['content'] ?></span>
                </div>
                <div class="form-group">
                    <label for="member_id">Author: </label>
                    <select name="member_id" id="member_id">
                    <?php foreach ($authors as $author) { ?>
                        <option value="<?= $author['id'] ?>"
                            <?= ($article['member_id'] == $author['id']) ? 'selected' : ''; ?>>
                            <?= $author['first_name'] . ' ' . $author['last_name'] ?></option>
                    <?php } ?>
                    </select>
                    <span class="errors"><?= $errors['author'] ?></span>
                </div>
                <div class="form-group">
                    <label for="category_id">Category: </label>
                    <select name="category_id" id="category_id">
                    <?php foreach ($categories as $category) { ?>
                        <option value="<?= $category['id'] ?>"
                            <?= ($article['category_id'] == $category['id']) ? 'selected' : ''; ?>>
                            <?= $category['name'] ?></option>
                    <?php } ?>
                    </select>
                    <span class="errors"><?= $errors['category'] ?></span>
                </div>
                <div class="form-check">
                    <input type="checkbox" name="published" id="published" value="1" class="form-check-input" 
                        <?= ($article['published'] == 1) ? 'checked' : ''; ?>>
                    <label for="published" class="form-check-label">Published</label>
                </div>
                <input type="submit" name="update" value="Save" class="btn btn-primary">
            </section><!-- /.text -->
        </div><!-- /.admin-article -->
        </main>
    </form>
    
</div>


<?php include APP_ROOT . "/public/includes/member_footer.php" ?>








