<link rel="stylesheet" href="../styles/details.css" />

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