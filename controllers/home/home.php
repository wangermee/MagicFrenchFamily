<?php

$query= $pdo->prepare('SELECT name, src FROM restricted_list WHERE state=0 AND id_category=10 ORDER BY name');
$query->execute();
$restrictedListOS93 = $query->fetchall(PDO::FETCH_ASSOC);

$query= $pdo->prepare('SELECT name, src FROM restricted_list WHERE state=0 AND id_category=11 ORDER BY name  ');
$query->execute();
$restrictedListOS95 = $query->fetchall(PDO::FETCH_ASSOC);

$query= $pdo->prepare('SELECT name, src FROM restricted_list WHERE state=0 AND id_category=12 ORDER BY name  ');
$query->execute();
$restrictedListPremodern = $query->fetchall(PDO::FETCH_ASSOC);



require "views/home/home.phtml";
$title="Magic French Family/ home";
$path="home";
require "views/template.phtml";
