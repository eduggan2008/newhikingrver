<?php  

include_once 'resource/Database.php';
include_once 'resource/utilities.php';

if (isset($_POST['changePasswordBtn'], $_POST['token'])) {

    if (validate_token($_POST['token'])) {

        $form_errors = array();
        $required_fields = array('current_password', 'new_password', 'confirm_new_password');
        $form_errors = array_merge($form_errors, check_empty_fields($required_fields));
        $fields_to_check_length = array('new_password' => 8, 'confirm_new_password' => 8);
        $form_errors = array_merge($form_errors, check_min_length($fields_to_check_length));
        $form_errors = array_merge($form_errors, check_email($_POST));

        if (empty($form_errors)) {
            $id = $_POST['hidden_id'];
            $current_password = $_POST['current_password'];
            $password1 = $_POST['new_password'];
            $password2 = $_POST['confirm_new_password'];
    
            if ($password1 != $password2) {
                $result = flashMessage("New password and confirm password do not match");
            } else {
                try {
                    $sqlQuery = "SELECT password FROM users WHERE id = :id";
                    $statement = $db->prepare($sqlQuery);
                    $statement->execute(array(':id' => $id));

                    if ($row = $statement->fetch()) {
                        $password_from_db = $row['password'];

                        if (password_verify($current_password, $password_from_db)) {
                            $hashed_password = password_hash($password1, PASSWORD_DEFAULT);

                            $sqlUpdate = "UPDATE users SET password = :password WHERE id = :id";
                            $statement = $db->prepare($sqlUpdate);
                            $statement->execute(array(':password' => $hashed_password, ':id' => $id));

                            if ($statement->rowCount() === 1) {
                                $result = flashMessage("Password was updated reset", "Pass");
                            } else {
                                $result = flashMessage("No changes were saved");
                            }
                        } else {
                            $result = flashMessage("The old password you entered is not correct.  Please try again");
                        }
                    } else {
                        signout();
                    }
                } catch (PDOException $ex) {
                    $result = flashMessage("An error has occured: " . $ex->getMessage());
                }
            }

        } else {
            if (count($form_errors) === 1) {
                $result = flashMessage("There was 1 error in the change password form <br>");
            } else {
                $result = flashMessage("There were " . count($form_errors). " errors in the change password form <br>");
            }
        }

    } else {
        $result = flashMessage("This request originates from an unknown source.  Possible attack!");
    }

}
    




