<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secret Santa Studely</title>
    <link rel="stylesheet" href="style/style.css">
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
      <a href="admin.php">Admin</a>
    </nav>
</header>


<section class="home" id="home">
    <div class="form-content">
      <h1>Bienvenue au <span>Secret Santa </span>Studely</h1><br><br><br>
      <h2>Vous désirez offrir des cadeaux et vous en faire offrir ? Essayez notre Secret Santa Studely et découvrez votre père noël à vous !</h2>
    </div>

    <div class="home-img">
        <a href="https://www.studely.com/fr/" target="_blank" alt="Logo de studely"><img src="style/studely.png"></a>
      </div>
    
</section>



<section class="secret" id="secret">
  <div class="form-secret-parent">
    <h1>Pour participer, veuillez <span>remplir</span> le formulaire !</h1>
    
    <div class="form-secret">
      <div class="form-row">
        <label for="prenom">Prénom : </label>
        <input type="text" id="prenom" placeholder="Entre ton prénom">
      </div>
      <div class="form-row">
        <label for="email">Nom : </label>
        <input type="text" id="email" placeholder="Entre ton email">
      </div>
      <button id="valider">Valider</button>
    </div>
    
  </div>
    <br>
    <div id="message" style="margin-top: 20px; font-weight: bold; color: #1d7dde; font-size: 35px; text-align: center; margin-top: 10%;"></div>
</section>


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

<?php include("partiels/footer.php") ?>




<script>
  document.getElementById('valider').addEventListener('click', function(event) {
    // Empêcher le rechargement de la page
    event.preventDefault();

    // Récupérer les valeurs des champs
    const prenom = document.getElementById('prenom').value;
    const email = document.getElementById('email').value;

    // Vérifier si les champs sont remplis
    if (prenom && email) {
      const utilisateur = {
        prenom: prenom,
        email: email
      };

      // Envoyer les données au serveur
      fetch('inscription.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(utilisateur)
      })
      .then(response => response.json())
      .then(data => {
        alert(data.message); // Afficher le message du serveur
      })
      .catch(error => {
        console.error('Erreur:', error);
      });
    } else {
      alert('Veuillez remplir tous les champs !');
    }
  });
</script>


<script src="app.js"></script>
</body>
</html>