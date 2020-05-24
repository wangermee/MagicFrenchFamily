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
if (isset($_POST["label"])) {
    $label = verifyInput($_POST["label"]);
    $id = verifyInput($_POST["id"]);
    $checked = verifyInput($_POST["checked"]);

    if (strlen($label)==0) {//test si champ label est vide
        $isSuccess=false;
        $arr = array("msg"=>"need label","error"=>true);
        echo(json_encode($arr));
        return;
    }

    if (strlen($id)==0) {//test si champ id est vide//
        $isSuccess=false;
        $arr = array("msg"=>"invalid action","error"=>true);
        echo(json_encode($arr));
        return;
    }

    if (strlen($checked)==0) {//test si champ checkbox est vide//
        $isSuccess=false;
        $arr = array("msg"=>"invalid action","error"=>true);
        echo(json_encode($arr));
        return;
    }
  
    /* SI CREATION ON TEST SI DOUBLON DANS BDD */
    
    $query= $pdo->prepare('SELECT label FROM category WHERE label=:label');
    $query->execute(["label"=>$label]);
    $inArray = $query->fetchall(PDO::FETCH_ASSOC);

    if (count($inArray)!=0 && $id==0 ) {
        $isSuccess=false;
        $arr = array("msg"=>"invalid action, label already created","error"=>true);
        echo(json_encode($arr));
        return;
    }
   

    /* AJOUT / MODIFICATION */
    if ($id==0) {

        /* AJOUT A LA BDD */
        $query = $pdo->prepare('INSERT INTO category (label,play_format) VALUES (:label, :play_format)');
        $query->execute(["label"=>$label, "play_format"=>$checked]);

    }else{

        /* UPDATE DE LA BDD */
        $query = $pdo->prepare('UPDATE category SET label=:label, play_format=:play_format WHERE id=:id');
        $query->execute(["label"=>$label, "play_format"=>$checked, "id"=>$id]);   
    }


    /* MESSAGE DE FIN */
    if ($isSuccess=true) {
        $arr = array("msg"=>"action completed with success","error"=>false);
        echo(json_encode($arr));
        return;
    }
 
};