<?php
header('Content-Type: application/json');

try {
    $pdo = new PDO('mysql:host=localhost;dbname=secretsanta', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Erreur de connexion à la base de données']);
    exit;
}

// Récupérer les données JSON envoyées
$data = json_decode(file_get_contents("php://input"), true);
$prenom = trim($data['prenom'] ?? '');
$email = trim($data['email'] ?? '');

// Vérification si les champs sont vides
if ($prenom === '' || $email === '') {
    echo json_encode(['error' => 'Champs manquants.']);
    exit;
}

// Vérification de l'email au bon format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['error' => 'Adresse email invalide.']);
    exit;
}

// Vérifier si l'email existe déjà
$stmt = $pdo->prepare("SELECT COUNT(*) FROM participants WHERE email = ?");
$stmt->execute([$email]);
$exists = $stmt->fetchColumn();

if ($exists) {
    echo json_encode(['error' => 'Cette adresse e-mail est déjà enregistrée.']);
    exit;
}

// Insérer dans la table
$stmt = $pdo->prepare("INSERT INTO participants (prenom, email) VALUES (?, ?)");
$stmt->execute([$prenom, $email]);

echo json_encode(['message' => 'Participant enregistré.']);
