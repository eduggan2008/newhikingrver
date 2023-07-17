<?php
declare(strict_types = 1);                        
include "../../src/bootstrap.php";                           

is_admin($session->session_role);

$article_count  = $cms->getArticle()->count();           
$category_count = $cms->getCategory()->count();   
$member_count = $cms->getMember()->count();   

$navigation  = $cms->getCategory()->getAll(); 

$section = "";
$title = "Admin Home Page";
$description = "Admin Home Page";

?>


<?php include APP_ROOT . "/public/includes/admin_header.php" ?>

<br><br><br><br>
<main class="container text-center" id="content">

    <section class="hero-section text-center">
        <div class="flag">
            <h1>Hiking RVer Admin Page</h1>
            <h3>Welcome <?= $session_first_name . ' ' . $session_last_name ?></h3>
            <hr>
        </div>
    </section>

    <br>


    <!-- Start Dashboard Block -->

    <section>
        
        <div class="">
            <h3>Categories, Articles and Members</h3>
            <h6>This section is only available to Admin level members!</h6>
            
            <br>
        </div>

        <div class="row">

            <div class="card admin_dashboard col-lg-4 col-md-6 p-2">  
                <div class="card-header text-bg-warning">    
                    <div class="row row-col-2 p-2"> 
                        <div class="col">
                            <div class="" style="font-size:2.0em;"><?= $category_count ?> Categories</div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-center">   
                    <td><a href="category.php" class="btn btn-primary">Add Category</a></td>
                    <td><a href="categories.php" class="btn btn-primary">View Categories</a></td>
                </div>
            </div>

            <div class="card admin_dashboard col-lg-4 col-md-6 p-2">
                <div class="card-header text-bg-danger">    
                    <div class="row row-col-2 p-2">          
                        <div class="col">
                            <div class="" style="font-size:2.0em;"><?= $article_count ?> Articles</div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-center">
                <td><a href="article.php" class="btn btn-primary">Add Article</a></td>
            <td><a href="articles.php" class="btn btn-primary">View Articles</a></td>
                </div>
            </div>

            <div class="card admin_dashboard col-lg-4 col-md-6 p-2">
                <div class="card-header text-bg-success">    
                    <div class="row row-col-2 p-2">          
                        <div class="col">
                            <div class="" style="font-size:2.0em;"><?= $member_count ?> Members</div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <td><a href="add_member.php" class="btn btn-primary">Add Member</a></td>
                    <td><a href="members.php" class="btn btn-primary">View Members</a></td>
                </div>
            </div>

        </div>
    </section>

    <br><br>
    <!-- End Dashboard Block -->

</main>


<?php include APP_ROOT . "/public/includes/admin_footer.php" ?>



