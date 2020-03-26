<?php

function auth_signup($matricNo, $name, $email, $password)
{
    validateRegisterFormData($matricNo, $name, $email, $password);

    global $db;
    $uniqueId = uniqid();
    $emailExist = ifValueExists($email, "authentication", "email");
    if ($emailExist == false) {
        $authData = array(
            "user_id" => $uniqueId,
            "matric_no" => $matricNo,
            "full_name" => $name,
            "email" => $email,
            "password" => md5(strtolower($password))
        );
        $db->insert('authentication', $authData);
        // $subject = 'ContentPlus - Your created account';
        // $message = 'Signup successful';
        // SMTPMail($email, $subject, $message);
        // post_getresponse($name, $email);
        return true;
    } else {
        $_SESSION["error"] = "Email already exists";
        return false;
    }
}
