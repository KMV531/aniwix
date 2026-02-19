const loginBg = document.getElementById("login-bg");

const backgroundImages = [
  "../assets/anime-maids.jpg",
  "../assets/desktop-wallpaper-i-wanna-be-a-master-anime-netoge.jpg",
  "../assets/greeting-master.jpg",
  "../assets/maid.jpg",
  "../assets/okamisan4-1.jpg",
  "../assets/welcome-home-v0.webp",
];

function changeBackground() {
  const randomIndex = Math.floor(Math.random() * backgroundImages.length);
  loginBg.style.backgroundImage = `url(${backgroundImages[randomIndex]})`;
}

setInterval(changeBackground, 5000);

changeBackground();
