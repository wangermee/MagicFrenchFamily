<?php
require ("models/dbConnect/dbConnect.php");

session_start();

if (!isset($_SESSION["user"]) || isset($_SESSION["user"])&& $_SESSION["user"]["admin"]!=1) { 
    header("Location:home");
    exite();
}


$query= $pdo->prepare('SELECT comments.id AS id, DATE_FORMAT(post_date, "%D %b %Y") AS post_date, reply, comments.state AS state, users.user_name, articles.title, articles.id AS articles_id  FROM comments INNER JOIN users ON comments.id_users=users.id INNER JOIN articles ON articles.id=comments.id_articles');
$query->execute();
$commentsList = $query->fetchall(PDO::FETCH_ASSOC);

require "views/dashboard/comments/comments.phtml";
$title="Magic French Family/ dashboard comments";
$js="assets/js/scriptComments.js";
require "views/dashboard/dashboardTemplate.phtml";