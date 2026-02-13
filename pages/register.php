<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AniWix - Register</title>
    <link rel="icon" href="../assets/favicon.png" type="image/png" />
    <link rel="stylesheet" href="../styles/index.css" />
    <link rel="stylesheet" href="../styles/register.css" />
</head>
<body>
    <main class="register-main">
        <form action="../api/process-register.php" method="POST" enctype="multipart/form-data">
            <h1>Creez un compte</h1>
            <?php session_start(); ?>
    
            <?php if(isset($_SESSION['error'])): ?>
                <div style="color: #ff4757;">
                    <?php 
                        echo $_SESSION['error']; 
                        unset($_SESSION['error']);
                    ?>
                </div>
            <?php endif; ?>
            <label for="username">Username :</label>
            <input type="text" name="username" id="username" required>

            <label for="email">Email : </label>
            <input type="email" name="email" id="email" required>

            <label for="password">Mot de passe :</label>
            <input type="password" name="password" id="password" required>

            <label for="avatar">Ton avatar :</label>
            <input type="file" name="avatar" id="avatar" accept="image/*" required>

            <button type="submit">S'inscrire</button>
            <span>Déjà inscrit ? <a href="../pages/login.php">Connectez-vous ici</a></span>
            <a href="/" class="back-home">< Retour à l'accueil</a>
        </form>
        <div class="background-image">
            <div class="background-blur"></div>
        </div>
    </main>
</body>
</html>