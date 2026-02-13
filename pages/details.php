<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AniWix - Details</title>
    <link rel="icon" href="../assets/favicon.png" type="image/png" />
    <link rel="stylesheet" href="../styles/index.css" />
    <link rel="stylesheet" href="../styles/details.css" />
</head>
<body>
    <?php include("../components/header.php") ?>
    
    <?php
        // Recuperation de l'ID depuis l'URL
        $animeId = $_GET['id'] ?? null;
        if (!$animeId) {
            header('Location: index.php');
            exit;
        }

        $arrContextOptions = ["ssl" => ["verify_peer" => false, "verify_peer_name" => false]];
        $context = stream_context_create($arrContextOptions);

        $apiUrl = "https://api.jikan.moe/v4/anime/$animeId/full";
        $response = file_get_contents($apiUrl, false, $context);
        $decoded = json_decode($response, true);
        if (!$decoded || !isset($decoded['data'])) {
            header('Location: index.php');
            exit;
        }
        $data = $decoded['data'];

        $title = $data['title'];
        $synopsis = $data['synopsis'];
        $bgImage = $data['images']['jpg']['large_image_url'];
        $score = $data['score'];
        $episodes = $data['episodes'];
        $type = $data['type'];
        $genres = $data['genres'];
    ?>

    <main class="anime-details">
        <section class="hero-spotlight" style="background-image: linear-gradient(to top, #0f0f0f 10%, rgba(15, 15, 15, 0.4) 50%, rgba(15, 15, 15, 0.7) 100%), url('<?php echo $bgImage; ?>');">
        
            <div class="container spotlight-content">
                <div class="meta-badges">
                    <span class="badge-score">⭐ <?php echo $score; ?></span>
                    <span class="badge-type"><?php echo $type; ?></span> •
                    <span class="badge-ep"><?php echo $episodes; ?> EPS</span>
                </div>

                <h1 class="anime-title"><?php echo $title; ?></h1>

                <div class="genres-list">
                    <?php foreach($genres as $genre): ?>
                        <span class="genre-tag"><?php echo $genre['name']; ?></span>
                    <?php endforeach; ?>
                </div>

                <p class="synopsis"><?php echo $synopsis; ?></p>

                <div class="action-buttons">
                    <a href="#" class="btn-watch">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-play-icon lucide-play"><path d="M5 5a2 2 0 0 1 3.008-1.728l11.997 6.998a2 2 0 0 1 .003 3.458l-12 7A2 2 0 0 1 5 19z"/></svg>
                         Watch Now
                    </a>
                    <button class="btn-add">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus-icon lucide-plus"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                        Add to List
                    </button>
                </div>
            </div>
        </section>
    </main>
</body>
</html>