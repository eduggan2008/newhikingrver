<?php 
declare(strict_types = 1);
include "../src/bootstrap.php";
include "../src/classes/Validate.php";

$email = '';
$errors = [
    'warning' => '',
    'email' => '',
    'password' => '',
];

$success = $_GET['success'] ?? null;
$failure = $_GET['failure'] ?? null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $errors['email'] = Validate::isEmail($email) ? '' : 'Please enter a valid email address';
    $errors['password'] = Validate::isPassword($password) ? '' : 'Password must be at least 8 characters and have at least one uppercase letter, one lowercase letter, and one number';
    $invalid = implode($errors);

    if ($invalid) {
        $errors['message'] = 'Warning: Something went wrong. Please try again.';
    } else {
        $member = $cms->getMember()->login($email, $password);
        if ($member and $member['role'] == 'Suspended') {
            /* $errors['message'] = 'Warning: This account is suspended'; */
            $failure = 'Warning: The account associated with the email address you entered is currently suspended.';
        } elseif ($member) {
            $cms->getSession()->create($member);
            if ($member['role'] == 'Member') {
                redirect('member/profile.php', ['id' => $member['id'],]);
                $success = 'Success: You have been successfully logged into your account!';                
            }
            if ($member['role'] == 'Admin') {
                redirect('admin/profile.php', ['id' => $member['id'],]);
                $success = 'Success: You have been successfully logged into your account!';
            }
            
        } else {
            $failure = 'Warning: There was a problem with either your email and/or your password. Please try again or Register for an account at: <?= register.php ?>';
            $errors['message'] = 'Please try again';
        }
    }

}


$navigation  = $cms->getCategory()->getAll(); 

$section = "";
$title = "Login";
$description = $title . " on Hiking RVer";

?>

<?php include APP_ROOT . "/public/includes/header.php" ?>


    <main class="container" id="content">

        <section class="header">
            <h1 class="login-title">Log in</h1>
        </section>

        <br>

        <form method="post" action="login.php" class="form form-membership">

            <div class="category-success-failure-messages col-lg-8">
                <?php if($success) {?> <div class="alert alert-success"><?= $success ?></div> <?php } ?>
                <?php if($failure) {?> <div class="alert alert-danger"><?= $failure ?></div> <?php } ?>
            </div>
            <br>

            <div class="form-group">
                <label for="email">Email </label>
                <input type="text" name="email" id="email" value="" class="form-control">
                <span class="errors"><?= $errors['email'] ?></span>
            </div>
            <br>
            <div class="form-group">
                <label for="password">Password </label>
                <input type="password" name="password" id="password" value="" class="form-control">
                <span class="errors"><?= $errors['password'] ?></span>
            </div>

            <br>
            <input type="submit" class="btn btn-primary" value="Log in">
            <br><br>
            <p><a href="password_lost.php">Forgot Password?</a></p>
        </form>

    </main>
    

<?php include APP_ROOT . "/public/includes/footer.php" ?>


