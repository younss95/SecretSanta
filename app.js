/*  PARTIE POUR AFFICHER UN MESSAGE DE REMERCIEMENT PERSONALISE  */
document.getElementById('valider').addEventListener('click', function(){
    let prenom = document.getElementById('prenom').value.trim();
    let nom = document.getElementById('email').value.trim();

    if(prenom!=="" && nom!==""){
        document.getElementById('message').innerHTML = "Merci <span> " + prenom + "</span>"+ " pour ta participation !";
    }
    else{
        document.getElementById('message').textContent = "Merci de remplir correctement le formulaire ! ";
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
      fetch('santa_algo.php')
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
fetch('get_date.php')
  .then(res => res.text())
  .then(date => {
    console.log("📅 Date reçue depuis get_date.php :", date);
    startCountdown(date);
  })
  .catch(error => console.error('Erreur de récupération de la date:', error));


  
