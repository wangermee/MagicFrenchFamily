<?php

if (!isset($_SESSION["user"]) || isset($_SESSION["user"])&& $_SESSION["user"]["admin"]!=1) { 
    header("Location:home");
    exite();
}


/* CREATION DE LA LISTE DES CATEGORIES */
$query= $pdo->prepare('SELECT id, label  FROM category WHERE play_format = 1 AND state=0');
$query->execute();
$listCategory = $query->fetchall(PDO::FETCH_ASSOC);


if (isset($_GET["id"])) { //MODIFICATION
    $query= $pdo->prepare('SELECT restricted_list.id AS id, name, id_category, category.label  FROM restricted_list INNER JOIN category WHERE category.id=restricted_list.id_category AND restricted_list.id=:id');
    $query->execute(["id"=>$_GET["id"]]);
    $card = $query->fetch(PDO::FETCH_ASSOC);
    $titleH2 = "Update"; 
}else{ //CREATION
    $titleH2 = "Add";
    $card["id"]=0;
    $card["name"]="";
}






require "views/dashboard/addCardsRestrictedList/addCardsRestrictedList.phtml";
$title="Magic French Family/ dashboard add restrited cards";
$js="assets/js/scriptAddCardsRestricted.js";
require "views/dashboard/dashboardTemplate.phtml";