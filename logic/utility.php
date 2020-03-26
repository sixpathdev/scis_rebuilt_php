<?php

date_default_timezone_set('Africa/Lagos');

session_start();
// error_reporting(0);
// ini_set('display_errors', 0);

if (isset($_SESSION["user_id"])) {
    $user_id = $_SESSION["user_id"];
}

// require_once(realpath(dirname(__FILE__)) . '/MysqliDb.php');
// require_once(realpath(dirname(__FILE__)) . '/db.php');
// require_once(realpath(dirname(__FILE__)) . '/profile.php');
require_once("logic/MysqliDb.php");
require_once("logic/db.php");
include_once("logic/account/profile.php");

try {
    $db = new MysqliDb($host, $dbusername, $dbpassword, $database);
    if (!$db) die("Database error");
    $db->setTrace(true);
    $db->JsonBuilder()->rawQuery("SHOW TABLES");
} catch (exception $e) {
    output_response("error", "Database connection failed", null);
}

function output_response($state, $message, $data)
{
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    $state = $state == strtolower("error") ? 201 : 200;
    $response = array("status" => $state, "message" => $message, "data" => $data);
    http_response_code($state);
    echo json_encode($response);
}

// GETRESPONSE EMAIL POSTER
function post_getresponse($name, $email, $api_key = null, $campaign_id = null)
{
    if ($api_key == null && $campaign_id == null) {
        $campaign_id = "yv7uX";
        $api_key = "xf92cvd5ct7o9oao7tst3rbem58jrm9i";
    }
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.getresponse.com/v3/contacts",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 1300,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "{\r\n\"name\": \"$name\",\r\n\"campaign\": {\r\n\"campaignId\": \"$campaign_id\"\r\n},\r\n\"email\": \"$email\"\r\n}",
        CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache",
            "content-type: application/json",
            "x-auth-token: api-key " . $api_key
        ),
    ));
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
}

function refineOutput($value)
{
    if (isset($value) && !empty($value)) {
        return $value;
    } else {
        return "N/A";
    }
}

function validateLoginFormData($email, $password)
{
    if (empty($email) || empty($password)) {
        $_SESSION["error"] =  "Required fields must not be empty";
        exit();
    } elseif (strlen($password) < 4) {
        $_SESSION["error"] = "Password too short";
        exit();
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION["error"] = "Invalid email address";
        exit();
    } else {
        $email = trim($email);
    }
}

function validateRegisterFormData($matricNo, $name, $email, $password)
{
    if (empty($matricNo) || strlen($matricNo) != 19) {
        $_SESSION["error"] = "Invalid matric number";
        exit();
    }

    if (empty($name) || empty($email) || empty($password)) {
        $_SESSION["error"] = "Required fields must not be empty";
        exit();
    }
    if (strlen($password) < 4) {
        $_SESSION["error"] = "Password too short";
        exit();
    }
    if (strlen($name) < 3) {
        $_SESSION["error"] = "Name seems to be unusual";
        exit();
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION["error"] = "Invalid email address";
        exit();
    }
}

// function SMTPMail($email, $subject, $message)
// {
//     try {

//         $url = 'https://api.sendgrid.com/';
//         $user = 'mavenharry';
//         $pass = 'Themaven7@';
//         $params = array(
//             'api_user'  => $user,
//             'api_key'   => $pass,
//             'to'        => $email,
//             'subject'   => $subject,
//             'html'      => $message,
//             'from'      => 'Vidimpact',
//         );
//         $request =  $url . 'api/mail.send.json';
//         // Generate curl request
//         $session = curl_init($request);
//         curl_setopt($session, CURLOPT_POST, true);
//         curl_setopt($session, CURLOPT_POSTFIELDS, $params);
//         curl_setopt($session, CURLOPT_HEADER, false);
//         curl_setopt($session, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
//         curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
//         $response = curl_exec($session);
//         curl_close($session);
//         // print_r($response);
//     } catch (Exception $e) {
//         echo "Message could not be sent.";
//     }
// }

// function updateDb($value, $table, $column, $where, $where_value)
// {
//     global $db;
//     $result = $db->JsonBuilder()->rawQuery("UPDATE $table SET $column = ? WHERE $where = ?", array($value, $where_value));
// }

function ifValueExists($value, $table, $column)
{
    global $db;
    $existResp = $db->JsonBuilder()->rawQuery("SELECT * FROM $table WHERE $column = ?", array($value));
    $response = json_decode($existResp, true);
    if (!empty($response)) {
        return true;
    } else {
        return false;
    }
}


// CUSTOM CURL
// function processUrl($url)
// {

//     $ch = curl_init($url);
//     curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
//     curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: close'));
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//     curl_setopt($ch, CURLOPT_TIMEOUT, 60);

//     $data = curl_exec($ch);
//     $err = curl_error($ch);

//     curl_close($ch);

//     if ($err) {
//         output_response("error", $err, null);
//     } else {
//         return $data;
//     }
// }

//GET HOST
// function getHost($url)
// {
//     $url = preg_replace("/[\-]/", "1_", $url);
//     $r  = "^(?:(?P<scheme>\w+)://)?";
//     $r .= "(?:(?P<login>\w+):(?P<pass>\w+)@)?";
//     $r .= "(?P<host>(?:(?P<subdomain>[\w\.]+)\.)?" . "(?P<domain>\w+\.(?P<extension>\w+)))";
//     $r .= "(?::(?P<port>\d+))?";
//     $r .= "(?P<path>[\w/]*/(?P<file>\w+(?:\.\w+)?)?)?";
//     $r .= "(?:\?(?P<arg>[\w=&]+))?";
//     $r .= "(?:#(?P<anchor>\w+))?";
//     $r = "!$r!";
//     preg_match($r, $url, $out);
//     return $url = str_replace("1_", "-", str_ireplace('www.', '', $out["host"]));
// }

// GET TIME AGO
function timeAgo($time_ago)
{
    $time_ago = strtotime($time_ago);
    $cur_time = time();
    $time_elapsed = $cur_time - $time_ago;
    $seconds = $time_elapsed;
    $minutes = round($time_elapsed / 60);
    $hours = round($time_elapsed / 3600);
    $days = round($time_elapsed / 86400);
    $weeks = round($time_elapsed / 604800);
    $months = round($time_elapsed / 2600640);
    $years = round($time_elapsed / 31207680);
    // Seconds
    if ($seconds <= 60) {
        return "just now";
    }
    //Minutes
    else if ($minutes <= 60) {
        if ($minutes == 1) {
            return "one minute ago";
        } else {
            return "$minutes minutes ago";
        }
    }
    //Hours
    else if ($hours <= 24) {
        if ($hours == 1) {
            return "an hour ago";
        } else {
            return "$hours hrs ago";
        }
    }
    //Days
    else if ($days <= 7) {
        if ($days == 1) {
            return "yesterday";
        } else {
            return "$days days ago";
        }
    }
    //Weeks
    else if ($weeks <= 4.3) {
        if ($weeks == 1) {
            return "a week ago";
        } else {
            return "$weeks weeks ago";
        }
    }
    //Months
    else if ($months <= 12) {
        if ($months == 1) {
            return "a month ago";
        } else {
            return "$months months ago";
        }
    }
    //Years
    else {
        if ($years == 1) {
            return "one year ago";
        } else {
            return "$years years ago";
        }
    }
}


// function getBookmarks($user_id)
// {
//     global $db;
//     return $db->JsonBuilder()->rawQuery("SELECT * FROM bookmarks WHERE user_id = ?", array($user_id));
// }

// function removeBookmark($title)
// {
//     global $db;
//     return $db->JsonBuilder()->rawQuery("DELETE FROM bookmarks WHERE title = ?", array($title));
// }

// function genCode()
// {
//     $characters = 'ab2cdefghi098jklmnop3qrstuv1wxyzABC4DEFG3HIJK3LMNOPQ44RSTUVW4623XYZ';
//     $randomString = '';
//     for ($i = 0; $i < 20; $i++) {
//         $index = rand(0, strlen($characters) - 1);
//         $randomString .= $characters[$index];
//     }
//     return substr($randomString, 6, 6);
// }

// function generateLink($oldlink)
// {
//     $code = genCode();
//     $oldlink = trim($oldlink);
//     $newlink = 'http://localhost:8080/contentplus/link.php?code=' . $code;
//     // $newlink = 'http://contentplus.babbage.in/link.php?code=' . $code;
//     // $newlink = 'http://content.plus/link.php?code=' . $code;

//     global $db;
//     $data = array(
//         "oldlink" => $oldlink,
//         "code" => $code,
//         "newlink" => $newlink
//     );
//     if (!ifValueExists($oldlink, 'links', 'oldlink')) {
//         $db->insert('links', $data);
//         return $newlink;
//     }
//     return $newlink;
// }

// function fetchLink($code)
// {
//     global $db;
//     $result = $db->JsonBuilder()->rawQuery("SELECT oldlink FROM links WHERE code = ?", array($code));
//     $result = json_decode($result);
//     return $result[0]->oldlink;
// }


