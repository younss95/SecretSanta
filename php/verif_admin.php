<?php
session_start();

$input = json_decode(file_get_contents('php://input'), true);

if ($input['pseudo'] === 'admin' && $input['mdp'] === 'admin') {
    $_SESSION['admin'] = true;
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Identifiants incorrects']);
}
