<?php
// Récupérer la date sauvegardée depuis le fichier (date.json)
if (file_exists('date.json')) {
    $data = json_decode(file_get_contents('date.json'), true);
    echo $data['date']; // ex: 2025-12-25T12:00:00
} else {
    echo '2025-12-31T23:59:59';
}
?>
