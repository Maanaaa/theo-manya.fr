<?php
function uploadFile($file, $content_dir, $allowed_extensions, $file_max_size, $connection) {
    // Vérifier la présence d'un fichier à uploader
    if (isset($file["tmp_name"])) {
        $tmp_file = $file["tmp_name"];

        // Vérifier si le fichier a été téléchargé correctement
        if (!is_uploaded_file($tmp_file)) {
            echo "Fichier non trouvé";
            return false;
        }

        $path = $file["name"];
        $ext = pathinfo($path, PATHINFO_EXTENSION);

        // Vérifier l'extension du fichier
        if (!in_array(strtolower($ext), $allowed_extensions)) {
            echo "EXTENSION " . $ext . " NON AUTORISEE";
            return false;
        }

        // Vérifier la taille du fichier
        if ($file["size"] > $file_max_size) {
            echo "Le fichier dépasse la limite autorisée";
            return false;
        }

        // Récupérer le dernier ID de projet pour nommer l'image
        $requete = 'SELECT MAX(id_projet) AS dernier_id FROM Projets';
        $resultats = $connection->query($requete);
        $dernier_id = $resultats->fetch(PDO::FETCH_ASSOC)['dernier_id'];
        $nouvel_id = $dernier_id + 1;

        // Nommer le fichier avec le nouvel ID du projet
        $name_file = "projet" . $nouvel_id . "." . $ext;
        if (!move_uploaded_file($tmp_file, $content_dir . $name_file)) {
            echo "Impossible de copier le fichier dans le dossier cible";
            return false;
        }

        return $content_dir . $name_file;
    } else {
        echo "Pas de fichier joint";
        return false;
    }
}

// Supprimer des données (pour éviter d'avoir plusieurs fichiers deleteX...)

function deleteData($table, $id, $get){
    include("../config/configuration.php");
    include("../scripts/connection.php");

    // Exemple d'utlisation : deleteData("Competences", "id_competence", "id_competence");
    //      Au lieu de :
    //              $requete = 'DELETE FROM Competences WHERE id_competence ='.$_GET['id_competence'];
    //              $resultats = $connection->exec($requete);
    //              header('Location: ../dashboard.php');
    // ------------------------------------------------------------

    $requete = 'DELETE FROM' .$table .'WHERE' .$id . ' = :value';
    $resultats = $connection->exec($requete);
    $resultats->bindParam(':value', $_GET[$get], PDO::PARAM_INT);

    $stmt->execute();
}