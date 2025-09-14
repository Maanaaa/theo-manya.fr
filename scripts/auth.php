<?php
$ROOT = dirname(__DIR__);
require_once $ROOT . '/config/configuration.php';
require_once $ROOT . '/scripts/connection.php';
require_once $ROOT . '/scripts/fonctions.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Table paramètres (clé-valeur)
$connection->exec("
    CREATE TABLE IF NOT EXISTS Settings (
        cle    VARCHAR(64)  PRIMARY KEY,
        valeur VARCHAR(255) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

// Récupération ou création du code d'accès
$requete = "SELECT valeur FROM Settings WHERE cle = 'dashboard_code' LIMIT 1";
$resultats = $connection->query($requete);
$code = $resultats->fetch(PDO::FETCH_ASSOC);
$resultats->closeCursor();

if(!$code || $code['valeur'] === "") {
    // Générer un code à 4 caractères (chiffres, lettres majuscules et minuscules)
    $alphabet = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $codeGenere = '';
    for ($i = 0;$i < 4;$i++) {
        $codeGenere .= $alphabet[random_int(0, strlen($alphabet) - 1)];
    }

    $requete = 'INSERT INTO Settings (cle, valeur) VALUES (:cle, :valeur)';
    $stmt = $connection->prepare($requete);
    $stmt->bindParam(':cle', $cle);
    $stmt->bindParam(':valeur', $codeGenere);
    $cle = 'dashboard_code';
    $stmt->execute();
}

if(!empty($_SESSION['authenticated']) && $_SESSION['authenticated'] === true) {
    // L'utilisateur est déjà authentifié
    return;
}

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['code'])) {
    $codeSaisi = $_POST['code'];

    // Vérifier le code saisi
    $requete = "SELECT valeur FROM Settings WHERE cle = 'dashboard_code' LIMIT 1";
    $resultats = $connection->query($requete);
    $code = $resultats->fetch(PDO::FETCH_ASSOC);
    $resultats->closeCursor();

    if($code && $codeSaisi === $code['valeur']) {
        // Code correct, authentifier l'utilisateur
        $_SESSION['authenticated'] = true;
        // Rediriger vers la page demandée ou la page d'accueil du dashboard
        header('Location: ../dashboard.php');
        exit();
    } else {
        header("Location: ../login.php");
        exit();
    }
}

// Si l'utilisateur n'est pas connecté, rediriger au login
header("Location: ../login.php");
exit();


?>