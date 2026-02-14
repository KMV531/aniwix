<?php
    session_start();
    require_once '../includes/db.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];
    
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $avatarName = 'default_avatar.png';
    
        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === 0) {
            $allowed = ['jpg', 'jpeg', 'png', 'gif'];
            $filename = $_FILES['avatar']['name'];
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

            if (in_array($ext, $allowed)) {
                // On crée un nom unique pour éviter les doublons (ex: 167584_monimage.png)
                $avatarName = time() . '_' . preg_replace('/[^a-z0-9.]/i', '', $filename);
                $destination = '../uploads/avatars/' . $avatarName;

                if (!move_uploaded_file($_FILES['avatar']['tmp_name'], $destination)) {
                    $avatarName = 'default_avatar.png';
                }
            }
        }

        try {
            $checkSql = "SELECT username, email FROM users WHERE username = :username OR email = :email";
            $checkStmt = $pdo->prepare($checkSql);
            $checkStmt->execute(['username' => $username, 'email' => $email]);
            $existingUser = $checkStmt->fetch(PDO::FETCH_ASSOC);

            if ($existingUser) {
                if ($existingUser['username'] === $username) {
                    $_SESSION['error'] = "Ce pseudo est déjà pris par un autre fan.";
                } elseif ($existingUser['email'] === $email) {
                    $_SESSION['error'] = "Cet email est déjà lié à un compte Aniwix.";
                }
                 header('Location: ../pages/register.php');
                exit();
            }

            // 3. Insertion en base de données
            $sql = "INSERT INTO users (username, email, password, avatar) VALUES (:username, :email, :password, :avatar)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'username' => $username,
                'email'    => $email,
                'password' => $hashedPassword,
                'avatar'   => $avatarName
            ]);

            // 4. On connecte l'utilisateur automatiquement après inscription
            $_SESSION['user_id'] = $pdo->lastInsertId();
            $_SESSION['username'] = $username;
            $_SESSION['avatar'] = $avatarName;

            // Redirection vers le home
            header('Location: ../index.php');
            exit();

        } catch (PDOException $e) {
            $_SESSION['error'] = "Erreur technique : " . $e->getMessage();
            header('Location: ../pages/register.php');
            exit();
        }
    }