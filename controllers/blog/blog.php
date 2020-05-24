<?php
require ("models/dbConnect/dbConnect.php");
session_start();

$query= $pdo->prepare('SELECT articles.id AS id, title, content, id_category, id_users, name_img, src_img, DATE_FORMAT(creation_date, "%D %b %Y") AS creation_date, articles.state AS state, category.label, users.user_name   FROM articles INNER JOIN category ON category.id=articles.id_category INNER JOIN users ON users.id=articles.id_users WHERE articles.state=0 ');
$query->execute();
$listArticles = $query->fetchall(PDO::FETCH_ASSOC);


require "views/blog/blog.phtml";
$title="Magic French Family/ blog";
$path="blog";
require "views/template.phtml";
