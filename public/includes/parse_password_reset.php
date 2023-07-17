<?php  

include_once 'resource/Database.php';
include_once 'resource/utilities.php';
include_once 'resource/send_email_gmail.php';

if (isset($_POST['passwordResetBtn'], $_POST['token'])) {

    if (validate_token($_POST['token'])) {

        $form_errors = array();
        $required_fields = array('email', 'reset_token', 'new_password', 'confirm_password');
        $form_errors = array_merge($form_errors, check_empty_fields($required_fields));
        $fields_to_check_length = array('new_password' => 8, 'confirm_password' => 8);
        $form_errors = array_merge($form_errors, check_min_length($fields_to_check_length));
        $form_errors = array_merge($form_errors, check_email($_POST));
    
        if (empty($form_errors)) {
            $email = $_POST['email'];
            $reset_token = $_POST['reset_token'];
            $password1 = $_POST['new_password'];
            $password2 = $_POST['confirm_password'];
    
            if ($password1 != $password2) {
                $result = flashMessage("New password and confirm password do not match");
            } else {
                try {

                    $query = "SELECT * FROM password_reset WHERE email = :email";
                    $queryStatement = $db->prepare($query);
                    $queryStatement->execute([
                        ':email' => $email
                    ]);

                    $isValid = true;

                    if ($rows = $queryStatement->fetch()) {
                        $stored_token = $rows['token'];
                        $expire_time = $rows['expire_time'];

                            if ($stored_token !== $reset_token) {
                                $isValid = false;
                                $result = flashMessage("You have entered an invalid token. Please try again");
                            }

                                if ($expire_time < date('Y-m-d H:i:s')) {
                                    $isValid = false;
                                    $result = flashMessage("Your token has expired.  Request a new token.");

                                    // Delete expired token
                                    $db->exec("DELETE FROM password_reset
                                                WHERE email = '$email' AND token = '$stored_token'");
                                }

                    } else {
                        $isValid = false;
                        $result = flashMessage("An error has occurred. Please request a new token.");
                    }

                    if ($isValid) {

                        $sqlQuery = "SELECT id FROM users WHERE email = :email";
                        $statement = $db->prepare($sqlQuery);
                        $statement->execute(array(':email' => $email));
        
                        if ($rs = $statement->fetch()) {
                            $hashed_password = password_hash($password1, PASSWORD_DEFAULT);
                            $id = $rs['id'];
        
                            $sqlUpdate = "UPDATE users SET password = :password WHERE id = :id";
        
                            $statement = $db->prepare($sqlUpdate);
                            $statement->execute(array(':password' => $hashed_password, ':id' => $id));

                            if ($statement->rowCount() == 1) {
                                // Delete expired token
                                $db->exec("DELETE FROM password_reset
                                WHERE email = '$email' AND token = '$stored_token'");
                            }
                            
        
                            $result = flashMessage("Password was successfully reset", "Pass");
        
                        } else {
                            $result = flashMessage("The email address you provided does not exist in our database.  Please try again");
                        }

                    } 

    
                } catch (PDOException $ex) {
                    $result = flashMessage("An error has occured: " . $ex->getMessage());
                }
            }
        } else {
            if (count($form_errors) == 1) {
                $result = flashMessage("There was 1 error in the form <br>");
            } else {
                $result = flashMessage("There were " . count($form_errors). " errors in the form <br>");
            }
        } 
    } else {
        $result = flashMessage("This request originates from an unknown source.  Possible attack!");
    }


} else if (isset($_POST['passwordRecoveryBtn'], $_POST['token'])) {

    if (validate_token($_POST['token'])) {

        $form_errors = array();
        $required_fields = array('email');
        $form_errors = array_merge($form_errors, check_empty_fields($required_fields));
        $form_errors = array_merge($form_errors, check_email($_POST));
    
        if (empty($form_errors)) {
            $email = $_POST['email'];
    
                try {
                    $sqlQuery = "SELECT * FROM users WHERE email = :email";
                    $statement = $db->prepare($sqlQuery);
                    $statement->execute(array(':email' => $email));
    
                    if ($rs = $statement->fetch()) {
                        $username = $rs['username'];
                        $email = $rs['email'];

                        // Create and store a token
                        $expire_time = date('Y-m-d H:i:s', strtotime('4 hours'));
                        $random_string = base64_encode(openssl_random_pseudo_bytes(10));
                        $reset_token = strtoupper(preg_replace('/[^A-Za-z0-9\-]/', '', $random_string));

                        $insertToken = "INSERT INTO password_reset (email, token, expire_time)
                                        VALUES (:email, :token, :expire_time)";
                        $token_statement = $db->prepare($insertToken);
                        $token_statement->execute([
                            ':email' => $email, ':token' => $reset_token, ':expire_time' => $expire_time
                        ]);
    
                        $mail_body = '<html>
                        <body style="background-color:#CCCCCC; color:#000; font-family: Arial, Helvetica, sans-serif;
                                            line-height:1.8em;">

                        <h2>User Authentication: Code A Secured Login System</h2>

                        <p>Dear '.$username.'<br><br>To reset your login password, you will need to copy the token then click on the Reset Password link below.  Now enter the token from this email into the Token field of the form.
                            <br><br>
                            Token: '.$reset_token.'
                            <br>
                            This token will expire after 4 hours!
                        </p>

                        <p><a href="http://localhost/forgot_password.php">Reset Password</a></p>
                        <p>Thank you!</p>
                        <p><strong>&copy;'.date('Y').' Hiking RVer</strong></p>
                        </body>
                        </html>';
    
                        $mail->addAddress($email, $username);
                        $mail->Subject = "Password recovery message from Hiking RVer";
                        $mail->Body = $mail_body;
    
                        if (!$mail->Send()) {
                            $result = flashMessage("The password recovery email message was not sent");
                        } else {
                            $result = flashMessage("Congratulations " . $username . ", your password reset link has been sent to you. Please check your email for the link before logging in.  Thank you", "Pass");
                        }
                    } else {
                        $result = flashMessage("The email address you provided does not exist in our database.  Please try again");
                    }
    
                } catch (PDOException $ex) {
                    $result = flashMessage("An error has occured: " . $ex->getMessage());
                }
        } else {
            if (count($form_errors) == 1) {
                $result = flashMessage("There was 1 error in the form <br>");
            } else {
                $result = flashMessage("There were " . count($form_errors). " errors in the form <br>");
            }
        } 
    } else {
        $result = flashMessage("This request originates from an unknown source.  Possible attack!");
    }

}




