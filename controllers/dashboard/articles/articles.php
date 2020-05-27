<?php


if (!isset($_SESSION["user"]) || isset($_SESSION["user"])&& $_SESSION["user"]["admin"]!=1) { 
    header("Location:home");
    exite();
}


$query= $pdo->prepare('SELECT articles.id AS id, title, content, id_category, id_users, name_img, src_img, DATE_FORMAT(creation_date, "%D %b %Y") AS creation_date, articles.state AS state, category.label, users.user_name   FROM articles INNER JOIN category ON category.id=articles.id_category INNER JOIN users ON users.id=articles.id_users ');
$query->execute();
$listArticles = $query->fetchall(PDO::FETCH_ASSOC);


/* DECODE LE CODE HTML DU CONTENU */
for ($i=0; $i < count($listArticles) ; $i++) { 
    $listArticles[$i]["content"]=html_entity_decode($listArticles[$i]["content"]);
}


require "views/dashboard/articles/articles.phtml";
$title="Magic French Family/ dashboard articles";
$js="assets/js/scriptArticles.js";
require "views/dashboard/dashboardTemplate.phtml";