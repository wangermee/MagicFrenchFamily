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
    /* ON VERIFIE SI LA FOREIGN KEY EST DEJA UTILISEE */
    $query = $pdo->prepare('SELECT title FROM articles WHERE id_category=:id');
    $query->execute(["id"=>$id]); 
    $listArticles = $query->fetchall(PDO::FETCH_ASSOC);

    $query = $pdo->prepare('SELECT name FROM restricted_list WHERE id_category=:id');
    $query->execute(["id"=>$id]); 
    $listRestricted = $query->fetchall(PDO::FETCH_ASSOC);

    $query = $pdo->prepare('SELECT reply FROM comments WHERE id_category=:id');
    $query->execute(["id"=>$id]); 
    $listComments = $query->fetchall(PDO::FETCH_ASSOC);

    if (count($listArticles)>0) {
        $isSuccess=false;
        $arr = array("msg"=>"invalid action, this category is already used. Delete articles using this categorie","error"=>true);
        echo(json_encode($arr));
        return;
    }

    if (count($listRestricted)>0) {
        $isSuccess=false;
        $arr = array("msg"=>"invalid action, this category is already used. Delete restricted list using this categorie","error"=>true);
        echo(json_encode($arr));
        return;
    }

    if (count($listComments)>0) {
        $isSuccess=false;
        $arr = array("msg"=>"invalid action, this category is already used. Delete comments using this categorie","error"=>true);
        echo(json_encode($arr));
        return;
    }



    /* UPDATE DE LA BDD */
    $query = $pdo->prepare('DELETE FROM category WHERE id=:id');
    $query->execute(["id"=>$id]);  
}else{
    $isSuccess=false;
    $arr = array("msg"=>"invalid action","error"=>true);
    echo(json_encode($arr));
    return;
}

/* MESSAGE DE FIN */
if ($isSuccess) {
    $arr = array("msg"=>"action completed with success","error"=>false);
    echo(json_encode($arr));
    return;
}else{
    $arr = array("msg"=>"error, action aborted","error"=>false);
    echo(json_encode($arr));
    return;
}

    
