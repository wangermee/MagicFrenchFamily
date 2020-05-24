<?php
header("Content-Type: application/json");

/* FONCTION PROTECTION FAILLE XSS  */ 
function verifyInput ($var){
    $var = trim($var);
    $var = stripslashes($var);
    $var = htmlspecialchars($var);
    return $var;
}

/* RECUPERATION ET VERIFICATION DES CHAMPS DU FORM */ 
if (isset($_POST["firstName"])) {
    $firstName = verifyInput($_POST["firstName"]);
    $lastName = verifyInput($_POST["lastName"]);
    $email = verifyInput($_POST["email"]);
    $verifyEmail = verifyInput($_POST["verifyEmail"]);
    $phoneNumber = verifyInput($_POST["phoneNumber"]);
    $message = verifyInput($_POST["message"]);

    $emailText="";
    
    if (strlen($firstName)==0) {
        $arr = array("msg"=>"need firstName","error"=>true);
        echo(json_encode($arr));
        return;
    
    }else{
        $emailText .= "firstName : $firstName\n";
    }

    if (strlen($lastName)==0) {
        $arr = array("msg"=>"need lastName","error"=>true);
        echo(json_encode($arr));
        return;  
    }else{
        $emailText .= "lastName : $lastName\n";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $arr = array("msg"=>"need email","error"=>true);
        echo(json_encode($arr));
        return;  
    }

    if (!filter_var($verifyEmail, FILTER_VALIDATE_EMAIL)) {
        $arr = array("msg"=>"need email","error"=>true);
        echo(json_encode($arr));
        return;  
    }
    
    if ($email != $verifyEmail) {
        $arr = array("msg"=>"Emails don't match","error"=>true);
        echo(json_encode($arr));
        return;  
    }else{
        $emailText .= "email : $email\n";
    }
    
    if (strlen($phoneNumber) !=0) {
        if (strlen($phoneNumber) !=10 || !filter_var($phoneNumber, FILTER_SANITIZE_NUMBER_INT)) {
            $arr = array("msg"=>"need valid phone number","error"=>true);
            echo(json_encode($arr));
            return;    
        }else{
            $emailText .= "phoneNumber : $phoneNumber\n";
        }
    }

    if (strlen($message)==0) {
        $arr = array("msg"=>"need message","error"=>true);
        echo(json_encode($arr));
        return;
    }else{
        $emailText .= "message : $message\n";
    }

    /* ENVOIS DU MAIL */
    $emailTo= "soulscr@gmail.com";
    $emailObjet="Magic French Family";
    $headers="From: $firstName $lastName <$email>\r\nReply-To:$email";
    mail($emailTo,$emailObjet,$emailText,$headers);

    /* MESSAGE DE FIN */
    $arr = array("msg"=>"Email Send","error"=>false);
    echo(json_encode($arr));
    return;
    
}



