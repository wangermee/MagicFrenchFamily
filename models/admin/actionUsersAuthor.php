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

    $query = $pdo -> prepare('SELECT author FROM users WHERE id= :id');
    $query->execute(["id"=>$id]);
    $user = $query -> fetch(PDO::FETCH_ASSOC);

    if ($user["author"]==0) {
        $query= $pdo->prepare('UPDATE users SET author="1" WHERE id= :id');
        $query->execute(["id"=>$id]);
    }else{
        $query= $pdo->prepare('UPDATE users SET author="0" WHERE id= :id');
        $query->execute(["id"=>$id]);
    }

}

header ("Location:../../users");

 
