<link rel="stylesheet" href="../styles/header.css" />

<?php session_start(); ?>
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
    <div class="search-container">
        <div class="search-form">
            <input type="text" id="searchInput" placeholder="Rechercher un anime..." autocomplete="off">
            <div id="searchResults" class="search-results-panel"></div>
        </div>
    </div>
    <div class="user-controls">
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="../pages/wishlist.php" title="Favoris">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-heart"><path d="M2 9.5a5.5 5.5 0 0 1 9.591-3.676.56.56 0 0 0 .818 0A5.49 5.49 0 0 1 22 9.5c0 2.29-1.5 4-3 5.5l-5.492 5.313a2 2 0 0 1-3 .019L5 15c-1.5-1.5-3-3.2-3-5.5"/></svg>
            </a>
            
            <div class="avatar-dropdown">
                <img src="../uploads/avatars/<?php echo $_SESSION['avatar']; ?>" 
                     alt="Avatar" class="nav-avatar" id="avatarBtn">
                
                <div id="dropdownMenu" class="dropdown-content">
                    <p class="username"><?php echo $_SESSION['username']; ?></p>
                    <a href="../api/logout.php" class="logout-link">Déconnexion</a>
                </div>
            </div>

        <?php else: ?>
            <a href="../pages/register.php" title="Connexion">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </a>
        <?php endif; ?>
    </div>
</header>

<script type="module" src="../scripts/index.js"></script>