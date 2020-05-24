<?php
try {
    $pdo = new PDO ("mysql:host=home.3wa.io:3307;dbname=pa-153_wangermee_magic_french_family","wangermee","cb396f4cMGM2ZmMzMTcyMDQ3YWE2NmViZWI5Yjgza4c906c0");
    $pdo->exec('SET NAMES UTF8');
    $pdo->exec("SET lc_time_names = 'fr_FR'");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die ('Échec lors de la connexion : ' . $e->getMessage());
}
// pour que la date soit en fr
//$pdo -> query("SET lc_time_names = 'fr_FR';");