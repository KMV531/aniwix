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
        <div class="background-image">
            <div class="background-blur"></div>
        </div>
        <form action="">
            <h1>Connectez-vous</h1>
            <label for="email">Email : </label>
            <input type="email" name="email" id="email" required>
            <label for="password">Mot de passe :</label>
            <input type="password" name="password" id="password" required>
            <button type="submit">Se connecter</button>
            <span>Pas encore inscrit ? <a href="../pages/register.php">Inscrivez-vous ici</a></span>
            <a href="/" class="back-home">< Retour à l'accueil</a>
        </form>
    </main>
</body>
</html>