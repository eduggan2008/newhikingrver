<?php 
declare(strict_types = 1);
include "../../src/bootstrap.php"; 

is_admin($session->session_role);

$success = $_GET['success'] ?? null;
$failure = $_GET['failure'] ?? null;

$articles = $cms->getArticle()->getAll();

$navigation  = $cms->getCategory()->getAll(); 

$section = "";
$title = "Admin Articles";
$description = "Admin Articles";

?>


<?php include APP_ROOT . "/public/includes/admin_header.php" ?>


<br><br><br><br>

<main class="container text-center" id="content">

    <section class="hero-section text-center">
        <div class="flag">
            <h1>Admin List of Articles</h1>
            <h3>Welcome <?= $session_first_name . ' ' . $session_last_name ?></h3>
            <hr>
        </div>
    </section>

    <br>

    <!-- Start List of Articles -->
    
    <div class="row justify-content-center">
        <div class="category-success-failure-messages col-lg-8">
            <?php if($success) {?> <div class="alert alert-success"><?= $success ?></div> <?php } ?>
            <?php if($failure) {?> <div class="alert alert-danger"><?= $failure ?></div> <?php } ?>
        </div>
        <br>

        <div class="card admin_articles">
            <section>
                <div class="card-header text-bg-info">
                    <h3>Complete List of All Articles</h3>
                </div>
            </section>
            
            <section class="card-body">
                <p><a href="article.php" class="btn btn-success">Add New Article</a></p>

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Image</th>
                            <th scope="col">Title</th>
                            <th scope="col">Category</th>
                            <th scope="col">Author</th>
                            <th scope="col">Date Updated</th>
                            <th scope="col">Published</th>
                            <th scope="col">View</th>
                            <th scope="col">Edit</th>
                            <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($articles as $article) { ?>
                            <tr>
                                <td><img src="../uploads/<?= $article['image_file'] ?? 'hikingrver_default.png' ?>" width="200px"></td>
                                <td><?= $article['title'] ?></td>
                                <td><?= $article['category'] ?></td>
                                <td><?= $article['author'] ?></td>
                                <td><?= format_date($article['created']) ?></td>
                                <td><?= ($article['published']) ? 'Yes' : 'No' ?></td>
                                <td><a href="../article.php?id=<?= $article['id'] ?>" class="btn btn-success">View</a> </td>
                                <td><a href="article.php?id=<?= $article['id'] ?>" class="btn btn-warning">Edit</a> </td>
                                <td><a href="article_delete.php?id=<?= $article['id'] ?>" class="btn btn-danger">Delete</a> </td>
                            </tr>
                            <?php } ?>
                    </tbody>
                </table>
            </section>
        </div>
    </div>
</main>
<br><br>
    <!-- End List of Articles -->


    <?php include APP_ROOT . "/public/includes/admin_footer.php" ?>



