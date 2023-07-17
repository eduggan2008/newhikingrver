<?php
declare(strict_types = 1);                                         
include '../../src/bootstrap.php';                                 

is_admin($session->session_role);                                          

$success = $_GET['success'] ?? null;
$failure = $_GET['failure'] ?? null;

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);          
if (!$id) {                                                        
    redirect('members.php', ['failure' => 'Member not found']); 
}

$member = $cms->getMember()->get($id);                             
if (!$member) {                                                    
    redirect('members.php', ['failure' => 'Member not found']); 
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {   
    /* $id = $_POST['id'] ?? ''; */                                  // Get new role
    $role = $_POST['role'] ?? '';                                  // Get new role
    if (in_array($role, ['Member', 'Admin', 'Suspended'])) {       // If valid role will update
        /* $member['id'] = $id; */                                   // Update role in array
        $member['role'] = $role;                                   // Update role in array
    $cms->getMember()->update($member);                        // Update role in database  <<< need to unset joined and member
        redirect('members.php', ['success' => 'Success: Role updated successfully']);    // Redirect with message
    } else {
        redirect('members.php', ['failure' => 'Warning: The role was not updated. Try again.']);    // Redirect with message
    }
}


$members = $cms->getMember()->getAll();

$navigation  = $cms->getCategory()->getAll(); 

$section = "";
$title = "Admin Edit Role";
$description = "Admin Edit Role";

?>


<?php include APP_ROOT . "/public/includes/admin_header.php" ?>

<br><br><br><br>
    <main class="container" id="content">
        <form action="edit_role.php?id=<?= $member['id'] ?>" method="POST" class="narrow">
    
            <div class="category-success-failure-messages col-lg-8">
                <?php if($success) {?> <div class="alert alert-success"><?= $success ?></div> <?php } ?>
                <?php if($failure) {?> <div class="alert alert-danger"><?= $failure ?></div> <?php } ?>
            </div>
            <br>

            <h1>Edit Role</h1>
            <h5>Name of Member: <?= $member['first_name'] ?> <?= $member['last_name'] ?></h5>
            <br>            

            <h2>Role</h2>


        <!-- <div class="form-group">
            <label for="role">Role: </label>
            <?php if ($member['role'] == 'Admin') { ?>
                <input type="radio" name="role" value="Admin" id="" class="" checked /> Admin
                <input type="radio" name="role" value="Member" id="" class="" /> Member
                <input type="radio" name="role" value="Suspended" id="" class="" /> Suspended
            <?php } elseif ($member['role'] == 'Member') { ?>
                <input type="radio" name="role" value="Admin" id="" class="" /> Admin
                <input type="radio" name="role" value="Member" id="" class="" checked /> Member
                <input type="radio" name="role" value="Suspended" id="" class="" /> Suspended
            <?php } elseif ($member['role'] == 'Suspended') { ?>
                <input type="radio" name="role" value="Admin" id="" class="" /> Admin
                <input type="radio" name="role" value="Member" id="" class="" /> Member
                <input type="radio" name="role" value="Suspended" id="" class="" checked /> Suspended
            <?php } ?>
        </div> -->
        
        <div>
            <select name="role" class="form-control">
                <?php if ($member['role'] == 'Admin') { ?>
                    <option value="Admin" selected>Admin</option>
                    <option value="Member" >Member</option>
                    <option value="Suspended" >Suspended</option>
                <?php } elseif ($member['role'] == 'Member') { ?>
                    <option value="Admin" >Admin</option>
                    <option value="Member" selected>Member</option>
                    <option value="Suspended" >Suspended</option>
                <?php } elseif ($member['role'] == 'Suspended') { ?>
                    <option value="Admin" >Admin</option>
                    <option value="Member" >Member</option>
                    <option value="Suspended" selected>Suspended</option>
                <?php } ?>
            </select>
        </div>

        <br>
        <input type="submit" value="Update Role" class="btn btn-primary" />
        </form>
    </main>



  <?php include APP_ROOT . "/public/includes/admin_footer.php" ?>




