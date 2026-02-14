// ======= DROPDOWN MENU FOR SEARCH RESULTS =======
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

// ======= DROPDOWN MENU FOR AVATAR =======
document.addEventListener("DOMContentLoaded", () => {
  const avatarBtn = document.getElementById("avatarBtn");
  const dropdownMenu = document.getElementById("dropdownMenu");

  if (avatarBtn) {
    avatarBtn.addEventListener("click", (e) => {
      e.stopPropagation();
      dropdownMenu.classList.toggle("show");
    });
  }

  document.addEventListener("click", () => {
    if (dropdownMenu && dropdownMenu.classList.contains("show")) {
      dropdownMenu.classList.remove("show");
    }
  });
});

// ======= BUTTONS FUNCTIONALITY =======
/* == WATCH NOW == */
document.getElementById("btn-watch")?.addEventListener("click", () => {
  alert(
    "Aaah non, flemme... T'imagines la dose de travail que ça demanderait ? Trop long, trop fatigué. Mais attention, je ne suis pas paresseux, je conserve juste de l'énergie.",
  );
});

/* == WISHLIST == */
document
  .getElementById("wishlistBtn")
  ?.addEventListener("click", async function () {
    const animeId = this.getAttribute("data-id");
    const btnText = document.getElementById("btnText");

    try {
      const response = await fetch("../api/toggle-wishlist.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          anime_id: animeId,
        }),
      });

      const data = await response.json();
      console.log("data :", data);

      if (data.status === "success") {
        btnText.innerText =
          data.action === "added" ? "Remove from List" : "Add to List";
        this.classList.toggle("is-active");
      } else if (data.message === "not_logged_in") {
        alert("Connecte-toi pour ajouter cet anime !");
      }
    } catch (error) {
      console.error("Erreur :", error);
    }
  });

document.addEventListener("DOMContentLoaded", async () => {
  const grid = document.getElementById("wishlistGrid");
  const emptyMessage = document.getElementById("emptyMessage");

  // Après avoir récupéré tes IDs (myFavIds)
  if (myFavIds.length === 0) {
    document.getElementById("emptyMessage").style.display = "block";
    document.getElementById("wishlistGrid").style.display = "none";
  } else {
    document.getElementById("emptyMessage").style.display = "none";
    document.getElementById("wishlistGrid").style.display = "grid";

    for (const id of myFavIds) {
      try {
        const response = await fetch(`https://api.jikan.moe/v4/anime/${id}`);
        const result = await response.json();
        const anime = result.data;

        const card = document.createElement("div");
        card.className = "anime-card";
        card.innerHTML = `
                <a href="details.php?id=${anime.mal_id}">
                    <img src="${anime.images.jpg.image_url}" alt="${anime.title}">
                    <div class="card-info">
                        <h3>${anime.title}</h3>
                        <span class="score">⭐ ${anime.score || "N/A"}</span>
                    </div>
                </a>
            `;
        grid.appendChild(card);

        await new Promise((resolve) => setTimeout(resolve, 300));
      } catch (error) {
        console.error(`Erreur pour l'anime ${id}:`, error);
      }
    }
  }
});
