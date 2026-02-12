<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AniWix - Centre Légal & Confidentialité</title>
     <link rel="icon" href="../assets/favicon.png" type="image/png" />
    <link rel="stylesheet" href="../styles/index.css" />
</head>
<body>
    <?php include("../components/header.php") ?>
    <div class="container legal-page" style="padding: 120px 20px 60px; max-width: 900px; margin: 0 auto; color: #eee; line-height: 1.8;">
    <h1 style="color: #6366f1; font-size: 2.5rem; margin-bottom: 40px;">Centre Légal & Confidentialité</h1>

    <section style="margin-bottom: 50px;">
        <h2 style="color: white; border-bottom: 2px solid #333; padding-bottom: 10px;">1. Mentions Légales</h2>
        <p><strong>Éditeur :</strong> Ce site est un projet passionné développé par <strong>Vinny</strong>. Il a pour but de répertorier et de présenter des informations sur les œuvres d'animation japonaise.</p>
        <p><strong>Hébergement :</strong> Vercel Inc.</p>
        <p><strong>Contact :</strong> Pour toute question ou demande, veuillez contacter <a href="mailto:koladjamomo@gmail.com">koladjamomo@gmail.com</a></p>
        <p><strong>Source des données :</strong> Toutes les informations (titres, synopsis, scores, images) sont fournies par l'API Jikan, une interface open-source.</p>
    </section>

    <section style="margin-bottom: 50px;">
        <h2 style="color: white; border-bottom: 2px solid #333; padding-bottom: 10px;">2. Collecte des données</h2>
        <p>Nous respectons votre vie privée. La collecte de données sur Aniwix se limite strictement à :</p>
        <ul style="margin-left: 20px; list-style-type: disc;">
            <li><strong>Création de compte :</strong> Votre email et pseudonyme pour vous identifier.</li>
            <li><strong>Préférences :</strong> Votre "Watchlist" ou vos favoris pour que vous puissiez les retrouver.</li>
        </ul>
        <p><strong>Sécurité :</strong> Vos mots de passe sont cryptés et nous ne revendons jamais vos informations à des tiers. Vous pouvez demander la suppression de votre compte et de vos données à tout moment.</p>
    </section>

    <section style="margin-bottom: 50px;">
        <h2 style="color: white; border-bottom: 2px solid #333; padding-bottom: 10px;">3. Propriété Intellectuelle</h2>
        <p>Aniwix ne revendique aucun droit sur les visuels et les titres présentés. Les droits de <strong>Bleach</strong> et des autres séries appartiennent à leurs créateurs et studios respectifs (Tite Kubo, Studio Pierrot, etc.).</p>
        <p>Ce site est à but non lucratif et respecte le droit de citation.</p>
    </section>

    <div style="text-align: center; margin-top: 60px; color: #666;">
        <p>Dernière mise à jour : <?php echo date("M Y"); ?></p>
    </div>
</div>

<?php include("../components/footer.php") ?>
</body>
</html>

