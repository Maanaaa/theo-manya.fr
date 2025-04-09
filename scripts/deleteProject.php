<?php
include("../config/configuration.php");
include("../scripts/connection.php");

$requete = 'DELETE FROM Projets WHERE id_projet ='.$_GET['id_projet'];
$resultats = $connection->exec($requete);
header('Location: ../dashboard.php');