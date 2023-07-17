<?php 
declare(strict_types = 1);
include "../src/bootstrap.php";
include "../src/classes/Article.php";

$term  = filter_input(INPUT_GET, 'term');                 
$show  = filter_input(INPUT_GET, 'show', FILTER_VALIDATE_INT) ?? 6; 
$from  = filter_input(INPUT_GET, 'from', FILTER_VALIDATE_INT) ?? 0; 
$count = 0;                                               
$articles = [];                                           

if ($term) {                                              // If search term provided
    $arguments['term1'] = '%' . $term .'%';               // Store search term in array
    $arguments['term2'] = '%' . $term .'%';               // three times as placeholders
    $arguments['term3'] = '%' . $term .'%';               // cannot be repeated in SQL             

    $count = $cms->getArticle()->searchCount($term);  // Return count

    if ($count > 0) {                                     // If articles match term
        $arguments['show'] = $show;                       // Add to array for pagination
        $arguments['from'] = $from;                       // Add to array for pagination
                                  
        $articles = $cms->getArticle()->search($term, $show, $from); 
    }
}

if ($count > $show) {                                     // If matches is more than show
    $total_pages  = ceil($count / $show);                 // Calculate total pages
    $current_page = ceil($from / $show) + 1;              // Calculate current page
}


$navigation  = $cms->getCategory()->getAll(); 

$section = "";
$title = "Search";
$description = $title . " on Hiking RVer";

?>


<?php include APP_ROOT . "/public/includes/header.php" ?>

<main class="container text-center" id="content">

    <section class="header">
        <h1 class="search-title">Search</h1>
    </section>

    <br>

    <form action="search.php" method="get" class="form-search">
        <label for="search"><span>Search for: </span></label>
        <input type="text" name="term" value="<?= html_escape($term) ?>" 
            id="search" placeholder="Enter search term"  
        /><input type="submit" value="Search" class="btn btn-search" />
    </form>

    <?php if ($term) { ?><p><b>Matches found:</b> <?= $count ?></p><?php } ?>
    

    <hr>

    <section class="card-section">
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php foreach ($articles as $article) { ?>
                <div class="col">
                    <div class="card h-100">
                        <!-- <a href="article.php?id=<?= $article['id'] ?>"> -->
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
                            </p>
                            <a href="article.php?id=<?= $article['id'] ?>" class="btn btn-light btn-md" style="background-color: rgb(107, 206, 245);">Read More</a>
                        </div>
                    </div>
                </div>
            <?php } ?> 
        </div>
    </section>

    <br><hr><br>

    <!-- Pagination Navigation -->
    
    <section class="pagination-section">
        <?php if ($count > $show) { ?>
            <nav class="pagination" role="navigation" aria-label="Page navigation example">
                <ul class="pagination ">
                    <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                        <li class="page-item">
                            <a href="?term=<?= $term ?>&show=<?= $show ?>&from=<?= (($i - 1) * $show) ?>"
                                class="page-link btn <?= ($i == $current_page) ? 'active" aria-current="true' : '' ?>">
                                <?= $i ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </nav>
        <?php } ?>
    </section>
    <!-- <section class="pagination-section">
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
    </section> -->

</main>

<?php include APP_ROOT . "/public/includes/footer.php" ?>



