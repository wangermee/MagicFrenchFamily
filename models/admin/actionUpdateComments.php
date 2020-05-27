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

$isSuccess=true;

/* RECUPERATION ET VERIFICATION DES CHAMPS DU FORM */ 
if (isset($_POST["reply"])) {
    $reply = verifyInput($_POST["reply"]);
    $id = verifyInput($_POST["id"]);


    if (strlen($reply)==0) {//test si champ label est vide
        $isSuccess=false;
        $arr = array("msg"=>"need content","error"=>true);
        echo(json_encode($arr));
        return;
    }

    if (strlen($id)==0) {//test si champ vide//
        $isSuccess=false;
        $arr = array("msg"=>"invalid action","error"=>true);
        echo(json_encode($arr));
        return;
    }

    /* UPDATE DE LA BDD */
    $query = $pdo->prepare('UPDATE comments SET reply=:reply WHERE id=:id');
    $query->execute(["reply"=>$reply, "id"=>$id]);   
 

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
 
};