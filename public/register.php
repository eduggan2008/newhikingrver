<?php 
declare(strict_types = 1);
include "../src/classes/Validate.php";
include "../src/bootstrap.php";

/* $_SESSION['page_count'] = $_SESSION['page_count'] + 1; */

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

$success = $_GET['success'] ?? null;
$failure = $_GET['failure'] ?? null;

$member = [
];

$errors = [
    'warning' => '',
    'first_name' => '',
    'last_name' => '',
    'email' => '',
    'password' => '',
    'confirm' => '',
];

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    $member['first_name'] = $_POST['first_name'];
    $member['last_name'] = $_POST['last_name'];
    $member['email'] = $_POST['email'];
    $member['password'] = $_POST['password'];
    $confirm = $_POST['confirm'];


    $errors['first_name'] = Validate::isText($member['first_name'], 1, 50) ? '' : 'Warning: The first name should be 50 characters or less!';
    $errors['last_name'] = Validate::isText($member['last_name'], 1, 50) ? '' : 'Warning: The last name should be 50 characters or less!';
    $errors['email'] = Validate::isEmail($member['email']) ? '' : 'Warning: The email must be a valid email address!';
    $errors['password'] = Validate::isPassword($member['password']) ? '' : 'Warning: The password should be a minimum of 8 characters, and include at least one uppercase letter, one lowercase letter and one number!';
    /* $errors['confirm'] = Validate::isPassword($member['confirm']) ? '' : 'Warning: The passwords do not match!'; */
    $errors['confirm']  = ($member['password'] = $confirm) ? '' : 'Passwords do not match';

    $invalid = implode($errors);


    if (!$invalid) {                               
        $result = $cms->getMember()->create($member);      
        if ($result === false) {    
            redirect('register.php', ['failure' => 'Warning: The email you submitted is already in our database.  Please try logging in here: <a href="login.php">Login</a>!']);  
        } else {                                             
            redirect('register.php', ['success' => 'Thanks for joining! You have successfully registered! Please log in here: <a href="login.php">Login</a>']); 
        }
    }
}

$navigation  = $cms->getCategory()->getAll(); 

$section = "";
$title = "Register";
$description = $title . " on Hiking RVer";

?>


<?php include APP_ROOT . "/public/includes/header.php" ?>

    <main class="container admin" id="content">

        <section class="header">
            <h1 class="register-title">Register</h1>
        </section>

        <br>

        <form class="form form-horizontal" action="register.php" method="post">

            <?php if($errors['warning']) { ?>
                <div class="alert alert-danger"><?= $errors['warning'] ?></div>
            <?php } ?>
            
            <div class="category-success-failure-messages col-lg-8">
                <?php if($success) {?> <div class="alert alert-success"><?= $success ?></div> <?php } ?>
                <?php if($failure) {?> <div class="alert alert-danger"><?= $failure ?></div> <?php } ?>
            </div>

            <br>
            <div class="form-group">
                <label for="first_name">First Name:  </label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="">
                <span class="errors"><?= $errors['first_name'] ?></span>
            </div>
            <br>
            <div class="form-group">
                <label for="last_name">Last Name:  </label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="">
                <span class="errors"><?= $errors['last_name'] ?></span>
            </div>
            <br>
            <div class="form-group">
                <label for="email">Email:  </label>
                <input type="email" class="form-control" id="email" name="email" value="">
                <span class="errors"><?= $errors['email'] ?></span>
            </div>
            <br>
            <div class="form-group">
                <label for="password">Password:  </label>
                <input type="text" class="form-control" id="password" name="password" value="">
                <span class="errors"><?= $errors['password'] ?></span>
            </div>
            <br>
            <div class="form-group">
                <label for="confirm">Confirm Password:  </label>
                <input type="text" class="form-control" id="confirm" name="confirm" value="">
                <span class="errors"><?= $errors['confirm'] ?></span>
            </div>
            <br>
            <input type="submit" value="Register" class="btn btn-primary btn-save btn-lg mb-4">

        </form>
        
    </main>



<?php include APP_ROOT . "/public/includes/footer.php" ?>

