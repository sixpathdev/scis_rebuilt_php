<?php
require("includes/header.php");
include("logic/utility.php");
include("logic/authentication/auth_signup.php");
// session_unset();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $response = auth_signup($_POST["matric_no"], $_POST["fullname"], $_POST["email"], $_POST["password"]);
    if ($response) {
        $checkEmailAfterSignup = $db->JsonBuilder()->rawQuery("SELECT * FROM `authentication` WHERE email = ?", array($_POST["email"]));
        $checkEmailAfterSignup = json_decode($checkEmailAfterSignup, true);
        $_SESSION["id"] = $checkEmailAfterSignup[0]["id"];
        $_SESSION["user_id"] = $checkEmailAfterSignup[0]["user_id"];
        $_SESSION["name"] = $checkEmailAfterSignup[0]["full_name"];
        $_SESSION["email"] = $checkEmailAfterSignup[0]["email"];
        $_SESSION["registration_success"] = true;
    } else {
        $_SESSION["error"] =  true;
    }
}

?>

<div class="container">
    <div class="row">
        <div class="mx-auto col-4" style="margin-top: 7%;">
            <?php if (isset($_SESSION["error"])) { ?>
                <div id="registration_error" class="mb-4 text-center text-danger h5"><?php echo $_SESSION["registration_error"] ?></div>
            <?php
                echo "<script>setTimeout(function() {
                document.getElementById('error').style.display='none';
            }, 3500);</script>";
                unset($_SESSION["error"]);
            } elseif (isset($_SESSION["registration_success"])) { ?>
                <div id="registration_success" class="mb-4 text-center text-success h5">Registration successful</div>
            <?php
                echo "<script>setTimeout(function() {
                document.getElementById('registration_success').style.display='none';
                }, 3500);</script>";
                unset($_SESSION["registration_success"]);
                echo "<script>setTimeout(function() {
                    window.location='dashboard';
                    }, 3600);</script>";
            } ?>
            <form method="post">
                <div class="form-group">
                    <label for="exampleInputEmail1">Matriculation number</label>
                    <input type="text" class="form-control" id="matric_no" name="matric_no" value="<?php if (isset($_POST['matric_no'])) echo $_POST['matric_no']; ?>" aria-describedby="matnoHelp" placeholder="Matriculation number" required />
                    <small id="matnoHelp" class="form-text text-muted">This is private, only required for registration.</small>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Full Name</label>
                    <input type="text" class="form-control" id="fullname" name="fullname" value="<?php if (isset($_POST['fullname'])) echo $_POST['fullname']; ?>" aria-describedby="nameHelp" placeholder="e.g Mike Edward" required />
                    <small id="nameHelp" class="form-text text-muted">We'll never share your name with anyone else.</small>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>" placeholder="Email address" required />
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" id="password" name="password" value="<?php if (isset($_POST['password'])) echo $_POST['password']; ?>" placeholder="Password" required />
                </div>
                <button type="submit" name="submit" class="btn btn-primary w-100 custom_bg py-3" style="border: none;">Sign up</button>
            </form>
            <div class="text-center mt-3"><small>Already have an account?</small> <a href="./" style="color: #011627; font-size: 16px; font-weight: 300; text-decoration: none;">LOGIN NOW</a></div>
        </div>
    </div>
</div>

<?php require_once("./includes/scripts.php") ?>