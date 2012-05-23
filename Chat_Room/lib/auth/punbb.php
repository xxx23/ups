<?PHP
///////////////////////////////////////////////////////////////
//
//        X7 Chat Version 2.0.4
//        Released June 16, 2006
//        Copyright (c) 2004-2006 By the X7 Group
//        Website: http://www.x7chat.com
//
//        This program is free software.  You may
//        modify and/or redistribute it under the
//        terms of the included license as written
//        and published by the X7 Group.
//
//        By using this software you agree to the
//        terms and conditions set forth in the
//        enclosed file "license.txt".  If you did
//        not recieve the file "license.txt" please
//        visit our website and obtain an official
//        copy of X7 Chat.
//
//        Removing this copyright and/or any other
//        X7 Group or X7 Chat copyright from any
//        of the files included in this distribution
//        is forbidden and doing so will terminate
//        your right to use this software.
//
////////////////////////////////////////////////////////////////EOH

// PunBB 1.2
// Written by Smartys, PunBB Developer
// Modified by E-Oreo, X7 Chat Developer

// This file holds data on authentication
$auth_ucookie = "X7C2U";
$auth_pcookie = "X7C2P";
$auth_register_link = "../register.php";
$auth_disable_guest = true;

// Get the PunBB Configuration File
require ("../config.php");

// Make a database connection to the PunBB database
$pun_db = new x7chat_db($db_host,$db_username,$db_password,$db_name);

// Authenticate the user against the PunBB database
if (isset($_COOKIE[$cookie_name])){
    $_COOKIE[$cookie_name] = stripslashes(str_replace('&quot;','"',$_COOKIE[$cookie_name]));
    list($cookie['user_id'], $cookie['password_hash']) = unserialize($_COOKIE[$cookie_name]);

if ($cookie['user_id'] > 1)
{
    // Check if there's a user with the user ID and password hash from the cookie
    $result = $pun_db->DoQuery('SELECT u.id, u.username, u.password FROM '.$db_prefix.'users AS u WHERE u.id='.intval($cookie['user_id']));
    $pun_user = $pun_db->Do_Fetch_Row($result);

    if (isset($pun_user[0])) // && md5($cookie_seed.$pun_user[2]) === $cookie['password_hash'])
    {
        @setcookie($auth_ucookie, $pun_user[1], time()+$x7c->settings['cookie_time'], $X7CHAT_CONFIG['COOKIE_PATH']);
        @setcookie($auth_pcookie, $cookie['password_hash'], time()+$x7c->settings['cookie_time'], $X7CHAT_CONFIG['COOKIE_PATH']);
        $_COOKIE[$auth_ucookie] = $pun_user[1];
        $_COOKIE[$auth_pcookie] = $cookie['password_hash'];
    }
}

}

function auth_encrypt($data)
{
    global $cookie_seed;
    if (function_exists('sha1'))    // Only in PHP 4.3.0+
        $data = sha1($data);
    else if (function_exists('mhash'))    // Only if Mhash library is loaded
        $data = bin2hex(mhash(MHASH_SHA1, $data));
    else
        $data = md5($data);

    if(isset($_POST['dologin']))
        return md5($cookie_seed.$data);
    else
        return $data;

}

function auth_getpass($auth_ucookie)
{
    global $pun_db, $db_prefix, $prefix, $txt, $g_default_settings, $x7c, $db, $cookie_seed;

    $query = $pun_db->DoQuery("SELECT password FROM {$db_prefix}users WHERE username='$_COOKIE[$auth_ucookie]'");
    $password = $pun_db->Do_Fetch_Row($query);
    // Check if they have an X7 Chat account
    if($password[0] != ""){
        $query = $db->DoQuery("SELECT * FROM {$prefix}users WHERE username='$_COOKIE[$auth_ucookie]'");
        $row = $db->Do_Fetch_Row($query);
        if($row[0] == ""){
            // Create an X7 Chat account for them.
            $time = time();
            $ip = $_SERVER['REMOTE_ADDR'];
            $db->DoQuery("INSERT INTO {$prefix}users (id,username,password,status,user_group,time,settings,hideemail,ip) VALUES('0','$_COOKIE[$auth_ucookie]','$password[0]','$txt[150]','{$x7c->settings['usergroup_default']}','$time','{$g_default_settings}','0','$ip')");
        }
    }
    return md5($cookie_seed.$password[0]);
}

function change_pass($user,$newpass)
{
    global $db_prefix, $pun_db;
    unset($_POST['dologin']);
    $newpass = auth_encrypt($newpass);
    $query = $pun_db->DoQuery("UPDATE {$db_prefix}users SET password='$newpass' WHERE username='$user'");
}
?>