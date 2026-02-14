<?php
    session_start();
    require_once '../includes/db.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = trim($_POST['email']);
        $password = $_POST['password'];

        try {
            // Step 1: On recupere l'email et on verifie s'il correspond à un compte
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch();

            // 2. Étape de vérification séparée
            if (!$user) {
                // L'email n'existe même pas en base
                $_SESSION['error'] = "Cet email ne correspond à aucun compte Aniwix.";
                header("Location: ../pages/login.php");
                exit();
            }

            if (!password_verify($password, $user['password'])) {
                
                $_SESSION['error'] = "Mot de passe incorrect. Réessaie encore !";
                
                $_SESSION['old_email'] = $email; 
                header("Location: ../pages/login.php");
                exit();
            }

            // 3. Si on arrive ici, tout est parfait !
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['avatar'] = $user['avatar'];

            header("Location: ../index.php");
            exit();

        } catch (PDOException $e) {
            die("Erreur technique : " . $e->getMessage());
        }
    }