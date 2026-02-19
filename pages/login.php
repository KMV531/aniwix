<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AniWix - Connectez-vous</title>
    <link rel="icon" href="../assets/favicon.png" type="image/png" />
    <link rel="stylesheet" href="../styles/index.css" />
    <link rel="stylesheet" href="../styles/login.css" />
</head>
<body>
    <main class="login-main">
        <div class="background-image" id="login-bg">
        </div>
        <form action="../api/process-login.php" method="POST">
            <h1>Bon retour parmi nous !</h1>

            <?php session_start(); ?>

            <?php if(isset($_SESSION['error'])): ?>
                <p style="color: red;"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
            <?php endif; ?>

            <label for="email">E-mail : </label>
            <input type="email" name="email" 
                value="<?php echo $_SESSION['old_email'] ?? ''; unset($_SESSION['old_email']); ?>" 
                placeholder="Ton e-mail" required
            >

            <label for="password">Mot de passe :</label>
            <input type="password" name="password" id="password" placeholder="Ton mot de passe" required>

            <button type="submit">Entrer</button>
            <span>Pas encore inscrit ? <a href="../pages/register.php">Inscrivez-vous ici</a></span>
            <a href="/" class="back-home">< Retour à l'accueil</a>
        </form>
    </main>
    <script type="module" src="../scripts/login.js"></script>
</body>
</html>