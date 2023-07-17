<?php 
declare(strict_types = 1);
include "../../src/bootstrap.php";
include "../../src/classes/Member.php";

is_member($session->session_role);

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    if (!$id) {
        include APP_ROOT . "/public/page_not_found.php";
    }

$success = $_GET['success'] ?? null;
$failure = $_GET['failure'] ?? null;
    

$member = $cms->getMember()->get($id);
    if (!$member) {
        include APP_ROOT . "/public/page_not_found.php";
    }

$articles = $cms->getArticle()->getAll(true, null, $id);

$navigation  = $cms->getCategory()->getAll(); 

$section = "";
$title = $member['first_name'] . ' ' . $member['last_name'];
$description = $title . " on Hiking RVer";

?>


<?php include APP_ROOT . "/public/includes/member_header.php" ?>

<br><br><br>

<!-- Start Member's Profile Page -->

<div class="container">

    <br><br>

    <?php if($member['id'] == $session_id ) { ?>

        <!-- Start Member Profile Table -->
        
        <section class="col col-lg-8">
            <div class="row justify-content-center">
                <div class="card text-white bg-info mb-3 w-90 member_profile">

                    
                        <div class="card-header text-center">
                            <div>
                                <h2><?= $session_first_name . ' ' . $session_last_name ?> Profile Page</h2>
                                <div class="card-img-top">
                                    <img src="../uploads/<?= $member['picture'] ?? 'default_avatar.jpg' ?>" style="height: 250px;" alt="Photo of <?= $session_first_name ?>">
                                </div>
                                <div class="card-member-title">
                                    <h3>Welcome</h3>
                                    <p>You are currently logged in</p>
                                </div>
                            </div>       
                        </div>
                                
                        <div class="card-body">
                            <table class="table table-hover">
                                <tbody>
                                    <tr>
                                        <th>Role: </th>
                                        <td><?= $session_role ?></td>
                                    </tr>
                                    <tr>
                                        <th>First Name: </th>
                                        <td><?= $session_first_name ?></td>
                                    </tr>
                                    <tr>
                                        <th>Last Name: </th>
                                        <td><?= $session_last_name ?></td>
                                    </tr>
                                    <tr>
                                        <th>Email: </th>
                                        <td><?= $session_email ?></td>
                                    </tr>
                                    <tr>
                                        <th>Profile Last Updated: </th>
                                        <td><?= $session_joined ?></td>
                                    </tr>
                                    <br><br>
                                </tbody>
                            </table>

                            <div>
                                <nav class="member-options">
                                    <a href="article.php" class="btn btn-success">Add New Article</a>
                                    <a href="edit_profile.php" class="btn btn-primary">Edit Profile</a>
                                    <a href="edit_picture.php" class="btn btn-primary">Edit Picture</a>
                                    <!-- <a href="../password_lost.php" class="btn btn-primary">Change Password</a> -->
                                    <a href="delete_profile.php" class="btn btn-danger">Delete Profile</a>
                                </nav>
                            </div>

                        </div>
                                
                    
        
                </div>
            </div>
        </section>


        <!-- End Member Profile Table -->

        <br><hr><br>

        <!-- Start List of the logged in member's posted articles -->

        <section class="card-section">
            <h2>Here are the articles you have posted</h2>
            <br>
            <div class="row row-cols-1 row-cols-md-3 g-4">
                <?php foreach ($articles as $article) { ?>
                    <div class="col">
                        <div class="card h-100">
                            <img src="../uploads/<?= $article['image_file'] ?? 'hikingrver_default.png' ?>" alt="<?= $article['image_alt'] ?>">
                            <div class="card-body">
                                <h2 class="card-title"><?= $article['title'] ?></h2>
                                <h4 class="card-subtitle"><?= $article['subtitle'] ?></h4>
                                <p class="card-text"><?= substr($article['content'], 0, 75) ?>.....</p>

                                <p class="card-info">
                                    Author: <a href="../member.php?id=<?= $article['member_id'] ?>">
                                    <?= html_escape($article['author']) ?></a>
                                    <br>
                                    Category: <a href="../category.php?id=<?= $article['category_id'] ?>">
                                    <?= html_escape($article['category']) ?></a>
                                    <br>
                                    Posted on: <?= format_date($article['created']) ?>
                                    <br>
                                </p>
                                
                                <a href="../article.php?id=<?= $article['id'] ?>" class="btn btn-light btn-md" style="background-color: rgb(107, 206, 245);">View Article</a>
                                <?php if ($session_id == $member['id']) { ?>
                                    <a href="article.php?id=<?= $article['id'] ?>" class="btn btn-primary">Edit Article</a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php } ?> 
            </div>
        </section>

        <!-- End List of the logged in member's posted articles -->
        
        <!-- Start Pagination Code -->                           

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

        <!-- End Pagination Code -->

        <!-- End Member's Profile Page' -->

    <?php } else { ?>
        <h4>"You must be a member to view this page!  Please login first!</h4>
    <?php } ?>

</div>


<?php include APP_ROOT . "/public/includes/member_footer.php" ?>
