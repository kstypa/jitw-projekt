<?php
session_start();
mysql_connect("localhost","root","");
mysql_query("SET NAMES utf8");
mysql_query("SET CHARACTER_SET utf8_unicode_ci");
mysql_select_db("testlog");
?>
