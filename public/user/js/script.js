    // Afficher le bouton quand l'utilisateur scrolle vers le bas
    window.onscroll = function() {
        const button = document.getElementById("back-to-top");

        if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
          button.style.display = "block";
        } else {
          button.style.display = "none";
        }
      };

      // Fonction pour remonter en haut de page
      document.getElementById("back-to-top").onclick = function() {
        window.scrollTo({
          top: 0,
          behavior: "smooth" // Pour un défilement fluide
        });
      };



      // Pour l'incremantation
      let count = 1;
const counterElement = document.getElementById('counter');

function increment() {
    if (count < 10) {
        count++;
        counterElement.textContent = count;
    }
}

function decrement() {
    if (count > 1) {
        count--;
        counterElement.textContent = count;
    }
}


