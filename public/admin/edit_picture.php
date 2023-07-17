<?php
declare(strict_types = 1);                 
include "../../src/classes/Validate.php";  
include '../../src/bootstrap.php';   
include "../../src/classes/Member.php";   

is_admin($session->session_role);

$errors = [
    'warning' => '',
    'name' => '',
    'description' => '',
];

$success = $_GET['success'] ?? null;
$failure = $_GET['failure'] ?? null;


$id = $cms->getSession()->session_id;                        // Get user's id from session
if ($id === 0) {                                         // If not logged in
    redirect('../login.php');                               // Page not found
}

$member = $cms->getMember()->get($id, false);
    if (!$member) {
        redirect('../login.php', ['failure' => 'Warning: The member you searched for was not found']);
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {              
        if (isset($member['picture'])) {                   
            $path = APP_ROOT . '/public/uploads/' . $member['picture']; 
            $cms->getMember()->pictureDelete($member['id'], $path, $id); 
            redirect('edit_picture.php', ['id'=>$id, 'success'=>'Picture deleted successfully',]);
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {              
        $temp = $_FILES['image']['tmp_name'] ?? '';          
        if (is_uploaded_file($temp) and $_FILES['image']['error'] == 0) {   
    
            $errors = in_array(mime_content_type($temp), MEDIA_TYPES)
                ? '' : 'Wrong file type. ';                  
            $extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION)); 
            $errors .= in_array(pathinfo($extension), FILE_EXTENSIONS);
            $errors .= ($_FILES['image']['size'] <= MAX_SIZE)
                ? '' : 'File too big. ';                     
    
            if (!$errors) {                                                          
                $filename = create_filename($_FILES['image']['name'], UPLOADS);               
                $cms->getMember()->pictureCreate($id, $filename, $temp, UPLOADS . $filename);   
                redirect('profile.php', ['id'=>$id, 'success'=>'Picture updated successfully',]);  
                
            } else {                                                                 
                $errors .= 'Please try again.';                        
            }
    
        } else {                                                                      
            $errors = 'Please upload a profile picture.';                             
        }
    } 
    

$navigation  = $cms->getCategory()->getAll(); 

$section = "";
$title = "Profile Picture";
$description = "Edit Profile Picture";

?>


<?php include APP_ROOT . "/public/includes/admin_header.php" ?>


<br><br><br><br>

  <main class="container" id="content">
    
    <?php if ($member['picture'] == true) { ?>
        <section class="header"><h3>Delete picture</h3></section>
            <form action="edit_picture.php" method="POST" class="form-membership">
                <p class="center">First you must click delete to remove your profile picture: <br><img src="../uploads/<?= $member['picture'] ?>" width="300px"  alt="<?= $member['first_name'] ?>" class="profile"></p>
                <input type="submit" name="delete" id="delete" value="Delete" class="btn btn-danger" />
                <a href="profile.php?id=<?= $member['id'] ?>" class="btn btn-warning">Cancel</a>
            </form>
    <?php } else { ?>
        <section class="header"><h3>Upload picture</h3></section>
            <form action="edit_picture.php" method="POST"  enctype="multipart/form-data"  class="form-membership">

                    
                <div class="category-success-failure-messages col-lg-8">
                    <?php if($success) {?> <div class="alert alert-success"><?= $success ?></div> <?php } ?>
                    <?php if($failure) {?> <div class="alert alert-danger"><?= $failure ?></div> <?php } ?>
                </div>
                <br>

                
                <?php if($errors['warning']) { ?>
                    <div class="alert alert-danger"><?= $errors['warning'] ?></div>
                <?php } ?>
            
                <div class="form-group">
                    <label for="image">Select a new profile picture:</label>
                    <input type="file" name="image" id="image"/>
                </div>
                <input type="submit" name="upload" value="Upload" class="btn btn-primary" />


                <!-- <div class="alert alert-success"><?= $messages['success'] ?></div>
                <div class="alert alert-failure"><?= $messages['failure'] ?></div> -->

            </form>
    <?php } ?>
</main>




<?php include APP_ROOT . "/public/includes/admin_footer.php" ?>






