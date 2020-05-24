<?php
require ("../dbConnect/dbConnect.php");
header("Content-Type: application/json");

/* FONCTION PROTECTION FAILLE XSS  */ 
function verifyInput ($var){
    $var = trim($var);
    $var = stripslashes($var);
    $var = htmlspecialchars($var);
    return $var;
}

if (isset($_GET["id"])) {
    $id= verifyInput($_GET["id"]);

    $query = $pdo -> prepare('SELECT state FROM restricted_list WHERE id= :id');
    $query->execute(["id"=>$id]);
    $categorie = $query -> fetch(PDO::FETCH_ASSOC);

    if ($categorie["state"]==0) {
        $query= $pdo->prepare('UPDATE restricted_list SET state="1" WHERE id= :id');
        $query->execute(["id"=>$id]);
    }else{
        $query= $pdo->prepare('UPDATE restricted_list SET state="0" WHERE id= :id');
        $query->execute(["id"=>$id]);
    }

}

header ("Location:../../restrictedList");

 
