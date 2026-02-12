<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AniWix - Explore All Animes</title>
     <link rel="icon" href="../assets/favicon.png" type="image/png" />
    <link rel="stylesheet" href="../styles/index.css" />
    <link rel="stylesheet" href="../styles/animes.css" />
</head>
<body>
    <?php 
        include("../components/header.php");
        include("../sections/explore-header.php");
     ?>

    <?php
        $arrContextOptions = ["ssl" => ["verify_peer" => false, "verify_peer_name" => false]];
        $context = stream_context_create($arrContextOptions);

        // Fonction pour récupérer les animes par genre
        function getAnimesByGenre($genreId, $ctx) {
            $url = "https://api.jikan.moe/v4/anime?genres=$genreId&order_by=score&sort=desc&limit=6";
            $json = file_get_contents($url, false, $ctx);
            return json_decode($json, true)['data'] ?? [];
        }

        // Récupération des données (un petit délai entre chaque peut aider)
        $shonenAnimes = getAnimesByGenre(27, $context);
        usleep(500000); // 0.2 seconde de pause
        $shojoAnimes = getAnimesByGenre(25, $context);
        usleep(500000);
        $solAnimes = getAnimesByGenre(36, $context);
        usleep(500000);
        $isekaiAnimes = getAnimesByGenre(62, $context);
        usleep(500000);
        $ecchiAnimes = getAnimesByGenre(9, $context);
        usleep(500000);
        $actionAnimes = getAnimesByGenre(1, $context);
    ?>

    <section class="category-section">
        <div class="container">
            <div class="category-header align-left">
                <h2 class="category-title">Shonen <span>Power</span></h2>
                <div class="title-line"></div>
            </div>
            <div class="anime-grid">
                <?php foreach($shonenAnimes as $anime): include '../components/anime-card.php'; endforeach; ?>
            </div>
        </div>
    </section>

    <section class="category-section">
        <div class="container">
            <div class="category-header align-right">
                <h2 class="category-title">Shojo <span>Dreams</span></h2>
                <div class="title-line"></div>
            </div>
            <div class="anime-grid">
                <?php foreach($shojoAnimes as $anime): include '../components/anime-card.php'; endforeach; ?>
            </div>
        </div>
    </section>

    <section class="category-section">
        <div class="container">
            <div class="category-header align-left">
                <h2 class="category-title">Slice of Life <span>Everyday Stories</span></h2>
                <div class="title-line"></div>
            </div>
            <div class="anime-grid">
                <?php foreach($solAnimes as $anime): include '../components/anime-card.php'; endforeach; ?>
            </div>
        </div>
    </section>

    <section class="category-section">
        <div class="container">
            <div class="category-header align-right">
                <h2 class="category-title">Isekai <span>Adventures</span></h2>
                <div class="title-line"></div>
            </div>
            <div class="anime-grid">
                <?php foreach($isekaiAnimes as $anime): include '../components/anime-card.php'; endforeach; ?>
            </div>
        </div>
    </section>

    <section class="category-section">
        <div class="container">
            <div class="category-header align-left">
                <h2 class="category-title">Ecchi <span>Fun</span></h2>
                <div class="title-line"></div>
            </div>
            <div class="anime-grid">
                <?php foreach($ecchiAnimes as $anime): include '../components/anime-card.php'; endforeach; ?>
            </div>
        </div>
    </section>

    <section class="category-section">
        <div class="container">
            <div class="category-header align-right">
                <h2 class="category-title">Action <span>Thrills</span></h2>
                <div class="title-line"></div>
            </div>
            <div class="anime-grid">
                <?php foreach($actionAnimes as $anime): include '../components/anime-card.php'; endforeach; ?>
            </div>
        </div>
    </section>

    <?php 
      include("../components/footer.php"); 
    ?>
    <script src="../scripts/index.js"></script>
</body>
</html>