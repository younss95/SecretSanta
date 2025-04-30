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
      <a href="#secret">Connexion</a>
      <a href="logout.php">Retour</a>
    </nav>
</header>


<section class="home" id="home">
    <div class="form-content">
      <h1>Vous etes sur la page <span>admin </span></h1>
    </div>

    <div class="home-img">
        <a href="https://www.studely.com/fr/" target="_blank"><img src="style/studely.png"></a>
      </div>
</section>


<section class="secret" id="secret">
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
      
      <button id="valider">Valider</button>
    </div>
    
  </div>
    <br>
    <div id="message" style="margin-top: 20px; font-weight: bold; color: #1d7dde; font-size: 35px; text-align: center; margin-top: 10%;"></div>
</section>


<?php include("partiels/footer.php") ?>

<script>
  document.getElementById('valider').addEventListener('click', function(event) {
    event.preventDefault();

    const pseudo = document.getElementById('pseudo').value.trim();
    const mdp = document.getElementById('mdp').value.trim();

    if (pseudo && mdp) {
      fetch('verif_admin.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ pseudo: pseudo, mdp: mdp })
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          window.location.href = 'adminco.php';
        } else {
          document.getElementById('message').textContent = data.message;
        }
      })
      .catch(error => {
        console.error('Erreur :', error);
      });
    } else {
      document.getElementById('message').textContent = 'Veuillez remplir tous les champs.';
    }
  });
</script>

<script src="app.js"></script>
</body>
</html>