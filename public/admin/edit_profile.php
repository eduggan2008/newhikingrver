<?php
declare(strict_types = 1);                               
include "../../src/classes/Validate.php";                           
include '../../src/bootstrap.php';           
               
is_admin($session->session_role);

$session_id = $cms->getSession()->session_id;                            // Get user's id from session
if ($session_id === 0) {                                         // If not logged in
    redirect('login.php');                               // Page not found
}

$errors = [
    'warning' => '',
    'name' => '',
    'description' => '',
];                                       

$success = $_GET['success'] ?? null;
$failure = $_GET['failure'] ?? null;

if ($_SERVER['REQUEST_METHOD'] != 'POST') {              // If form not posted
    $member  = $cms->getMember()->get($cms->getSession()->session_id); // Get member details
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {              // If form was posted
    $member['id']       = $cms->getSession()->session_id;        // Get member id
    $member['first_name'] = $_POST['first_name'];            
    $member['last_name']  = $_POST['last_name'];             
    $member['email']    = $_POST['email'];               
    $member['role']     = $cms->getSession()->session_role;      

    
    $errors['first_name'] = Validate::isText($member['first_name'], 1, 254) ? '' :
        'First name should be between 1 and 254 characters';
    $errors['last_name']  = Validate::isText($member['last_name'], 1, 254) ? '' :
        'Last name should be between 1 and 254 characters';
    $errors['email']    = Validate::isEmail($member['email']) ? '' :
        'Please enter a valid email address';

    $invalid = implode($errors);                            
    if ($invalid) {                                         
        $errors['message'] = 'Please correct form errors';  
    } else {                                                
        $result = $cms->getMember()->update($member);       // Create new member & store id
        if ($result === false) {                            
            $errors['message'] = 'Email already in use';    
        } else {                                            
            $cms->getSession()->update($member);            // Update session
            redirect('edit_profile.php', ['id'=>$member['id'], 'success'=>'Profile updated successfully!',]); // Send to profile page
        }
    }
}

$navigation  = $cms->getCategory()->getAll(); 

$section = "";
$title = "Member Edit Profile";
$description = "Member Edit Profile";

?>

<?php include APP_ROOT . "/public/includes/admin_header.php" ?>


<br><br><br><br>


<main class="container" id="content">
    <section> 
        <h1>Update Profile</h1>
        <form method="post" action="edit_profile.php" class="form-membership">

            <div class="category-success-failure-messages col-lg-8">
                <?php if($success) {?> <div class="alert alert-success"><?= $success ?></div> <?php } ?>
                <?php if($failure) {?> <div class="alert alert-danger"><?= $failure ?></div> <?php } ?>
            </div>
            <br>
            
            <?php if($errors['warning']) { ?>
                <div class="alert alert-danger"><?= $errors['warning'] ?></div>
            <?php } ?>
                

            <div class="form-group">
            <label for="first_name">First Name: </label>
            <input type="text" name="first_name" value="<?= $member['first_name'] ?>" id="first_name" class="form-control" />
            <span class="errors"><?= $errors['warning'] ?></span><br>
            </div>

            <div class="form-group">
            <label for="last_name">Last Name: </label>
            <input type="text" name="last_name" value="<?= $member['last_name'] ?>"  id="last_name" class="form-control" />
            <span class="errors"><?= $errors['warning'] ?></span><br>
            </div>

            <div class="form-group">
            <label for="email">Email: </label>
            <input type="text" name="email" id="email" class="form-control" value="<?= $session_email ?>" />
            <span class="errors"><?= $errors['warning'] ?></span><br>
            </div>

            <div class="form-group">
            <button type="submit" class="btn btn-primary">Update Profile</button>
            </div>

        </form>
    </section>
</main>


<?php include APP_ROOT . "/public/includes/admin_footer.php" ?>


