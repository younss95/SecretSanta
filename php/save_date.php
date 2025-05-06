<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['date'])) {
    $date = $_POST['date']; // La date envoyée par l'admin

    // Sauvegarde dans un fichier JSON (date.json)
    if (file_put_contents('../config/date.json', json_encode(['date' => $date]))) {
        echo "Date mise à jour avec succès!";
    } else {
        echo "Erreur lors de la mise à jour de la date.";
    }
}
?>
