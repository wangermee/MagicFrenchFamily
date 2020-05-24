<?php
require ("models/dbConnect/dbConnect.php");

session_start();

if (!isset($_SESSION["user"]) || isset($_SESSION["user"])&& $_SESSION["user"]["admin"]!=1) { 
    header("Location:home");
    exite();
}


if (isset($_GET["id"])) {
    $query= $pdo->prepare('SELECT id, reply FROM comments WHERE id=:id');
    $query->execute(["id"=>$_GET["id"]]);
    $comment = $query->fetch(PDO::FETCH_ASSOC);
}


require "views/dashboard/UpdateComments/UpdateComments.phtml";
$title="Magic French Family/update comments";
$js="assets/js/scriptUpdateComments.js";
require "views/dashboard/dashboardTemplate.phtml";