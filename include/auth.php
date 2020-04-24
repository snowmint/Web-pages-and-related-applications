<?php
session_start();
$_SESSION['LoginID'] = 'i4010';
if (!isset($_SESSION['LoginID']) || empty($_SESSION['LoginID'])) {
    die('您未登入');
}
?>