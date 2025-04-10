<?php
include("../config/configuration.php");
include("../scripts/connection.php");
include("../scripts/fonctions.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titre = $_POST["titre"];
    $description = $_POST["description"];
    $id_competence = $_POST["id_competence"];
    $date = $_POST["date"];
    $lien = $_POST["lien"];
    $file_min_size = 0;
    $file_max_size = 10000000;

    if($titre == "" OR $description == "" OR $id_competence == "" OR $date == ""){header("Location: ../dashboard.php"); exit;}

    // Récupérer le dernier id pour pouvoir nommer l'image en projet$dernierId+1
    $requete = 'SELECT MAX(id_projet) AS dernier_id FROM Projets';
    $resultats = $connection->query($requete);
    $dernier_id = $resultats->fetch(PDO::FETCH_ASSOC)['dernier_id'];
    $nouvel_id = $dernier_id + 1;

    // dossier cible
    $content_dir = "../img/projets/";
    $allowed_extensions = ["jpg", "png"];

    if (($_FILES["image"]["size"] > $file_min_size) && ($_FILES["image"]["size"] < $file_max_size)) {
        $result = uploadFile($_FILES["image"], $content_dir, $allowed_extensions, $file_max_size, $connection);
        if ($result !== false) {
            $get_the_file = $result;

            // Ajouter le projet dans la base de données
            $requete = 'INSERT INTO Projets (id_projet, titre, description, lien, id_competence, image, date) VALUES (:id_projet, :titre, :description, :lien, :id_competence, :image, :date)';
            $resultats = $connection->prepare($requete);
            $resultats->bindParam(':id_projet', $nouvel_id);
            $resultats->bindParam(':titre', $titre);
            $resultats->bindParam(':description', $description);
            $resultats->bindParam(':lien', $lien);
            $resultats->bindParam(':id_competence', $id_competence);
            $resultats->bindParam(':image', $get_the_file);
            $resultats->bindParam(':date', $date);
            $resultats->execute();

            // Insérer dans la table de liaison ProjetCompetences
            $requete_liaison = 'INSERT INTO ProjetCompetences (id_projet, id_competence) VALUES (:id_projet, :id_competence)';
            $resultats_liaison = $connection->prepare($requete_liaison);
            $resultats_liaison->bindParam(':id_projet', $nouvel_id);
            $resultats_liaison->bindParam(':id_competence', $id_competence);
            $resultats_liaison->execute();

            header("Location: ../dashboard.php");
        }
    } elseif ($_FILES["image"]["size"] > $file_max_size) {
        echo "Le fichier dépasse la limite autorisée";
    } else {
        echo "Pas de fichier joint";
    }
}
?>
