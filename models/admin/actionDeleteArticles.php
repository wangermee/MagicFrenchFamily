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
$src = verifyInput($_GET["src"]);

if ($id>0) {
    /* ON VERIFIE SI LA FOREIGN KEY EST DEJA UTILISEE */
    $query = $pdo->prepare('SELECT reply FROM comments WHERE id_articles=:id');
    $query->execute(["id"=>$id]); 
    $listComments = $query->fetchall(PDO::FETCH_ASSOC);

    if (count($listComments)>0) {
        $isSuccess=false;
        $arr = array("msg"=>"invalid action, this article already have comments. Delete comments from this article","error"=>true);
        echo(json_encode($arr));
        return;
    }

}else{
    $isSuccess=false;
    $arr = array("msg"=>"invalid action","error"=>true);
    echo(json_encode($arr));
    return;
}

/* MESSAGE DE FIN */
if ($isSuccess) {

    /* SUPPRESSION DU FICHIER EN LOCAL */
    unlink("../../uploadFile/articles/$src");

    /* SUPPRESSION DE LA BDD */
    $query = $pdo->prepare('DELETE FROM articles WHERE id=:id');
    $query->execute(["id"=>$id]); 


    $arr = array("msg"=>"action completed with success","error"=>false);
    echo(json_encode($arr));
    return;
}else{
    $arr = array("msg"=>"error, action aborted","error"=>false);
    echo(json_encode($arr));
    return;
}

    
