<?php
session_start();
if(!isset($_SESSION['admin'])){
    header('Location: index.php');
    exit();
}

// Connexion à la base de données
try {
    $pdo = new PDO('mysql:host=localhost;dbname=secretsanta', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Erreur de connexion à la base de données : ' . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secret Santa Studely</title>
    <link rel="stylesheet" href="../style/style.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
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
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
        <a href="#decompte">Gestion du décompte </a>
        <a href="logout.php">Déconnexion</a>
    </nav>
</header>

<!-- SECTION DE BIENVENUE -->
<section class="home" id="home">
    <div class="form-content">
        <h1>Vous êtes connecté en <span>admin</span></h1>
    </div>

    <div class="home-img">
        <a href="https://www.studely.com/fr/" target="_blank"><img src="../style/studely.png"></a>
    </div>
</section>

<!-- SECTION TABLEAU DES PARTICIPANTS -->
<section class="home" id="json">
    <div class="form-content">
        <h1>Les participants au <span>Secret Santa</span> Studely !</h1>
    </div>

    <?php
    // Requête SQL pour récupérer les participants
    $stmt = $pdo->prepare("SELECT * FROM participants");
    $stmt->execute();
    $participants = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($participants)) {
        echo '<table>';
        echo '<tr><th>Prénom</th><th>Email</th><th>Action</th></tr>';

        foreach ($participants as $participant) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($participant['prenom']) . '</td>';
            echo '<td>' . htmlspecialchars($participant['email']) . '</td>';
            echo '<td>
                    <form method="post" style="margin:0;">
                        <input type="hidden" name="delete_email" value="' . htmlspecialchars($participant['email']) . '">
                        <button type="submit" onclick="return confirm(\'Confirmer la suppression ?\')">Supprimer</button>
                    </form>
                  </td>';
            echo '</tr>';
        }

        echo '</table>';
    } else {
        echo '<p style="text-align:center;">Aucun participant enregistré.</p>';
    }
    ?>

    <?php
    // Suppression d'un participant
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_email'])) {
        $delete_email = $_POST['delete_email'];

        // Requête SQL pour supprimer un participant par email
        $stmt = $pdo->prepare("DELETE FROM participants WHERE email = ?");
        $stmt->execute([$delete_email]);

        // Redirection vers la même page pour recharger les données
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
    ?>
</section>

<!-- SECTION GESTION DU DECOMPTE -->
<section class="decomptead" id="decompte">
    <h1>Modifier la date du <span>décompte:</span></h1>

    <form id="updateForm" method="POST" style="text-align:center; margin-top: 30px;">
        <label for="date" style="font-size:x-large">Nouvelle date de décompte :</label><br><br>
        <input type="datetime-local" id="date" name="date" required>
        <button type="submit">Mettre à jour</button>
    </form>
</section>

<!-- SCRIPT PHP POUR ENREGISTRER LE RESULTAT DE L'ADMIN SUR LA DATE -->
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['date'])) {
    $date = $_POST['date'];

    if (file_put_contents('../config/date.json', json_encode(['date' => $date]))) {
        echo "Date mise à jour avec succès : $date";
    } else {
        echo "Erreur.";
    }
}
?>

<?php include("../partiels/footer.php") ?>

<script src="../js/app.js"></script>
</body>
</html>
