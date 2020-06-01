<?php
require ("dbConnect/dbConnect.php");
header("Content-Type: application/json");
session_start();



/* FONCTION PROTECTION FAILLE XSS  */ 
function verifyInput ($var){
    $var = trim($var);
    $var = stripslashes($var);
    $var = htmlspecialchars($var);
    return $var;
}

/* GESTION DES DEUX FORMULAIRES */
if ($_POST["action"] && $_POST["action"]== "register") {//creation de compte

    $userName=verifyInput($_POST["userName"]);
    $email=verifyInput($_POST["registerEmail"]);
    $verifyEmail=verifyInput($_POST["registerVerifyEmail"]);
    $password=verifyInput($_POST["registerPassword"]);
    $verifyPassword=verifyInput($_POST["registerVerifyPassword"]);

    if (strlen($userName)==0) {
        $isSuccess=false;
        $arr = array("msg"=>"need user name","error"=>true);
        echo(json_encode($arr));
        return;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !filter_var($verifyEmail, FILTER_VALIDATE_EMAIL) ) {
        $isSuccess=false;
        $arr = array("msg"=>"need email","error"=>true);
        echo(json_encode($arr));
        return;  
    }

    if (strlen($password)<5 || strlen($verifyPassword)<5) {
        $arr = array("msg"=>"need password","error"=>true);
        echo(json_encode($arr));
        return;
    }

    if ($email != $verifyEmail) {// test si les 2 emails saisis sont identiques
        $arr = array("msg"=>"Emails don't match","error"=>true);
        echo(json_encode($arr));
        return;  
    }

    if ($password != $verifyPassword) {// test si les 2 password saisis sont identiques
        $arr = array("msg"=>"Passwords don't match","error"=>true);
        echo(json_encode($arr));
        return;  
    }

    /* SI CREATION ON TEST SI DOUBLON DANS BDD */
    /* pour le pseudo */

    $query= $pdo->prepare('SELECT user_name FROM users WHERE user_name=:user_name');
    $query->execute(["user_name"=>$userName]);
    $inArray = $query->fetchall(PDO::FETCH_ASSOC);

    if (count($inArray)!=0) {
        $arr = array("msg"=>"invalid action, user name already used by a other account","error"=>true);
        echo(json_encode($arr));
        return;
    }

    /* pour les emails */
    $query= $pdo->prepare('SELECT email FROM users WHERE email=:email');
    $query->execute(["email"=>$email]);
    $inArray = $query->fetchall(PDO::FETCH_ASSOC);

    if (count($inArray)!=0) {
        $arr = array("msg"=>"invalid action, email already used by a other account","error"=>true);
        echo(json_encode($arr));
        return;
    }



    /* AJOUT A LA DB */
    $password = password_hash($_POST["registerPassword"], PASSWORD_DEFAULT);//hash du password

    $query = $pdo->prepare('INSERT INTO users (user_name, email, password) VALUES (:userName, :email, :password)');
    $query->execute(["userName"=>$userName, "email"=>$email, "password"=>$password]);

    $arr = array("msg"=>"action completed, account created","error"=>false);
    echo(json_encode($arr));
    return;


}else{// connexion a un compte existant
    
    $email=verifyInput($_POST["email"]);
    $password=verifyInput($_POST["password"]);

 

    /* CONNEXION A LA DB + RECUPERATION DU PASSWORD */
    $query = $pdo->prepare('SELECT password FROM users WHERE email=:email');
    $query->execute(["email"=>$email]);
    $user = $query->fetch(PDO::FETCH_ASSOC);

    if ($user==false) {// in verifie si le mail saisi est attaché a un compte
        $arr = array("msg"=>"invalid request, email unknow ","error"=>true);
        echo(json_encode($arr));
        return;
    }
    
    if (password_verify ($password , $user["password"]) ) {
        
        /* CONNEXION A LA DB + RECUPERATION DU COMPTE USER */
        $query = $pdo->prepare('SELECT id, user_name, admin, email FROM users WHERE email=:email');
        $query->execute(["email"=>$email]);
        $user = $query->fetch(PDO::FETCH_ASSOC);
        
        $_SESSION["user"] = [
            "id" => $user["id"],
            "user_name" => $user["user_name"],
            "email" => $user["email"],
            "admin" => $user["admin"]
        ];
        
        $arr = array("msg"=>"welcome","error"=>false);
        echo(json_encode($arr));
        return;
        
    }else{
        
        $arr = array("msg"=>"invalid request, check your email or password","error"=>true);
        echo(json_encode($arr));
        return;
    }

}


