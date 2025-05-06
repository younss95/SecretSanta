<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // PHPMailer installé via Composer

try {
    $pdo = new PDO('mysql:host=localhost;dbname=secretsanta', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Vérifier l'état de l'algorithme
    $stmt = $pdo->query("SELECT status FROM execution WHERE id = 1");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row['status'] === 'executed') {
        echo "❗ Secret Santa a déjà été exécuté. Si tu veux réexécuter, réinitialise la base de données.";
        exit;
    }

} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// Lire les participants
$stmt = $pdo->query("SELECT prenom, email FROM participants");
$participants = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
    $mail->Username = 'studelysanta@gmail.com'; // ton adresse Gmail
    $mail->Password = 'cesl hzsj pfrk huta';     // mot de passe d'application
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Envoyer les mails
    foreach ($participants as $p) {
        $receiver = $assignations[$p['email']];
        $email = $p['email'];

        try {
            $mail->setFrom('studelysanta@gmail.com', 'Secret Santa');
            $mail->addAddress($email, $p['prenom']);
            $mail->Subject = 'Secret Santa - Ton destinataire !';
            $mail->Body    = "Bonjour {$p['prenom']},\n\nTu dois offrir un cadeau à : $receiver 🎁\n\nJoyeux Noël !";
            $mail->isHTML(false);

            $mail->send();
            // Historique
            file_put_contents("emails_envoyes.txt", "$email => $receiver\n", FILE_APPEND);
            $mail->clearAddresses();
        } catch (Exception $e) {
            echo "Erreur d'envoi à {$p['prenom']} ({$email}): {$mail->ErrorInfo}\n";
        }
    }

    // Mise à jour du statut dans la base de données
    $pdo->exec("UPDATE execution SET status = 'executed', last_executed = NOW() WHERE id = 1");

} catch (Exception $e) {
    echo "❌ Erreur d'envoi : {$mail->ErrorInfo}";
}

echo "Envoi à : {$p['prenom']} ({$email}) -> $receiver<br>";
?>
