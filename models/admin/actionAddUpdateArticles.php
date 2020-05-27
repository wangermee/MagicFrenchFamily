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
if (isset($_POST["title"])) {
    $title = verifyInput($_POST["title"]);
    $content=htmlentities($_POST["content"], ENT_QUOTES); //transforme le code HTML avant insertion dans base de donnée
    $categorie = verifyInput($_POST["categorie"]);
    $author = verifyInput($_POST["author"]);
    $id = verifyInput($_POST["id"]);
    $imageName = verifyInput($_POST["imageName"]);


    if (strlen($title)==0) {//test si champ title est vide
        $isSuccess=false;
        $arr = array("msg"=>"need title","error"=>true);
        echo(json_encode($arr));
        return;
    }

    if ($categorie==0) {//test si champ categorie est a 0//
        $isSuccess=false;
        $arr = array("msg"=>"select a categorie","error"=>true);
        echo(json_encode($arr));
        return;
    }

        
    if ($author==0) {//test si champ author est a 0
        $isSuccess=false;
        $arr = array("msg"=>"need author","error"=>true);
        echo(json_encode($arr));
        return;
    }

    

    if (strlen($content)==0) {//test si champ content est vide
        $isSuccess=false;
        $arr = array("msg"=>"need content","error"=>true);
        echo(json_encode($arr));
        return;
    }

   
    /* TEST SI CREATION ET DOUBLON DANS BDD */
    /* TEST TITRE */
    $query= $pdo->prepare('SELECT title FROM articles  WHERE title=:title');
    $query->execute(["title"=>$title]);
    $inArray = $query->fetchall(PDO::FETCH_ASSOC);

    if (count($inArray)!=0 && $id=="0") {
        $isSuccess=false;
        $arr = array("msg"=>"invalid action, title already created","error"=>true);
        echo(json_encode($arr));
        return;
    }

    /* TEST CONTENU */
    $query= $pdo->prepare('SELECT content FROM articles  WHERE content=:content');
    $query->execute(["content"=>$content]);
    $inArray = $query->fetchall(PDO::FETCH_ASSOC);

    if (count($inArray)!=0 && $id=="0") {
        $isSuccess=false;
        $arr = array("msg"=>"invalid action, article content already created","error"=>true);
        echo(json_encode($arr));
        return;
    }
    
    
    

    /* CREATION D UN ARTICLE */
    if (isset($_FILES["file"]) && $id=="0") {
        //verifivation securite
        $file = $_FILES["file"];
        
                $sizeFile = $file["size"];//verification taille
        if($sizeFile > 3 * 1024 * 1024){
            $isSuccess=false;
            $arr=array("msg"=>"invalid action, file size max 5Mo","error"=>true);
            echo(json_encode($arr));
            return;
        }
     
        if($file["error"] != 0 ){ // pas de fichier à uploder 
            $isSuccess=false;
            $arr=array("msg"=>"invalid action, select a file","error"=>true);
            echo(json_encode($arr));
            return;
        }

        if (strlen($imageName)==0) {//si il y a une img on test si elle a un nom//
            $isSuccess=false;
            $arr = array("msg"=>"need a name for the image","error"=>true);
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
    


        /* PROCEDURE D AJOUT */

        $uploaddir = "../../uploadFile/articles/";
        $uploadfileName=date("h-i-s").".". basename($_FILES["file"]["name"]);//on ne permet pas d ecraser une image si elle a le meme nom 
        $uploadfile = $uploaddir.$uploadfileName;

        
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $uploadfile)) {
            
            $query = $pdo->prepare('INSERT INTO articles (title, content, id_category, id_users, name_img, src_img) VALUES (:title, :content, :id_category, :id_users, :name_img, :src_img ) ');
            $query->execute(["title"=>$title, "content"=>$content, "id_category"=>$categorie, "id_users"=>$author, "name_img"=>$imageName,"src_img"=>$uploadfileName]);

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

    }else{/* MODIFICATION D UN ARTICLE */
        $file = $_FILES["file"];
        if ($file["size"]>0) {//modification d article avec upload d image
            $srcImg = verifyInput($_POST["srcImg"]);//recuperation de l image actuel
            
            unlink("../../uploadFile/articles/$srcImg");// supression de l image actuel

            if($file["error"] != 0 ){ // pas de fichier à uploder 
                $isSuccess=false;
                $arr=array("msg"=>"invalid action, select a file","error"=>true);
                echo(json_encode($arr));
                return;
            }
    
            if (strlen($imageName)==0) {//si il y a une img on test si elle a un nom//
                $isSuccess=false;
                $arr = array("msg"=>"need a name for the image","error"=>true);
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
        
    
    
            /* PROCEDURE DE MODIFICATION */
    
            $uploaddir = "../../uploadFile/articles/";
            $uploadfileName=date("h-i-s").".". basename($_FILES["file"]["name"]);//on ne permet pas d ecraser une image si elle a le meme nom 
            $uploadfile = $uploaddir.$uploadfileName;
    
            
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $uploadfile)) {
                
                $query = $pdo->prepare('UPDATE articles SET title=:title, content=:content, id_category=:id_category, id_users=:id_users, name_img=:name_img, src_img=:src_img WHERE id=:id ');
                $query->execute(["title"=>$title, "content"=>$content, "id_category"=>$categorie, "id_users"=>$author, "name_img"=>$imageName,"src_img"=>$uploadfileName, "id"=>$id]);
    
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


        }else{//modification d article sans upload d image
            $query = $pdo->prepare('UPDATE articles SET title=:title, content=:content, id_category=:id_category, id_users=:id_users, name_img=:name_img WHERE id=:id');
            $query->execute(["title"=>$title, "content"=>$content, "id_category"=>$categorie, "id_users"=>$author, "name_img"=>$imageName, "id"=>$id]);
        
            $arr = array("msg"=>"action completed with success","error"=>false);
            echo(json_encode($arr));
            return;
        }

    }
 
};