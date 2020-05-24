<?php
session_start();

$path = $_GET["path"];

if (isset($_GET["id"]) ) {
    $id = $_GET["id"];
    session_destroy();
    header("Location:../article&id=$id");
    exit();
}

if (isset($_SESSION["user"])) {
    session_destroy();
    header("Location:../$path");
}



