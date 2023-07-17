<?php 
declare(strict_types = 1);               
include "../../src/classes/Validate.php";  
include "../../src/bootstrap.php"; 
include "../../src/classes/Member.php";

is_member($session->session_role);

$success = $_GET['success'] ?? null;
$failure = $_GET['failure'] ?? null;

/* $deleted = null; */

$id = $cms->getSession()->session_id;                        // Get user's id from session
if ($id === 0) {                                         // If not logged in
    redirect('../login.php');                               // Page not found
}

$member = "";

$sql = "SELECT role, first_name, last_name, email, picture, joined,
        FROM member
        WHERE id = :id;";

$member = $cms->getMember()->get($id, false);
    if (!$member) {
        redirect('../login.php', ['failure' => 'Warning: The member you searched for was not found']);
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {              
        if (isset($member['picture'])) {                   
            $path = APP_ROOT . '/public/uploads/' . $member['picture']; 
            $cms->getMember()->pictureDelete($member['id'], $path, $id); 
        }
        $deleted = $cms->getMember()->delete($id);          
        if ($deleted === true) {                             
            redirect('../logout.php', ['success' => 'Success: The article was deleted successfully']); 
        } else {                                            
            throw new Exception('Warning: Unable to delete article'); 
        }
        if($deleted === false) {
            redirect('delete_profile.php', ['failure' => 'Warning: The member has articles posted by them that must be deleted or moved before the member profile can be deleted!']);
        }
    }

$navigation  = $cms->getCategory()->getAll(); 

$section = "";
$title = "Member Delete";
$description = "Member Delete";

?>


<?php include APP_ROOT . "/public/includes/member_header.php" ?>

<br><br><br>

<div class="container">
    
    <div class="category-success-failure-messages col-lg-8">
        <?php if($success) {?> <div class="alert alert-success"><?= $success ?></div> <?php } ?>
        <?php if($failure) {?> <div class="alert alert-danger"><?= $failure ?></div> <?php } ?>
    </div>
    <br>

    <h1>Delete Member Profile: "<?= $member['first_name'] . ' ' . $member['last_name'] ?>"</h1>
    <br>
    <h3>IMPORTANT: You must delete any articles posted by this member before you can delete this member profile!</h3>

    <form action="delete_profile.php?id=<?= $id ?>" method="post" class="narrow">
        <p>Click below confirm to delete: <i><?= $member['first_name'] . ' ' . $member['last_name'] ?></i></p>
        <input type="submit" name="delete" id="delete" class="btn btn-danger" value="Delete Member Profile: '<?= $member['first_name'] . ' ' . $member['last_name'] ?>'">
        &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
        <a href="profile.php?id=<?= $member['id'] ?>" class="btn btn-warning">Cancel</a>
    </form>
</div>



<?php include APP_ROOT . "/public/includes/member_footer.php" ?>





