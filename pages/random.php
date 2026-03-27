<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AniWix - Random Anime</title>
    <link rel="icon" href="../assets/favicon.png" type="image/png" />
    <link rel="stylesheet" href="../styles/index.css" />
</head>
<body>
    <?php 
        require_once '../includes/db.php'; 
        session_start();

        $arrContextOptions = ["ssl" => ["verify_peer" => false, "verify_peer_name" => false]];
        $context = stream_context_create($arrContextOptions);
        $response = @file_get_contents("https://api.jikan.moe/v4/random/anime", false, $context);
        $decoded = json_decode($response, true);
        $data = $decoded['data'];

        $animeId = $data['mal_id'];
        $title = $data['title'];
        $synopsis = $data['synopsis'];
        $bgImage = $data['images']['jpg']['large_image_url'];
        $score = $data['score'] ?? '??';
        $episodes = $data['episodes'] ?? '?';
        $type = $data['type'];
        $genres = $data['genres'];
        $trailerUrl = $data['trailer']['embed_url'];

        // ======================= Similar Animes Block =============================
        $genreId = !empty($data['genres']) ? $data['genres'][0]['mal_id'] : null;
        $similarAnimes = [];

        if ($genreId) {
            $randomOffset = rand(0, 100);
            $simUrl = "https://api.jikan.moe/v4/anime?genres=$genreId&limit=6&order_by=score&sort=desc&page=$randomOffset";
           
            $simRes = file_get_contents($simUrl, false, $context);
    
            if ($simRes) {
                $simData = json_decode($simRes, true)['data'];
        
                foreach ($simData as $item) {
                    if ($item['mal_id'] != $animeId && count($similarAnimes) < 6) {
                        $similarAnimes[] = $item;
                    }
                }
            }
        }

        include("../components/header.php");
    ?>

    <main class="anime-details">    
        <?php include("../components/anime-view.php"); ?>
    </main>

    <?php include("../components/footer.php"); ?>
    
</body>
</html>