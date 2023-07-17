<?php 
declare(strict_types = 1);
include "../src/bootstrap.php";

$articles = $cms->getArticle()->getAll();

$navigation  = $cms->getCategory()->getAll(); 

$section = "";
$title = "Hiking RVer";
$description = "Articles and photos of hiking and rving adventures";

?>


<?php include APP_ROOT . "/public/includes/header.php" ?>

<div class="container">

    <section class="hero-section text-center">
        <div class="flag">
            <!-- <div class="hiking-skeleton">
                <img src="images/hiking_skeleton.jpg" alt="Hiking Skeleton" class="hiking-skeleton-image">
            </div> -->
            <div class="photographs-and-memories-title">
                <h1> Photographs and Memories </h1>
                <h5>of a</h5> 
                <h1> Hiking RVer</h1>
            </div>
            <!-- <div class="camper-hanging-off-cliff">
                <img src="images/camper_hanging_off_cliff.jpg" alt="Hiking Skeleton" class="camper-hanging-off-cliff-image">
            </div> -->
            <br>
            <hr>
        </div>
    </section>

    <br>

    <section class="card-section">
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php foreach ($articles as $article) { ?>
                <div class="col">
                    <div class="card h-100 text-left">
                        <img src="uploads/<?= $article['image_file'] ?? 'hikingrver_default.png' ?>" alt="<?= $article['image_alt'] ?>">
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
                                <br>
                            </p>
                            <a href="article.php?id=<?= $article['id'] ?>" class=" card-button btn btn-light btn-md" style="background-color: rgb(107, 206, 245);">Read More</a>
                            
                        </div>
                    </div>
                </div>
            <?php } ?> 
        </div>
    </section>
    
    <br><br>
                

    <!-- Pagination Navigation -->
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

