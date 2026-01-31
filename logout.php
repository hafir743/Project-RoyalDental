<?php
require_once 'includes/config.php';

$db = new Database();
$connection = $db->getConnection();
$user = new User($connection);
$user->logout();

header('Location: login.php');
exit;

