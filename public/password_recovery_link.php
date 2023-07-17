
<?php $page_title = "Password Recovery Page"; ?>

<?php include_once 'includes/header.php'; ?>
<?php include_once 'includes/parsePasswordReset.php'; ?>

<div class="container">
    <section class="col col-lg-7">
        <h2>Password Recovery</h2>
        <hr>

        <div>
            <?php if (isset($result)) echo $result; ?>
            <?php if (!empty($form_errors)) echo show_errors($form_errors); ?>

            <form action="" method="post">
                <div class="form-group">
                    <label for="email">Email</label>
                    <br>
                    <input type="text" class="form-control" name="email" id="email" placeholder="Enter your email address">
                </div>
                <br>
                <input type="hidden" name="token" id="token" value="<?php if(function_exists('_token')) echo _token(); ?>">
                <button type="submit" name="passwordRecoveryBtn" id="passwordRecoveryBtn" class="btn btn-primary">Recover Password</button>
                <br><br>
            </form>
        </div>
    </section>
</div>

<?php include_once 'includes/footer.php'; ?>


