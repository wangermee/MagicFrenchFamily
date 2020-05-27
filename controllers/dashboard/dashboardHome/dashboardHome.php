<?php

if (!isset($_SESSION["user"]) || isset($_SESSION["user"])&& $_SESSION["user"]["admin"]!=1) { 
    header("Location:home");
    exite();
}


$query= $pdo->prepare('SELECT id FROM articles ');
$query->execute();
$listArticles = $query->fetchall(PDO::FETCH_ASSOC);
$nbrArticles = count($listArticles);

$query= $pdo->prepare('SELECT id FROM users ');
$query->execute();
$listUsers = $query->fetchall(PDO::FETCH_ASSOC);
$nbrUsers = count($listUsers);

$query= $pdo->prepare('SELECT id FROM comments ');
$query->execute();
$listComments = $query->fetchall(PDO::FETCH_ASSOC);
$nbrComments = count($listComments);

$query= $pdo->prepare('SELECT id FROM category ');
$query->execute();
$listCategory = $query->fetchall(PDO::FETCH_ASSOC);
$nbrCategory = count($listCategory);


require "views/dashboard/dashboardHome/dashboardHome.phtml";
$title="Magic French Family/ dashboard home";
require "views/dashboard/dashboardTemplate.phtml";