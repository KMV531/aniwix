<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>AniWix - La plateforme des fans, par un fan, pour des fans</title>
    <link rel="icon" href="../assets/favicon.png" type="image/png" />
    <link rel="stylesheet" href="../styles/index.css" />
  </head>
  <body>
    <?php
      // --- CONFIGURATION ---
      $arrContextOptions = ["ssl" => ["verify_peer" => false, "verify_peer_name" => false]];
      $context = stream_context_create($arrContextOptions);

      // 1. RÉCUPÉRATION : SEASONS NOW (Trending)
      $res_airing = file_get_contents("https://api.jikan.moe/v4/seasons/now?limit=12", false, $context);
      $animes_airing = json_decode($res_airing, true)['data'] ?? [];

      // 2. UPCOMING (Les pépites qui arrivent bientôt)
      $res_upcoming = file_get_contents("https://api.jikan.moe/v4/seasons/upcoming?limit=12", false, $context);
      $animes_upcoming = json_decode($res_upcoming, true)['data'] ?? [];

      // 3. RÉCUPÉRATION : CLASSICS 
      $res_classics = file_get_contents("https://api.jikan.moe/v4/top/anime?filter=bypopularity&limit=6", false, $context);
      $animes_classics = json_decode($res_classics, true)['data'] ?? [];
    ?>

    <?php 
      include("components/header.php");
      include("sections/heroSection.php");
    ?>

    <section class="main-content">
      <div class="container">
        <h2 class="section-heading">Currently Airing</h2>
        <div class="anime-grid">
            <?php foreach ($animes_airing as $anime): ?>
                <?php include 'components/anime-card.php'; ?>
            <?php endforeach; ?>
        </div>

        <h2 class="section-heading" style="margin-top: 3rem;">Upcoming Seasons</h2>
        <div class="anime-grid">
            <?php foreach ($animes_upcoming as $anime): ?>
                <?php include 'components/anime-card.php'; ?>
            <?php endforeach; ?>
        </div>

        <h2 class="section-heading" style="margin-top: 3rem;">Community Classics</h2>
        <div class="anime-grid">
            <?php foreach ($animes_classics as $anime): ?>
                <?php include 'components/anime-card.php'; ?>
            <?php endforeach; ?>
        </div>
      </div>
</section>
    <?php 
      include("components/footer.php"); 
    ?>
  <script src="../scripts/index.js"></script>
  </body>
</html>
