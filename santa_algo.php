<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // PHPMailer installé via Composer

// Bloquer la réexécution si déjà fait
$file = 'algo_executed.txt';

if (file_exists($file)) {
    echo "❗ Secret Santa déjà exécuté.";
    exit;
}
file_put_contents($file, 'done');

// Lire les participants
$participants = json_decode(file_get_contents('participants.json'), true);

// Mélanger et assigner
shuffle($participants);
$assignations = [];
$maxTries = 100;

for ($try = 0; $try < $maxTries; $try++) {
    $receivers = $participants;
    shuffle($receivers);
    $valid = true;
    $assignations = [];

    for ($i = 0; $i < count($participants); $i++) {
        if ($participants[$i]['email'] === $receivers[$i]['email']) {
            $valid = false;
            break;
        }
        if (
            isset($assignations[$receivers[$i]['email']]) &&
            $assignations[$receivers[$i]['email']] === $participants[$i]['email']
        ) {
            $valid = false;
            break;
        }
        $assignations[$participants[$i]['email']] = $receivers[$i]['prenom'];
    }

    if ($valid) break;
}

if (!$valid) {
    http_response_code(500);
    echo "Erreur : Impossible de faire les assignations sans conflit.";
    exit;
}

// Configurer PHPMailer
$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'younesazirgui@gmail.com'; // ton adresse Gmail
    $mail->Password = 'dbva aynb kayx xshg';     // mot de passe d'application
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;


    // Envoyer les mails
    foreach ($participants as $p) {
        $receiver = $assignations[$p['email']];
        $email = $p['email'];

        $mail->setFrom('younesazirgui@gmail.com', 'Secret Santa');
        $mail->addAddress($email, $p['prenom']);
        $mail->Subject = 'Secret Santa - Ton destinataire !';
        $mail->Body    = "Bonjour {$p['prenom']},\n\nTu dois offrir un cadeau à : $receiver 🎁\n\nJoyeux Noël !";
        $mail->isHTML(false);

        $mail->send();

        // Historique
        file_put_contents("emails_envoyes.txt", "$email => $receiver\n", FILE_APPEND);
        $mail->clearAddresses();
    }

    echo "✅ Mails envoyés avec succès via Mailtrap.";
} catch (Exception $e) {
    echo "❌ Erreur d'envoi : {$mail->ErrorInfo}";
}

echo "Envoi à : {$p['prenom']} ({$email}) -> $receiver<br>";
?>
