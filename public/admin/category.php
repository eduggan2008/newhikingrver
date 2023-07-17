<?php
declare(strict_types = 1);
include "../../src/bootstrap.php"; 

is_admin($session->session_role);

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$saved = null;

$category = [
    'id' => $id,
    'name' => '',
    'description' => '',
    'navigation' => false,
];
$errors = [
    'warning' => '',
    'name' => '',
    'description' => '',
];

$success = $_GET['success'] ?? null;
$failure = $_GET['failure'] ?? null;

if($id) {
    $category = $cms->getCategory()->get($id);
    if(!$category) {
        redirect('categories.php', ['failure' => 'Warning: The category was not found!']);
    }
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category['name'] = $_POST['name'];
    $category['description'] = $_POST['description'];
    $category['navigation'] = (isset($_POST['navigation']) and ($_POST['navigation'] == 1)) ? 1 : 0;

    $errors['name'] = (Validate::isText($category['name'], 1, 50)) ? '' : 'Warning: The category name should be 50 characters or less!';
    $errors['description'] = (Validate::isText($category['description'], 1, 254)) ? '' : 'Warning: The category name should be 254 characters or less!';

    $invalid = implode($errors);

    if ($invalid) {
        $errors['warning'] = 'Warning: Please correct the errors';
    } else {
        $arguments = $category;
        if($id) {
            $saved = $cms->getCategory()->update($arguments);
        } else {
            unset($arguments['id']);
            $saved = $cms->getCategory()->create($arguments);
        }
        if($saved === true) {
            redirect('categories.php', ['success' => 'Success: The category was saved successfully!']);
        }
        if($saved === false) {
            $errors ['warning'] = 'Warning: The category name you chose is already in use. Try again.';
        }

    }
}

$navigation  = $cms->getCategory()->getAll(); 

$section = "";
$title = "Admin Category";
$description = "Admin Category";

?>


<?php include APP_ROOT . "/public/includes/admin_header.php" ?>

<br><br><br><br>

<main class="container admin" id="content">
    <form class="form form-horizontal" action="category.php?id=<?= $id ?>" method="post">
        
        <div class="category-success-failure-messages col-lg-8">
            <?php if($success) {?> <div class="alert alert-success"><?= $success ?></div> <?php } ?>
            <?php if($failure) {?> <div class="alert alert-danger"><?= $failure ?></div> <?php } ?>
        </div>
        <br>

        <h2 class="page-header">Add/Edit Category</h2>

        <?php if($errors['warning']) { ?>
            <div class="alert alert-danger"><?= $errors['warning'] ?></div>
        <?php } ?>
        
        <br>
        <div class="form-group">
            <label for="name">Category Name:  </label>
            <input type="text" class="form-control" id="name" name="name" value="<?= $category['name'] ?>">
            <span class="errors"><?= $errors['name'] ?></span>
        </div>
        <br>
        <div class="form-group">
            <label for="description">Category Description:  </label>
            <textarea class="form-control" name="description" id="description" cols="30" rows="10"><?= $category['description'] ?></textarea>
            <span class="errors"><?= $errors['description'] ?></span>
        </div>
        <br>
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="navigation" name="navigation" value="1" <?= ($category['navigation'] === 1) ? 'checked' : '' ?>>
            <label class="form-check-label" for="navigation" >Check the box to add category to the Navigation Bar</label>
        </div>
        <br>
        <input type="submit" value="Save Category" class="btn btn-primary btn-save btn-lg mb-4">

    </form>
    
</main>

<?php include APP_ROOT . "/public/includes/admin_footer.php" ?>
