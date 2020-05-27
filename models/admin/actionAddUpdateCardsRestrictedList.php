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
if (isset($_POST["name"])) {
    $name = verifyInput($_POST["name"]);
    $categorie = verifyInput($_POST["categorie"]);

    if (strlen($name)==0) {//test si champ name est vide
        $isSuccess=false;
        $arr = array("msg"=>"need name","error"=>true);
        echo(json_encode($arr));
        return;
    }

    
    if ($categorie==0) {//test si champ categorie est a 0//
        $isSuccess=false;
        $arr = array("msg"=>"select a categorie","error"=>true);
        echo(json_encode($arr));
        return;
    }

    /* MODIFICATION */
    if (isset($_POST["id"]) && $_POST["id"]>0) {
        $id=verifyInput($_POST["id"]);
 
        $query= $pdo->prepare('UPDATE restricted_list SET name=:name, id_category=:categorie WHERE id=:id');
        $query->execute(["name"=>$name, "categorie"=>$categorie, "id"=>$id]);

        $arr = array("msg"=>"action completed with success","error"=>false);
        echo(json_encode($arr));
        return;
    }



    /* CREATION */
    /* TEST SI DOUBLON DANS BDD */
    $src=$_FILES["file"]["name"];
    $query= $pdo->prepare('SELECT src FROM restricted_list  WHERE src=:src');
    $query->execute(["src"=>$src]);
    $inArray = $query->fetchall(PDO::FETCH_ASSOC);

    if (count($inArray)!=0) {
        $isSuccess=false;
        $arr = array("msg"=>"invalid action, card already added","error"=>true);
        echo(json_encode($arr));
        return;
    }
    
    
    if (isset($_FILES["file"])) {
        //verifivation securite
        $file = $_FILES["file"];
        if($file["error"] != 0){ // j'ai un fichier à uploder dans mon tmp
            $isSuccess=false;
            $arr=array("msg"=>"invalid action, select a file","error"=>true);
            echo(json_encode($arr));
            return;
        }
        $sizeFile = $file["size"];//verification taille
        if($sizeFile > 3 * 1024 * 1024){
            $isSuccess=false;
            $arr=array("msg"=>"invalid action, file size max 5Mo","error"=>true);
            echo(json_encode($arr));
            return;
        }
        
        // on verifie le type de fichier
        $typeFile = mime_content_type($file["tmp_name"]);
        if (!strstr($typeFile, 'jpg') && !strstr($typeFile, 'jpeg') && !strstr($typeFile, 'png')  && !strstr($typeFile, 'bmp') && !strstr($typeFile, 'gif')) {
            $isSuccess=false;
            $arr=array("msg"=>"invalid action, selected file is not a image","error"=>true);
            echo(json_encode($arr));
            return;
        }
   
    }
    /* AJOUT */

    $uploaddir = "../../uploadFile/restrictedList/";
    $uploadfileName=basename($_FILES["file"]["name"]);//on permet d ecraser une image si elle a le meme nom 
    $uploadfile = $uploaddir.$uploadfileName;


    if (move_uploaded_file($_FILES["file"]["tmp_name"], $uploadfile)) {
        $fileName=$_FILES["file"]["name"];
        $query = $pdo->prepare('INSERT INTO restricted_list (name, src, id_category) VALUES (:name, :src, :id_category) ');
        $query->execute(["name"=>$name,"src"=>$uploadfileName,"id_category"=>$categorie]);

        if ($isSuccess) {
            $arr = array("msg"=>"action completed with success","error"=>false);
            echo(json_encode($arr));
            return;
        }else{
            $arr = array("msg"=>"error, action aborted","error"=>false);
            echo(json_encode($arr));
            return;
        }
    }
 
};