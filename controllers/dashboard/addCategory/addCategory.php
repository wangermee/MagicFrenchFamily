<?php
require ("models/dbConnect/dbConnect.php");

session_start();

if (!isset($_SESSION["user"]) || isset($_SESSION["user"])&& $_SESSION["user"]["admin"]!=1) { 
    header("Location:home");
    exite();
}


if (isset($_GET["id"])) {
    $query= $pdo->prepare('SELECT id, label, play_format FROM category WHERE id=:id');
    $query->execute(["id"=>$_GET["id"]]);
    $categorie = $query->fetch(PDO::FETCH_ASSOC);
    $titleH="Update";
}else{
    $categorie["id"] =0;
    $categorie["label"]="";
    $categorie["play_format"]=0;
    $titleH="Add";
}


require "views/dashboard/addCategory/addCategory.phtml";
$title="Magic French Family/add category";
$js="assets/js/scriptAddCategory.js";
require "views/dashboard/dashboardTemplate.phtml";