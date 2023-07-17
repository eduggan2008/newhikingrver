<?php 
declare(strict_types = 1);
include "../src/bootstrap.php";

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    if (!$id) {                                              
        include APP_ROOT . "/public/page_not_found.php";     
    }

$article = $cms->getArticle()->get($id);               
    if (!$article) {                                         
        include APP_ROOT . "/public/page_not_found.php";     
    }

$images = $cms->getArticle()->get($id);

$navigation  = $cms->getCategory()->getAll(); 

$section = $article['category_id'];
$title = $article['title'];
$description = $article['summary'];


?>


<?php include APP_ROOT . "/public/includes/header.php" ?>

<div class="container text-center">
    <br>

    <article class="row">
        <section class="col">
            
                <div class="row article">
                    <div class="col">
                    
                        <img src="uploads/<?= $article['image_file'] ?? 'hikingrver_default.png' ?>" alt="<?= $article['image_alt'] ?>" class="article-img"  style="width: 600px;">
                    
                        <div class="article-body">
                            <div class="article-header">
                                <h1 class="article-title"><?= $article['title'] ?></h1>
                                <h2 class="article-subtitle"><?= $article['subtitle'] ?></h2>
                                <p class="article-content"><?= $article['content'] ?></p>
                            </div>
                            <br>
                            <div class="article-info">    
                                <p>
                                    Author: <a href="member.php?id=<?= $article['member_id'] ?>">
                                    <?= html_escape($article['author']) ?></a>
                                    <br>
                                    Category: <a href="category.php?id=<?= $article['category_id'] ?>">
                                    <?= html_escape($article['category']) ?></a>
                                    <br>
                                    Posted on: <?= format_date($article['created']) ?>
                                </p>
                                
                            </div>
                        </div>

                        
                        <figure class="figure-container">


                        <!-- Add images to <div class="fotorama"></div> -->
                            <div class="fotorama article-img"
                                    data-nav="thumbs"
                                    data-width="100%"
                                    data-ratio="800/600"
                                    data-minwidth="200"
                                    data-maxwidth="600"
                                    data-minheight="150"
                                    data-maxheight="100%"
                                    data-allowfullscreen="true"
                                    data-autoplay="4000"
                                    >
                                
                                <img src="images/2018_part_1_images/1.1.jpg" alt="Grand Tetons photo">
                                <img src="images/2018_part_1_images/1.2.jpg" alt="Grand Tetons photo">
                                <img src="images/2018_part_1_images/1.3.jpg" alt="Grand Tetons photo">
                                <img src="images/2018_part_1_images/1.4.jpg" alt="Grand Tetons photo">
                                <img src="images/2018_part_1_images/1.5.jpg" alt="Grand Tetons photo">
                                <img src="images/2018_part_1_images/1.6.jpg" alt="Grand Tetons photo">
                                <img src="images/2018_part_1_images/1.7.jpg" alt="Grand Tetons photo">
                                <img src="images/2018_part_1_images/1.8.jpg" alt="Grand Tetons photo">
                                <img src="images/2018_part_1_images/1.9.jpg" alt="Grand Tetons photo">
                                <img src="images/2018_part_1_images/1.10.jpg" alt="Grand Tetons photo">
                                <img src="images/2018_part_1_images/1.11.jpg" alt="Grand Tetons photo">
                                <img src="images/2018_part_1_images/1.12.jpg" alt="Grand Tetons photo">
                                <img src="images/2018_part_1_images/1.13.jpg" alt="Grand Tetons photo">
                                <img src="images/2018_part_1_images/1.14.jpg" alt="Grand Tetons photo">
                                <img src="images/2018_part_1_images/1.15.jpg" alt="Grand Tetons photo">
                                <img src="images/2018_part_1_images/1.16.jpg" alt="Grand Tetons photo">
                                <img src="images/2018_part_1_images/1.17.jpg" alt="Grand Tetons photo">
                                <img src="images/2018_part_1_images/1.18.jpg" alt="Grand Tetons photo">
                                <img src="images/2018_part_1_images/1.19.jpg" alt="Grand Tetons photo">
                                <img src="images/2018_part_1_images/1.20.jpg" alt="Grand Tetons photo">
                                <img src="images/2018_part_1_images/1.21.jpg" alt="Grand Tetons photo">
                                <img src="images/2018_part_1_images/1.22.jpg" alt="Grand Tetons photo">
                                <img src="images/2018_part_1_images/1.23.jpg" alt="Grand Tetons photo">
                                <img src="images/2018_part_1_images/1.24.jpg" alt="Grand Tetons photo">
                                <img src="images/2018_part_1_images/1.25.jpg" alt="Grand Tetons photo">
                                <img src="images/2018_part_1_images/1.26.jpg" alt="Grand Tetons photo">
                                <img src="images/2018_part_1_images/1.27.jpg" alt="Grand Tetons photo">
                                <img src="images/2018_part_1_images/1.28.jpg" alt="Grand Tetons photo">
                                <img src="images/2018_part_1_images/1.29.jpg" alt="Grand Tetons photo">
                                <img src="images/2018_part_1_images/1.30.jpg" alt="Grand Tetons photo">
                                <img src="images/2018_part_1_images/1.31.jpg" alt="Grand Tetons photo">
                                <img src="images/2018_part_1_images/1.32.jpg" alt="Grand Tetons photo">
                                <img src="images/2018_part_1_images/1.33.jpg" alt="Grand Tetons photo">
                                <img src="images/2018_part_1_images/1.34.jpg" alt="Grand Tetons photo">
                                <img src="images/2018_part_1_images/1.35.jpg" alt="Grand Tetons photo">
                                <img src="images/2018_part_1_images/1.36.jpg" alt="Grand Tetons photo">
                                <img src="images/2018_part_1_images/1.37.jpg" alt="Grand Tetons photo">
                                <img src="images/2018_part_1_images/1.38.jpg" alt="Grand Tetons photo">
                            </div>

                                <!-- <img src="uploads/<?= $article['image_file'] ?? 'hikingrver_default.png' ?>" alt="<?= $article['image_alt'] ?>" class="article-img"  style="width: 600px;"> -->
                                <div class="article-body">
                                    <div class="article-header">
                                        <h1 class="article-title"><?= $article['title'] ?></h1>
                                        <h2 class="article-subtitle"><?= $article['subtitle'] ?></h2>
                                    </div>
                                    <p class="article-content"><?= $article['content'] ?></p>
                                    <br><hr>
                                    <p class="article-info">
                                        Author: <a href="member.php?id=<?= $article['member_id'] ?>">
                                        <?= html_escape($article['author']) ?></a>
                                        <br>
                                        Category: <a href="category.php?id=<?= $article['category_id'] ?>">
                                        <?= html_escape($article['category']) ?></a>
                                        <br>
                                        Posted on: <?= format_date($article['created']) ?>
                                    </p>
                                    <hr>
                                </div>

                        </figure>

                    </div>
                </div>
            
        </section>
    </article>
        
</div>


<?php include APP_ROOT . "/public/includes/footer.php" ?>

