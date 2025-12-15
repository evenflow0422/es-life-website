<?php
session_start();
require_once 'User.php';
User::logout();
header('Location: login.php?logout=1');
exit();
?>