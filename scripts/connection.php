<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// option pour la gestion de l'encodage
$options=array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES ".$encodage);

// Gestion des erreurs avec try catch
try
{
    $connection = new PDO('mysql:host='.$hote.';port='.$port.';dbname='.$nom_bd,$identifiant, $mot_de_passe,$options);
    if($debug)
    {
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
} catch (PDOException $erreur)
{
    echo "Serveur actuellement innaccessible, veuillez nous excuser.";
    exit();
}
?>
