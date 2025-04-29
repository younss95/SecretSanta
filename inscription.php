<?php
// Chemin du fichier JSON
$fichier = 'participants.json';

// Récupérer les données JSON envoyées par JavaScript
$data = file_get_contents('php://input');
$utilisateur = json_decode($data, true);

// Charger les utilisateurs existants
$utilisateurs = [];
if (file_exists($fichier)) {
    $json = file_get_contents($fichier);
    $utilisateurs = json_decode($json, true);
}

// Ajouter le nouvel utilisateur
$nouvel_utilisateur = [
    'prenom' => $utilisateur['prenom'],
    'email' => $utilisateur['email']
];

$utilisateurs[] = $nouvel_utilisateur;

// Sauvegarder dans le fichier JSON
file_put_contents($fichier, json_encode($utilisateurs, JSON_PRETTY_PRINT));


?>
