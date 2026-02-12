<link rel="stylesheet" href="../styles/explore-header.css" />

<main class="explore-main">
    <section class="explore-header">
    <div class="container explore-flex">
        <div class="explore-title">
            <h1>Explore All Animes</h1>
            <p>Trouve ton prochain coup de cœur parmi des milliers de titres.</p>
        </div>
        
        <div class="explore-search">
            <form action="search-results.php" method="GET" class="search-form">
                <input type="text" name="query" placeholder="Rechercher un anime..." required>
                <button type="submit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search-icon lucide-search"><path d="m21 21-4.34-4.34"/><circle cx="11" cy="11" r="8"/></svg>
                </button>
            </form>
        </div>
    </div>
</section>
</main>