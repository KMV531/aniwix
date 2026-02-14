<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>AniWix - Vos Favoris</title>
        <link rel="icon" href="../assets/favicon.png" type="image/png" />
        <link rel="stylesheet" href="../styles/index.css" />
        <link rel="stylesheet" href="../styles/wishlist.css" />
    </head>
    <body>
        <?php include("../components/header.php") ?>
    
        <?php 
            require_once '../includes/db.php';
            session_start();

            if (!isset($_SESSION['user_id'])) {
                header('Location: ../pages/register.php');
                exit();
            }

            // On récupère uniquement les IDs des animes favoris
            $stmt = $pdo->prepare("SELECT anime_id FROM wishlist WHERE user_id = ? ORDER BY added_at DESC");
            $stmt->execute([$_SESSION['user_id']]);
            $favIds = $stmt->fetchAll(PDO::FETCH_COLUMN);
        ?>

        <script>
            const myFavIds = <?php echo json_encode($favIds); ?>;
        </script>

        <main class="wishlist-container">
            <section class="wishlist-header">
                <h1>Ma Liste d'Animes</h1>
            </section>
            <div id="wishlistGrid" class="anime-grid">
            </div>

            <div id="emptyMessage" style="display: none;" class="emptyMessage">
                <p>Ta liste est vide pour le moment... Pars à la découverte !</p>
                <a href="../pages/animes.php" class="btn-browse">Explorer les animes</a>
            </div>
        </main>
        <script type="module" src="../scripts/index.js"></script>
    </body>
</html>