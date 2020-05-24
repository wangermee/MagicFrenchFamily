<?php
require ("../dbConnect/dbConnect.php");
header("Content-Type: application/json");

$isSuccess=true;
/* FONCTION PROTECTION FAILLE XSS  */ 
function verifyInput ($var){
    $var = trim($var);
    $var = stripslashes($var);
    $var = htmlspecialchars($var);
    return $var;
}

/* RECUPERATION ET VERIFICATION */ 
$id = verifyInput($_GET["id"]);

if ($id>0) {
    /* UPDATE DE LA BDD */
    $query = $pdo->prepare('DELETE FROM comments WHERE id=:id');
    $query->execute(["id"=>$id]);  
}else{
    $isSuccess=false;
    $arr = array("msg"=>"invalid action","error"=>true);
    echo(json_encode($arr));
    return;
}

/* MESSAGE DE FIN */
if ($isSuccess == true) {
    $arr = array("msg"=>"action completed with success","error"=>false);
    echo(json_encode($arr));
    return;
}

    
