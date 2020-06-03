<?php
try {
    $pdo = new PDO ("");
    $pdo->exec('SET NAMES UTF8');
    $pdo->exec("SET lc_time_names = 'fr_FR'");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die ('Échec lors de la connexion : ' . $e->getMessage());
}
