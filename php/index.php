<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secret Santa Studely</title>
    <link rel="stylesheet" href="../style/style.css">
    <link
      href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
      rel="stylesheet"
    />
    
</head>
<body>

<header class="header"> 
    <nav class="navbar">
      <a href="#home">Accueil</a>
      <a href="#secret">Secret Santa</a>
      <a href="#decompte">Décompte</a>
      <a href="#admin">Admin</a>
    </nav>
</header>


<!--  SECTION DE BIENVENUE  -->
<section class="home" id="home">
    <div class="form-content">
      <h1>Bienvenue au <span>Secret Santa </span>Studely</h1><br><br><br>
      <h2>Vous désirez offrir des cadeaux et vous en faire offrir ? Essayez notre Secret Santa Studely et découvrez votre <span>père noël</span> à vous !</h2>
    </div>

    <div class="home-img">
        <a href="https://www.studely.com/fr/" target="_blank" alt="Logo de studely"><img src="../style/studely.png"></a>
      </div>
    
</section>



<!--  SECTION DE PARTICIPATION AU SECRET SANTA  -->
<section class="secret" id="secret">
  <div class="form-secret-parent">
    <h1>Pour participer, veuillez <span>remplir</span> le formulaire !</h1>
    
    <div class="form-secret">
      <div class="form-row">
        <label for="prenom">Prénom : </label>
        <input type="text" id="prenom" placeholder="Entre ton prénom">
      </div>
      <div class="form-row">
        <label for="email">Email : </label>
        <input type="text" id="email" placeholder="Entre ton email">
      </div>
      <button id="valider_secret">Valider</button>
    </div>
    
  </div>
    <br>
    <div id="message_secret" style="margin-top: 20px; font-weight: bold; color: #1d7dde; font-size: 35px; text-align: center; margin-top: 10%;"></div>
</section>



<!--  SECTION DU DECOMPTE AVANT LE SECRET SANTA  -->
<section class="decompte" id="decompte">
    <h1>Le <span>décompte: </span></h1>

    <div id="countdown" class="countdown">
      <div class="time">
        <h2 id="days">00</h2>
        <small>Jour</small>
      </div>

      <div class="time">
        <h2 id="hours">00</h2>
        <small>Heures</small>
      </div>

      <div class="time">
        <h2 id="minutes">00</h2>
        <small>Minutes</small>
      </div>

      <div class="time">
        <h2 id="seconds">00</h2>
        <small>Secondes</small>
      </div>
    </div>
    
</section>


<!--  SECTION DE CONNEXION EN ADMIN  -->
<section class="secret" id="admin">
  <div class="form-secret-parent">
    <h1>Pour vous connecter en admin, veuillez <span>remplir</span> le formulaire !</h1>
    <br><br><br>

    <div class="form-secret">
      <div class="form-row">
        <label for="pseudo">Pseudo : </label>
        <input type="text" id="pseudo" placeholder="Entre ton pseudo">
      </div>

      <div class="form-row">
        <label for="mdp">Password : </label>
        <input type="text" id="mdp" placeholder="Entre ton mdp">
      </div>
      
      <button id="valider_admin">Valider</button>
    </div>
    
  </div>
    <br>
    <div id="message_admin" style="margin-top: 20px; font-weight: bold; color: #1d7dde; font-size: 35px; text-align: center; margin-top: 10%;"></div>
</section>

<?php include("../partiels/footer.php") ?>




<!--  SCRIPT JS POUR RECUPERER LES VALEURS DU FORMULAIRE  -->
<script>
  document.getElementById('valider_secret').addEventListener('click', function(event) {
    // Empêcher le rechargement de la page
    event.preventDefault();

    const prenom = document.getElementById('prenom').value;
    const email = document.getElementById('email').value;


    if (prenom && email) {
      const utilisateur = {
        prenom: prenom,
        email: email
      };

      // Envoyer les données au serveur
      fetch('../php/inscription.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(utilisateur)
      })
      .then(response => response.json())
      .then(data => {
      })
      .catch(error => {
        console.error('Erreur:', error);
      });
    } else {
      alert('Veuillez remplir tous les champs !');
    }
  });
</script>


<!--  SECTION JS POUR GERER LA SOUMISSION D'UN FORMULAIRE POUR UN ADMIN   -->
<script>
  document.getElementById('valider_admin').addEventListener('click', function(event) {
    event.preventDefault();

    const pseudo = document.getElementById('pseudo').value.trim();
    const mdp = document.getElementById('mdp').value.trim();

    if (pseudo && mdp) {
      fetch('../php/verif_admin.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ pseudo: pseudo, mdp: mdp })
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          window.location.href = '../php/adminco.php';
        } else {
          document.getElementById('message_admin').textContent = data.message;
        }
      })
      .catch(error => {
        console.error('Erreur :', error);
      });
    } else {
      document.getElementById('message_admin').textContent = 'Veuillez remplir tous les champs.';
    }
  });
</script>





<script src="../js/app.js"></script>
</body>
</html>