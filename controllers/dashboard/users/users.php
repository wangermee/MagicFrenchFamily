<?php
require ("models/dbConnect/dbConnect.php");

session_start();

if (!isset($_SESSION["user"]) || isset($_SESSION["user"])&& $_SESSION["user"]["admin"]!=1) { 
    header("Location:home");
    exite();
}


$query= $pdo->prepare('SELECT id, user_name, email, author, admin  FROM users');
$query->execute();
$listUsers = $query->fetchall(PDO::FETCH_ASSOC);


require "views/dashboard/users/users.phtml";
$title="Magic French Family/ dashboard users";
$js="assets/js/scriptUsers.js";
require "views/dashboard/dashboardTemplate.phtml";