<?php

if (!isset($_SESSION["user"]) || isset($_SESSION["user"])&& $_SESSION["user"]["admin"]!=1) { 
    header("Location:home");
    exite();
}


/* CREATION DE LA LISTE DES CATEGORIES */
$query= $pdo->prepare('SELECT id, label  FROM category WHERE state=0');
$query->execute();
$listCategory = $query->fetchall(PDO::FETCH_ASSOC);

/* CREATION DE LA LISTE DES AUTHORS */
$query= $pdo->prepare('SELECT id, user_name  FROM users WHERE author=1 ');
$query->execute();
$listAuthors = $query->fetchall(PDO::FETCH_ASSOC);


if (isset($_GET["id"])) { //MODIFICATION
    $query= $pdo->prepare('SELECT articles.id AS id, title, content, id_category, id_users, name_img, src_img, category.label  FROM articles INNER JOIN category WHERE category.id=articles.id_category AND articles.id=:id');
    $query->execute(["id"=>$_GET["id"]]);
    $article = $query->fetch(PDO::FETCH_ASSOC);
    $titleH = "Update"; 
}else{ //CREATION
    $titleH = "Create";
    $article["id"]="0";
    $article["title"]="";
    $article["content"]="";
    $article["name_img"]="";
    
}


require "views/dashboard/addArticles/addArticles.phtml";
$title="Magic French Family/add articles";
$js="assets/js/scriptAddArticles.js";
require "views/dashboard/dashboardTemplate.phtml";