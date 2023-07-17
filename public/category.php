<?php 
declare(strict_types = 1);
include "../src/bootstrap.php";

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    if (!$id) {
        include APP_ROOT . "/public/page_not_found.php";
    }

$category = $cms->getCategory()->get($id);
    if (!$category) {
        include APP_ROOT . "/public/page_not_found.php";
    }

$articles = $cms->getArticle()->getAll(true, $id);

$navigation = $cms->getCategory()->getAll();

$section = $category['id'];
$title = $category['name'];
$description = $category['description'];

?>

<?php include APP_ROOT . "/public/includes/header.php" ?>


<div class="container">

    <section class="category-section text-center">
        <div class="flag">
            <h1 class="category-title"><?= $category['name'] ?> Category</h1>
            <!-- <h5><?= $category['description'] ?></h5> -->
            <br>
            <hr>
        </div>
    </section>

    <br>

    <section class="card-section">
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php foreach ($articles as $article) { ?>
                <div class="col">
                    <div class="card h-100">
                        <img src="uploads/<?= $article['image_file'] ?? 'hikingrver_default.png' ?>" alt="">
                        <div class="card-body">
                            <h2 class="card-title"><?= $article['title'] ?></h2>
                            <h4 class="card-subtitle"><?= $article['subtitle'] ?></h4>
                            <p class="card-text"><?= substr($article['content'], 0, 75) ?>.....</p>
                            
                            <p class="card-info">
                                Author: <a href="member.php?id=<?= $article['member_id'] ?>">
                                <?= html_escape($article['author']) ?></a>
                                <br>
                                Category: <a href="category.php?id=<?= $article['category_id'] ?>">
                                <?= html_escape($article['category']) ?></a>
                                <br>
                                Posted on: <?= format_date($article['created']) ?>
                            </p>
                            <a href="article.php?id=<?= $article['id'] ?>" class="btn btn-light btn-md" style="background-color: rgb(107, 206, 245);">Read More</a>
                        </div>
                    </div>
                </div>
            <?php } ?> 
        </div>
    </section>

    <br><br>
                
    <!-- add pagination here -->

    <section class="pagination-section">
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <li class="page-item disabled">
                    <a class="page-link">Previous</a>
                </li> 
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">4</a></li>
                <li class="page-item">
                    <a class="page-link" href="#">Next</a>
                </li>
            </ul>
        </nav>
    </section>

    <br>

</div>


<?php include APP_ROOT . "/public/includes/footer.php" ?>





