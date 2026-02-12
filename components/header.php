<header class="navbar">
    <div>
        <a href="/">
            <img src="../assets/logo.png" alt="AniWix Logo">
        </a>
    </div>

    <nav class="nav-links">
        <a href="/" class="link">Home</a>
        <a href="../pages/about.php" class="link">Watashi</a>
        <a href="../pages/animes.php" class="link">Animes</a>
    </nav>

    <div class="nav-actions">
        <form action="search.php" method="get" class="search-bar">
            <input type="text" name="query" placeholder="Search anime..." class="search-input">
            <button type="submit" class="search-button">Search</button>
        </form>

        <div class="user-controls">
             <a href="../pages/wishlist.php" class="wishlist-link">Favoris</a>
             <a href="../pages/register.php" class="btn-primary">Connexion</a>
        </div>
    </div>
</header>