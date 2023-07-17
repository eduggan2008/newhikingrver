<?php 
declare(strict_types = 1);
include "../src/bootstrap.php";

/* $message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_FILES['image']['error'] === 0) {
        $message = '<b>File: </b>' . $_FILES['image']['name'] . '<br><br>';
        $message .= '<b>Size: </b> ' . $_FILES['image']['size'] . ' bytes';
        
    } else {
        $message = 'The file could not be uploaded';
    }
} */

/* $message = '';
$moved = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_FILES['image']['error'] === 0) {
        $temp = $_FILES['image']['tmp_name'];
        $path = 'uploads/' . $_FILES['image']['name'];
        $moved = move_uploaded_file($temp, $path);    
    } 

    if ($moved === true) {
        $message = '<img src="' . $path .'">';     
    } else {
        $message = 'The file could not be saved';
    }
    
} */

$message = '';
$moved = false;
$error = '';

$upload_path = 'uploads/';
$max_size = 5242880;
$allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
$allowed_exts = ['jpeg', 'jpg', 'png', 'gif'];



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_FILES['image']['error'] === 0) {
        $error = ($_FILES['image']['error'] === 1) ? 'File size too big ' : '';
        if ($_FILES['image']['error'] == 0) {
            $error .= ($_FILES['image']['size'] <= $max_size) ? '' : 'Size too big';
            $type = mime_content_type($_FILES['image']['tmp_name']);
            $error .= in_array($type, $allowed_types) ? '' : 'Wrong type of file';
            $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            $error .= in_array($ext, $allowed_exts) ? '' : 'Wrong file extension';

            if (!$error) {
                $filename = create_filename($_FILES['image']['name'], $upload_path);
                $destination = $upload_path . $filename;
                $thumbpath = $upload_path . 'thumb_' . $filename;
                $moved = move_uploaded_file($_FILES['image']['tmp_name'], $destination);
                $resized = resize_image_gd($destination, $thumbpath, 200, 200);
            }
        }

        if ($moved === true and $resized === true) {
            $message = '<img src="' . $thumbpath . '">'; 
            /* $message = '<b>Image Uploaded: </b><br> <img src="' . $destination .'">';
            $message .= '<br><br>';   */
            
            /* $message .= '<b>File Name: </b>' . $_FILES['image']['name'] . '<br><br>';
            $message .= '<b>File Size: </b> ' . $_FILES['image']['size'] . ' bytes';  */

        } else {
            $message = '<b> Could not upload file:</b> ' . $error;
        }
        
    }
}

$navigation  = $cms->getCategory()->getAll(); 

$section = "";
$title = "Hiking RVer";
$description = "Articles and photos of hiking and rving adventures";

?>

<?php include APP_ROOT . "/public/includes/header.php" ?>

<h1>File Upload Page</h1>

<br><br>

<?= $message ?>
<br><br><br>

<form action="upload_file_copy_gd.php" method="POST" enctype="multipart/form-data">
    <label for="image"><b>Upload file: </b></label>
    <input type="file" name="image" id="image" accept="image/jpeg, image/jpg, image/png, image/gif">
    <br><br>
    <input type="submit" value="Upload Image">
</form>

<?php include APP_ROOT . "/public/includes/footer.php" ?>
