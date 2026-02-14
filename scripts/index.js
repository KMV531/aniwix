const searchInput = document.getElementById("searchInput");
const searchResults = document.getElementById("searchResults");
let timer;

searchInput.addEventListener("input", (e) => {
  const query = e.target.value;

  clearTimeout(timer);

  if (query.length < 3) {
    searchResults.style.display = "none";
    return;
  }

  timer = setTimeout(async () => {
    if (query.trim() === "") return;

    try {
      const res = await fetch(
        `https://api.jikan.moe/v4/anime?q=${query}&limit=5`,
      );
      const json = await res.json();
      const animes = json.data;

      searchResults.innerHTML = "";
      searchResults.style.display = "block";

      if (animes.length === 0) {
        searchResults.innerHTML =
          '<div class="no-result">Aucun anime trouvé...</div>';
        return;
      }

      animes.forEach((anime) => {
        const div = document.createElement("div");
        div.className = "search-item";

        div.setAttribute("data-id", anime.mal_id);

        div.innerHTML = `
        <img src="${anime.images.webp.small_image_url}" alt="${anime.title}">
        <div class="search-item-info">
            <h4>${anime.title}</h4>
            <span>${anime.type}</span>
        </div>
    `;

        div.addEventListener("mousedown", (e) => {
          window.location.href = `../pages/details.php?id=${anime.mal_id}`;
        });

        searchResults.appendChild(div);
      });
    } catch (error) {
      console.error("Erreur API :", error);
    }
  }, 400);
});

document.addEventListener("click", (e) => {
  if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
    searchResults.style.display = "none";
  }
});

// Attendre que le DOM soit chargé
document.addEventListener("DOMContentLoaded", () => {
  const avatarBtn = document.getElementById("avatarBtn");
  const dropdownMenu = document.getElementById("dropdownMenu");

  if (avatarBtn) {
    avatarBtn.addEventListener("click", (e) => {
      e.stopPropagation(); // Empêche le clic de se propager
      dropdownMenu.classList.toggle("show");
    });
  }

  // Fermer le menu si on clique ailleurs sur la page
  document.addEventListener("click", () => {
    if (dropdownMenu && dropdownMenu.classList.contains("show")) {
      dropdownMenu.classList.remove("show");
    }
  });
});
