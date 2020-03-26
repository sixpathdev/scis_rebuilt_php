<?php

include('logic/utility.php');

function auth_forgot_password($email)
{
    global $db;
    $uniqueCode = mt_rand(100000, 999999);
    $emailExist = ifValueExists($email, "authentication", "auth_email");
    if ($emailExist === true) {
        $result = $db->JsonBuilder()->rawQuery("SELECT * FROM `authentication` WHERE auth_email = ?", array($email));
        $response = json_decode($result, true);
        updateDb(md5($uniqueCode), "authentication", "auth_password", "auth_email", $email);
        $password = $uniqueCode;
        $name = $response[0]["auth_name"];

        // SEND WELCOME EMAIL
        $subject = 'SlideKitty Password Recovery.';
        $message = "<!DOCTYPE html>
        <html>
        <body style='background-color: #38BABF; padding: 20px; font-family: font-size: 14px; line-height: 1.43; font-family: &quot;Helvetica Neue&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif;'>
        <div style='margin: 20px auto; background-color: #fff; box-shadow: 0px 20px 50px rgba(0,0,0,0.05);'>
                <table style='width: 100%;'>
                <tr>
                    <td style='background-color: #fff;'><img alt='' src='https://www.SlideKitty.com/images/logo.png ' style='width: 200px; margin-left:25px; padding: 0px'></td>
                    <h4></h4>
                </tr>
                </table>
                <div style='padding: 60px 70px; border-top: 1px solid rgba(0,0,0,0.05);'>
                <h1 style='margin-top: 0px; color:#8095A0'>Hello, " . ucwords($name) . "</h1>
                <div style='color: #8095A0; font-size: 14px;'>
                    <p>So sorry about your login issues. You are having trouble logging in to SlideKitty.com and have requested for password recovery. Use the value below as password together with this email address to login.</p>
                </div>
                <h2 style='font-size: 5em; color: #8095A0;'>" . $password . "</h2>
                <h4 style='margin-bottom: 10px; color:#8095A0'>Need Help?</h4>
                <div style='color: #8095A0; font-size: 12px;'>
                    <p>If you have any questions you can simply reply to this email or find our contact information below. You can also contact us at <a href='#' style='text-decoration: underline; color: #8095A0;'>hello@SlideKitty.com</a></p>
                </div>
                </div>
                <div style='background-color: #3CD3D9; padding: 40px; text-align: center;'>
                <div style='color: #fff; font-size: 20px; margin-bottom: 20px; padding: 0px 250px;'>You are receiving this email because you tried changing your password for SlideKitty.com. All emails are sent from SlideKitty.com.</div>
                <div style='margin-top: 20px; padding-top: 20px; border-top: 1px solid rgba(0,0,0,0.05);'>
                    <div style='color: #fff; font-size: 15px;'>Copyright <?php echo date('Y') ?> SlideKitty.com. All rights reserved.</div>
                </div>
                </div>
        </div>
        </body>
        </html>";
        SMTPMail($email, $subject, $message);
        return true;
    } else {
        return false;
    }
}
