<?php
require("includes/header.php");
include("logic/utility.php");
include("logic/authentication/auth_signin.php");

if (isset($_SESSION["user_id"])) {
    header("location: dashboard");
}

if (isset($_POST["login"])) {
    auth_signin($_POST["email"], $_POST["password"]);
}
?>

<div class="container">
    <div class="row">
        <div class="mx-auto col-4" style="margin-top: 8%;">
            <?php if (isset($_SESSION["error"])) { ?>
                <div id="login_error" class="mb-4 text-center text-danger h5"><?php echo $_SESSION["error"] ?></div>
            <?php
                echo "<script>setTimeout(function() {
                document.getElementById('login_error').style.display='none';
            }, 3000);</script>";
                unset($_SESSION["error"]);
            } elseif (isset($_SESSION["login_success"])) {  ?>
                <div id="login_success" class="mb-4 text-center text-success h5"><?php echo $_SESSION["login_success"] ?></div>
                 <?php echo "<script>setTimeout(function() {
                window.location='dashboard';
            }, 800);</script>";
            unset($_SESSION["login_success"]);
            } ?>
            <form method="post">
                <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>" placeholder="Email address" />
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" id="password" name="password" value="<?php if (isset($_POST['password'])) echo $_POST['password']; ?>" placeholder="Password" />
                </div>
                <button type="submit" name="login" class="btn btn-primary w-100 custom_bg py-3" style="border: none;">Sign in</button>
            </form>
            <div class="text-center mt-3"><small>Don't have an account yet?</small> <a href="./signup" style="color: #011627; font-size: 16px; font-weight: 300; text-decoration: none;">REGISTER NOW</a></div>
        </div>
    </div>
</div>

<?php require_once("./includes/scripts.php") ?>