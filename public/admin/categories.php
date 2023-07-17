<?php 
declare(strict_types = 1);
include "../../src/bootstrap.php"; 

is_admin($session->session_role);

$success = $_GET['success'] ?? null;
$failure = $_GET['failure'] ?? null;

$categories = $cms->getCategory()->getAll();

$navigation  = $cms->getCategory()->getAll(); 

$section = "";
$title = "Admin Categories";
$description = "Admin Categories";

?>


<?php include APP_ROOT . "/public/includes/admin_header.php" ?>


<br><br><br><br>
<main class="container text-center" id="content">

    <section class="hero-section text-center">
        <div class="flag">
            <h1>Admin List of Categories</h1>
            <h3>Welcome <?= $session_first_name . ' ' . $session_last_name ?></h3>
            <hr>
        </div>
    </section>

    <br>

    <!-- Start List of Categories -->

    <div class="row justify-content-center">
        <div class="category-success-failure-messages col-lg-10">
            <?php if($success) {?> <div class="alert alert-success"><?= $success ?></div> <?php } ?>
            <?php if($failure) {?> <div class="alert alert-danger"><?= $failure ?></div> <?php } ?>
        </div>
        <br>

        <div class="card admin_categories col-lg-8">
            <section>
                <div class="card-header text-bg-info">
                    <h2>List of Categories</h2>
                </div>
            </section>

            <section class="card-body">
                <p><a href="category.php" class="btn btn-success">Add New Category</a></p>

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Description</th>
                            <th scope="col">Edit</th>
                            <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $category) { ?>
                            <tr>
                                <td scope="row"><?= $category['id'] ?></td>
                                <td><?= $category['name'] ?></td>
                                <td><?= $category['description'] ?></td>
                                <td><a href="category.php?id=<?= $category['id'] ?>" class="btn btn-warning">Edit</a> </td>
                                <td><a href="category_delete.php?id=<?= $category['id'] ?>" class="btn btn-danger">Delete</a> </td>
                            </tr>                            
                        <?php } ?>
                    </tbody>
                </table>
            </section>
        </div>
    </div>
</main>
<br><br>
    <!-- End List of Categories -->


<?php include APP_ROOT . "/public/includes/admin_footer.php" ?>




