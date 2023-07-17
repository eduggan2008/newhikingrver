

<?php $page_title = "Reset Password Page"; ?>

<?php include_once 'includes/header.php' ?>
<?php include_once 'includes/parsePasswordReset.php' ?>


<div class="container ">
    <section class="col col-md-6">
        <h2>Password Reset Form</h2>
        <br>

        <div>
            <?php if (isset($result)) echo $result; ?>
            <?php if (!empty($form_errors)) echo show_errors($form_errors) ?>
        </div>

        <form action="" method="post">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control" name="email" id="email" placeholder="Enter your email address">
            </div>
            <div class="mb-3">
                <label for="reset_token" class="form-label">Token</label>
                <input type="text" class="form-control" name="reset_token" id="reset_token" placeholder="Enter token from your email">
            </div>
            <div class="mb-3">
                <label for="new_password" class="form-label">New Password</label>
                <input type="text" class="form-control" name="new_password" id="new_password" placeholder="Enter your new password">
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm your password">
            </div>
            <br>
            <input type="hidden" name="token" id="token" value="<?php if(function_exists('_token')) echo _token(); ?>">
            <button type="submit" name="passwordResetBtn" class="btn btn-primary">Reset Password</button>
            <br><br>
        </form>

    </section>
</div>

<?php include_once 'includes/footer.php' ?>




