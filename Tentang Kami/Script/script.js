let expandedCard = null;

function toggleCard(cardId) {
  const card = document.getElementById(cardId);
  const container = document.querySelector(".container");

  // Jika card lain sudah terbuka, tutup terlebih dahulu
  if (expandedCard && expandedCard !== card) {
    expandedCard.classList.remove("expanded");
    expandedCard.querySelector("button").innerText = "Lihat Selengkapnya";
  }

  // Toggle card yang diklik
  if (card.classList.contains("expanded")) {
    card.classList.remove("expanded");
    card.querySelector("button").innerText = "Lihat Selengkapnya";
    expandedCard = null;
    container.classList.remove("stacked");
  } else {
    card.classList.add("expanded");
    card.querySelector("button").innerText = "Tutup";
    expandedCard = card;
    container.classList.add("stacked");
  }
}
