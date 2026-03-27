<?php
    session_start();
    require_once '../includes/db.php';

    // 1. We retrieve the data sent by the fetch (JSON)
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    $anime_id = $data['anime_id'] ?? null;
    $user_id = $_SESSION['user_id'] ?? null;

    // 2. Security: Check if the user is logged in
    if (!$user_id) {
        echo json_encode(['status' => 'error', 'message' => 'not_logged_in']);
        exit;
    }

    if (!$anime_id) {
        echo json_encode(['status' => 'error', 'message' => 'missing_id']);
        exit;
    }

    try {
        // 3. We check if this anime is already in the user's wishlist
        $check = $pdo->prepare("SELECT id FROM wishlist WHERE user_id = :u AND anime_id = :a");
        $check->execute(['u' => $user_id, 'a' => $anime_id]);
        $exists = $check->fetch();

        if ($exists) {
            // The anime is already there -> We remove it (Toggle off)
            $delete = $pdo->prepare("DELETE FROM wishlist WHERE user_id = :u AND anime_id = :a");
            $delete->execute(['u' => $user_id, 'a' => $anime_id]);
        
            echo json_encode(['status' => 'success', 'action' => 'removed']);
        } else {
            // The anime is not there -> We add it (Toggle on)
            $insert = $pdo->prepare("INSERT INTO wishlist (user_id, anime_id) VALUES (:u, :a)");
            $insert->execute(['u' => $user_id, 'a' => $anime_id]);
        
            echo json_encode(['status' => 'success', 'action' => 'added']);
        }

    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }