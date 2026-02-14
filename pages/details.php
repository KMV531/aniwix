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
            // 1. Always start DB and Session
            require_once '../includes/db.php'; 
            session_start();

            // 2. Get the ID de l'anime depuis l'URL
            $animeId = $_GET['id'] ?? null;
            if (!$animeId) {
                header('Location: index.php');
                exit;
            }

            // 3. Verify if the anime is in user's favorites (wishlist)
            $isFavorite = false;
            if (isset($_SESSION['user_id'])) {
                $checkFav = $pdo->prepare("SELECT id FROM wishlist WHERE user_id = ? AND anime_id = ?");
                $checkFav->execute([$_SESSION['user_id'], $animeId]);
                if ($checkFav->fetch()) {
                    $isFavorite = true;
                }
            }

            // 4. Appel API
            $arrContextOptions = ["ssl" => ["verify_peer" => false, "verify_peer_name" => false]];
            $context = stream_context_create($arrContextOptions);
            $apiUrl = "https://api.jikan.moe/v4/anime/$animeId/full";
            $response = @file_get_contents($apiUrl, false, $context); // Le @ évite d'afficher l'erreur si l'API est down
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
            $trailerUrl = $data['trailer']['embed_url'];

                // ======================= Similar Animes Block =============================
            $genreId = !empty($data['genres']) ? $data['genres'][0]['mal_id'] : null;
            $similarAnimes = [];

            if ($genreId) {
                // Call to API to get similar animes based on the first genre of the current anime
                $randomOffset = rand(0, 100);
                $simUrl = "https://api.jikan.moe/v4/anime?genres=$genreId&limit=6&order_by=score&sort=desc&page=$randomOffset";
           
                $simRes = file_get_contents($simUrl, false, $context);
    
                if ($simRes) {
                    $simData = json_decode($simRes, true)['data'];
        
                    foreach ($simData as $item) {
                        // On exclut l'anime qu'on est déjà en train de regarder
                        if ($item['mal_id'] != $animeId && count($similarAnimes) < 6) {
                            $similarAnimes[] = $item;
                        }
                    }
                }
            }
        
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

                    <?php if (isset($_SESSION['user_id'])): ?>
                        <div class="action-buttons">
                            <button class="btn-watch" id="btn-watch">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-play-icon lucide-play"><path d="M5 5a2 2 0 0 1 3.008-1.728l11.997 6.998a2 2 0 0 1 .003 3.458l-12 7A2 2 0 0 1 5 19z"/></svg>
                                Watch Now
                            </button>
                            <button class="btn-add <?php echo $isFavorite ? 'is-active' : ''; ?>" data-id="<?php echo $animeId; ?>" id="wishlistBtn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus-icon lucide-plus"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                                <span id="btnText">
                                    <?php echo $isFavorite ? 'Remove from List' : 'Add to List'; ?>
                                </span>
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
            </section>
        
            <?php if (!isset($_SESSION['user_id'])): ?>
                <div class="info-message">
                    <p>Vous voulez en savoir plus ? Connectez-vous pour accéder à plus de détails.</p>
                    <a href="../pages/register.php" class="btn-login">S'identifier</a>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['user_id'])): ?>
                <?php if (!empty($trailerUrl)): ?>
                    <section class="anime-trailer-section">
                        <div class="container">
                            <h2 class="section-title">Official Trailer</h2>
                            <div class="video-container">
                                <iframe 
                                    src="<?php echo $trailerUrl; ?>" 
                                    frameborder="0" 
                                    allowfullscreen>
                                </iframe>
                            </div>
                        </div>
                    </section>
                <?php endif; ?>

                <section class="similar-section">
                    <div class="section-header">
                        <h2>Plus comme <?php echo $title; ?></h2>
                    </div>

                    <div class="anime-grid">
                        <?php if (!empty($similarAnimes)): ?>
                            <?php foreach ($similarAnimes as $anime): ?>
                            <?php include '../components/anime-card.php'; ?>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <p>Aucune pépite similaire trouvée pour le moment...</p>
                        <?php endif; ?>
                    </div>
                </section>
            <?php endif; ?>
        </main>
        <script type="module" src="../scripts/index.js"></script>
        <?php 
            include("../components/footer.php"); 
        ?>
    </body>
</html>