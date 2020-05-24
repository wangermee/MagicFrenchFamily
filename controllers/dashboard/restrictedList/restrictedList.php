<?php
require ("models/dbConnect/dbConnect.php");

session_start();

if (!isset($_SESSION["user"]) || isset($_SESSION["user"])&& $_SESSION["user"]["admin"]!=1) { 
    header("Location:home");
    exite();
}


$query= $pdo->prepare('SELECT restricted_list.id AS id, name ,src ,restricted_list.state AS state, id_category, category.label FROM restricted_list INNER JOIN category WHERE category.id=restricted_list.id_category ORDER BY category.label, name');
$query->execute();
$listRestrictedList = $query->fetchall(PDO::FETCH_ASSOC);


require "views/dashboard/restrictedList/restrictedList.phtml";
$title="Magic French Family/ dashboard restricted list";
$js="assets/js/scriptRestriectedList.js";
require "views/dashboard/dashboardTemplate.phtml";