<?php
require ("dbConnect/dbConnect.php");
header("Content-Type: application/json");

/* FONCTION PROTECTION FAILLE XSS  */ 
function verifyInput ($var){
    $var = trim($var);
    $var = stripslashes($var);
    $var = htmlspecialchars($var);
    return $var;
}

if ($_POST["reply"]) {

    $reply=verifyInput($_POST["reply"]);
    $user=verifyInput($_POST["user"]);
    $articleId=verifyInput($_POST["articleId"]);
    $categorie=verifyInput($_POST["categorie"]);
   
    if (strlen($reply)==0) {

        $arr = array("msg"=>"please, write a comment","error"=>true);
        echo(json_encode($arr));
        return;
    }

    if (strlen($user)==0 || strlen($articleId)==0 || strlen($categorie)==0) {

        $arr = array("msg"=>"invalid action","error"=>true);
        echo(json_encode($arr));
        return;
    }

    /* AJOUT A LA DB */

    $query = $pdo->prepare('INSERT INTO comments (reply, id_users, id_articles, id_category) VALUES (:reply, :id_users, :id_articles, :id_category )');
    $query->execute(["reply"=>$reply, "id_users"=>$user, "id_articles"=>$articleId, "id_category"=>$categorie ]);

    $arr = array("msg"=>"action completed","error"=>false);
    echo(json_encode($arr));
    return;

}else{
    $arr = array("msg"=>"please, write a comment","error"=>true);
    echo(json_encode($arr));
    return;
}















 



    






