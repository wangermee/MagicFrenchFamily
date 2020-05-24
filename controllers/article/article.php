<?php
require ("models/dbConnect/dbConnect.php");
session_start();

$id=$_GET["id"];
/* VERIFIVATION SI ID EXISTE */
$query= $pdo->prepare('SELECT id FROM articles WHERE id=:id AND state=0');
$query->execute(["id"=>$id]);
$articleID = $query->fetchall(PDO::FETCH_ASSOC);

if(count($articleID) !=0){
    
    /* RECUPERATION DE L ARTICLE SELECTIONNE */
    $query= $pdo->prepare('SELECT articles.id AS id, title, content, id_category, id_users, name_img, src_img, DATE_FORMAT(creation_date, "%D %b %Y") AS creation_date, articles.state AS state, category.label, users.user_name   FROM articles INNER JOIN category ON category.id=articles.id_category INNER JOIN users ON users.id=articles.id_users WHERE articles.id=:id AND articles.state=0');
    $query->execute(["id"=>$id]);
    $article = $query->fetch(PDO::FETCH_ASSOC);

    /* RECUPERATION DES COMMENTAIRES  */
    $query= $pdo->prepare('SELECT comments.id AS id, DATE_FORMAT(post_date, "%D %b %Y") AS post_date, reply, users.user_name FROM comments INNER JOIN users ON comments.id_users=users.id WHERE id_articles=:id AND state = 0');
    $query->execute(["id"=>$id]);
    $commentsList = $query->fetchall(PDO::FETCH_ASSOC);
    $nbrComments=count($commentsList);

}else{
    /* REDIRECTION SI ID MODIFIE DANS URL ET INEXISTANT */
    header("Location:blog");
    exit();

}



require "views/article/article.phtml";
$title="Magic French Family/ article";
$js="assets/js/scriptArticle.js";
$path="article&id=$id";
require "views/template.phtml";