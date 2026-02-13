<?php
    $host = 'localhost';
    $dbname = 'aniwix_db';
    $username = 'root';
    $password = 'ni^WQynm0]W.SmQF';

    try {
        // On crée la connexion via PDO (le standard sécurisé)
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    
        // On active les erreurs pour débugger plus facilement
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    } catch (PDOException $e) {
        die("Erreur de connexion : " . $e->getMessage());
    }
?>