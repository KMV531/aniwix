<?php
    session_start();
    require_once '../includes/db.php';

    // 1. On récupère les données envoyées par le fetch (JSON)
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    $anime_id = $data['anime_id'] ?? null;
    $user_id = $_SESSION['user_id'] ?? null;

    // 2. Sécurité : Vérifier si l'utilisateur est connecté
    if (!$user_id) {
        echo json_encode(['status' => 'error', 'message' => 'not_logged_in']);
        exit;
    }

    if (!$anime_id) {
        echo json_encode(['status' => 'error', 'message' => 'missing_id']);
        exit;
    }

    try {
        // 3. On vérifie si cet anime est déjà dans la wishlist de cet utilisateur
        $check = $pdo->prepare("SELECT id FROM wishlist WHERE user_id = :u AND anime_id = :a");
        $check->execute(['u' => $user_id, 'a' => $anime_id]);
        $exists = $check->fetch();

        if ($exists) {
            // L'anime est déjà là -> On le RETIRE (Toggle off)
            $delete = $pdo->prepare("DELETE FROM wishlist WHERE user_id = :u AND anime_id = :a");
            $delete->execute(['u' => $user_id, 'a' => $anime_id]);
        
            echo json_encode(['status' => 'success', 'action' => 'removed']);
        } else {
            // L'anime n'est pas là -> On l'AJOUTE (Toggle on)
            $insert = $pdo->prepare("INSERT INTO wishlist (user_id, anime_id) VALUES (:u, :a)");
            $insert->execute(['u' => $user_id, 'a' => $anime_id]);
        
            echo json_encode(['status' => 'success', 'action' => 'added']);
        }

    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }