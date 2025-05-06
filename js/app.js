/*  PARTIE POUR AFFICHER UN MESSAGE DE REMERCIEMENT PERSONALISE  */
document.getElementById('valider_secret').addEventListener('click', function(event) {
  // Empêcher le rechargement de la page
  event.preventDefault();

  const prenom = document.getElementById('prenom').value;
  const email = document.getElementById('email').value;

  // Fonction de validation de l'email avec une regex
  function isValidEmail(email) {
    const regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    return regex.test(email);
  }

  // Vérifier que le format de l'email est correct
  if (prenom && email) {
    if (!isValidEmail(email)) {
      document.getElementById('message_secret').innerHTML = "<span style='color: red;'>Veuillez entrer une adresse email valide.</span>";
      return; // Arrêter l'exécution ici si l'email est invalide
    }

    const utilisateur = {
      prenom: prenom,
      email: email
    };

    // Si l'email est valide, envoyer les données au serveur
    fetch('../php/inscription.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(utilisateur)
    })
        .then(response => response.json())
        .then(data => {
          // Vérifier la réponse et afficher un message
          if (data.message) {
            document.getElementById('message_secret').innerHTML = "Merci <span>" + prenom + "</span>, ta participation a été enregistrée !";
          } else if (data.error) {
            document.getElementById('message_secret').innerHTML = "<span style='color: red;'>Erreur : " + data.error + "</span>";
          } else {
            document.getElementById('message_secret').innerHTML = "<span style='color: red;'>Une erreur inattendue est survenue.</span>";
          }
        })
        .catch(error => {
          console.error('Erreur:', error);
          document.getElementById('message_secret').innerHTML = "<span style='color: red;'>Une erreur réseau est survenue.</span>";
        });
  } else {
    document.getElementById('message_secret').innerHTML = "<span style='color: red;'>Veuillez remplir tous les champs !</span>";
  }
});






/*  PARTIE POUR LE GESTIONNAIRE DU TEMPS  */
let timer;

function startCountdown(targetDate) {
  clearInterval(timer);

  const dateObj = new Date(targetDate);
  if (isNaN(dateObj.getTime())) {
    console.error("Date invalide :", targetDate);
    return;
  }

  function update() {
    const now = new Date();
    const diff = dateObj - now;
    if (diff <= 0) {
      clearInterval(timer);
  
      // Appel vers le backend pour lancer le Secret Santa
      fetch('../php/santa_algo.php')
        .then(res => res.text())
        .then(data => console.log('🎁 Secret Santa lancé :', data))
        .catch(error => console.error('Erreur Secret Santa:', error));
  
      return;
    }

    const s = Math.floor(diff / 1000);
    const d = Math.floor(s / 86400);
    const h = Math.floor((s % 86400) / 3600);
    const m = Math.floor((s % 3600) / 60);
    const sec = s % 60;

    document.getElementById('days').textContent = d.toString().padStart(2, '0');
    document.getElementById('hours').textContent = h.toString().padStart(2, '0');
    document.getElementById('minutes').textContent = m.toString().padStart(2, '0');
    document.getElementById('seconds').textContent = sec.toString().padStart(2, '0');
  }

  update();
  timer = setInterval(update, 1000);
}

// Appel initial
fetch('../php/get_date.php')
  .then(res => res.text())
  .then(date => {
    console.log("📅 Date reçue depuis get_date.php :", date);
    startCountdown(date);
  })
  .catch(error => console.error('Erreur de récupération de la date:', error));

