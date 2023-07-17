<?php 
declare(strict_types = 1);
include "../src/bootstrap.php";


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
                $moved = move_uploaded_file($_FILES['image']['tmp_name'], $destination);
            }
        }

        if ($moved === true) {
            $message = '<b>Image Uploaded: </b><br><br> <img src="' . $destination .'" style="width: 500px;">';
            $message .= '<br><br>';  
            
            $message .= '<b>File Name: </b>' . $_FILES['image']['name'] . '<br><br>';
            $message .= '<b>File Size: </b> ' . $_FILES['image']['size'] . ' bytes'; 

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

<form action="upload_file.php" method="POST" enctype="multipart/form-data">
    <label for="image"><b>Upload file: </b></label>
    <input type="file" name="image" id="image" accept="image/jpeg, image/jpg, image/png, image/gif" width="400">
    <br><br>
    <input type="submit" value="Upload Image">
</form>

<?php include APP_ROOT . "/public/includes/footer.php" ?>
