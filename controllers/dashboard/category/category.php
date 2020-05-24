<?php
require "models/dbConnect/dbConnect.php";

session_start();

if (!isset($_SESSION["user"]) || isset($_SESSION["user"])&& $_SESSION["user"]["admin"]!=1) { 
    header("Location:home");
    exite();
}


$query= $pdo->prepare('SELECT id, label, state, play_format FROM category ORDER BY label');
$query->execute();
$listCategory = $query->fetchall(PDO::FETCH_ASSOC);



require "views/dashboard/category/category.phtml";
$js="assets/js/scriptCategory.js";
$title="Magic French Family/ dashboard category";
require "views/dashboard/dashboardTemplate.phtml";