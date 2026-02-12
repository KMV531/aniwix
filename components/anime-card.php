<link rel="stylesheet" href="../styles/anime-card.css">

<main>
    <a href="../pages/details.php?id=<?php echo $anime['mal_id']; ?>" class="card-link">
        <div class="anime-card">
            <div class="card-image-container">
                <img src="<?php echo $anime['images']['webp']['large_image_url']; ?>" 
                    alt="<?php echo htmlspecialchars($anime['title']); ?>" 
                    class="card-img"
                >
        
                <?php if(isset($anime['score'])): ?>
                    <div class="card-badge">⭐ <?php echo $anime['score']; ?></div>
                <?php endif; ?>
            </div>

            <div class="card-details">
                <h3 class="card-title"><?php echo htmlspecialchars($anime['title']); ?></h3>
                <p class="card-info">
                    <?php echo $anime['type']; ?> • <?php echo $anime['episodes'] ?? '?'; ?> Eps
                </p>
            </div>
        </div>
    </a>
</main>