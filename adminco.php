<?php
session_start();
if(!isset($_SESSION['admin'])){
    header('Location: index.php');
    exit();
}
?>



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

    <style>

    h1 {
      text-align: center;
      color: #1d7dde;
      margin-top: 60px;
    }

    table {
      width: 80%;
      margin: 20px auto;
      border-collapse: collapse;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      margin-bottom: 60px;
    }

    th, td {
      padding: 12px;
      border: 1px solid #ccc;
      text-align: center;
      font-size: 15px
    }

    th {
      background-color: #1d7dde;
      color: white;
    }
  </style>
    
</head>

<body>

<header class="header">
        

    
    <nav class="navbar">
      <a href="#home">Accueil</a>
      <a href="#json">Participants</a>
      <a href="logout.php">Déconnexion</a>
    </nav>
</header>


<section class="home" id="home">
    <div class="form-content">
      <h1>Vous etes connecté en <span>admin </span></h1>
    </div>

    <div class="home-img">
        <a href="https://www.studely.com/fr/" target="_blank"><img src="style/studely.png"></a>
      </div>
    
</section>


<section class="home" id="json">
    <div class="form-content">
      <h1>Les participants au <span>Secret Santa </span>Studely</h1>
    </div>

    <?php 
    $filename = 'participants.json';
    if (file_exists($filename)){
        $json = file_get_contents($filename);
        $participants = json_decode($json, true);

        if (!empty($participants)) {
            echo '<table>';
            echo '<tr><th>Prénom</th><th>Email</th></tr>';
    
            foreach ($participants as $participant) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($participant['prenom']) . '</td>';
                echo '<td>' . htmlspecialchars($participant['email']) . '</td>';
                echo '</tr>';
            }
    
            echo '</table>';
        } else {
            echo '<p style="text-align:center;">Aucun participant enregistré.</p>';
        }
    } else {
        echo '<p style="text-align:center; color: red;">Fichier participants.json introuvable.</p>';
    }

    ?>
    
</section>

<?php include("partiels/footer.php") ?>


<script src="app.js"></script>
</body>
</html>