<?php 
declare(strict_types = 1);
include "../../src/bootstrap.php"; 

is_admin($session->session_role);

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$category = [];
$deleted = null;

$success = $_GET['success'] ?? null;
$failure = $_GET['failure'] ?? null;

if(!$id) {
    redirect('categories.php', ['failure' => 'Warning: The category was not found!']);
}

$category = $cms->getCategory()->get($id);

if(!$category) {
    redirect('categories.php', ['failure' => 'Warning: The category was not found!']);
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if($id) {
        $deleted = $cms->getCategory()->delete($id);
        if($deleted === true) {
            redirect('categories.php', ['success' => 'Success: The category was successfully deleted!']);
        }
        if($deleted === false) {
            redirect('categories.php', ['failure' => 'Warning: The category contains an articles that must be deleted or moved before the category can be deleted!']);
        }
    }

}

$navigation  = $cms->getCategory()->getAll(); 

$section = "";
$title = "Admin Category Delete";
$description = "Admin Category Delete";

?>


<?php include APP_ROOT . "/public/includes/admin_header.php" ?>

<br><br><br><br>

<main class="container admin" id="content">
    <h2>Delete Category "<?= $category['name'] ?>"</h2>
    <form class="form form-horizontal" action="category_delete.php?id=<?= $id ?>" method="post">
        
        <div class="category-success-failure-messages col-lg-8">
            <?php if($success) {?> <div class="alert alert-success"><?= $success ?></div> <?php } ?>
            <?php if($failure) {?> <div class="alert alert-danger"><?= $failure ?></div> <?php } ?>
        </div>
        <br>

        <br>
        <h5>NOTE: Confirming to delete a category cannot be undone!</h5>
        <br>
        <a href="categories.php" class="btn btn-warning">Cancel</a>
        <br><br>
        <input type="submit" name="delete-category" id="delete-category" class="btn btn-danger" value="Delete '<?= $category['name'] ?>' Category">
        <br><br>
    </form>
</main>



<?php include APP_ROOT . "/public/includes/admin_footer.php" ?>


