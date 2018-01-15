<?php
session_start();
mysql_connect("localhost","root","");
mysql_query("SET NAMES utf8");
mysql_query("SET CHARACTER_SET utf8_unicode_ci");
mysql_select_db("testlog");
if (isset($_SESSION['loggedin'])) {
    if ($_SESSION['loggedin']) {
        $user_result = mysql_query("SELECT `id` from `users` WHERE `login` = '".$_SESSION['login']."' limit 1");
        $user_id = mysql_fetch_assoc($user_result);
        $uid = $user_id['id'];
        $login = $_SESSION['login'];
    }
}

function redirect($url, $statusCode = 303) {
   header('Location: ' . $url, true, $statusCode);
   die();
}
?>
