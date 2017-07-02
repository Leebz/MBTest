<?php
error_reporting(E_ALL ^ E_WARNING);
error_reporting(E_ALL & ~E_NOTICE);
session_start();
if ($_SESSION['role']!=1 and $_SESSION['role']!=2) {
    echo "<script language=javascript>location.href='user_login.php';</script>";
    exit;
}
?>