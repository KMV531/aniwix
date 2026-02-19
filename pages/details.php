<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>AniWix - Details</title>
        <link rel="icon" href="../assets/favicon.png" type="image/png" />
        <link rel="stylesheet" href="../styles/index.css" />
    </head>
    <body>
        <?php 
            include("../components/header.php");
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
            include("../components/anime-view.php"); 
        ?>
        <?php include("../components/footer.php"); ?>
    </body>
</html>
