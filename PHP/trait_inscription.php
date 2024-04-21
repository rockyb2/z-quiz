<?php
session_start();
include_once("config.php");

if (isset($_POST['btn'])) {
    $pseudo = $_POST['pseudo'];
    $email = $_POST['email'];
    $_SESSION['pseudo'] = $pseudo;
    $mdp = password_hash($_POST['mdp'], PASSWORD_DEFAULT);

    // Requête pour vérifier si l'utilisateur existe déjà
    $req = "SELECT pseudo, email FROM utilisateur WHERE pseudo = :pseudo OR email = :email";
    $statement = $connexionDB->prepare($req);
    $statement->bindParam(":pseudo", $pseudo);
    $statement->bindParam(":email", $email);
    $statement->execute();
    $res = $statement->fetch(PDO::FETCH_ASSOC);

    if (!$res) {
        // L'utilisateur n'existe pas, on peut l'insérer
        try {
            // Insertion dans la table "inscription"
            $sql = "INSERT INTO inscription (pseudo, email, motDePasse) VALUES (:pseudo, :email, :mdp)";
            $stmt = $connexionDB->prepare($sql);
            $stmt->bindParam(':pseudo', $pseudo);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':mdp', $mdp);

            if ($stmt->execute()) {
                // Insertion dans la table "utilisateur"
                $sql1 = "INSERT INTO utilisateur (pseudo, email, motDePasse) VALUES (:pseudo, :email, :mdp)";
                $stmt1 = $connexionDB->prepare($sql1);
                $stmt1->bindParam(':pseudo', $pseudo);
                $stmt1->bindParam(':email', $email);
                $stmt1->bindParam(':mdp', $mdp);

                if ($stmt1->execute()) {
                    echo "Inscription réussie";
                    header("Location: ../identification/connexion.php");
                } else {
                    echo "Erreur lors de l'enregistrement dans la table utilisateur";
                }
            } else {
                echo "Erreur lors de l'enregistrement dans la table inscription";
            }
        } catch (Exception $exception) {
            echo "Erreur : " . $exception->getMessage();
        }
    } else {
        echo "Utilisateur déjà enregistré";
    }
} else {
    echo "Erreur : Aucune donnée de formulaire reçue";
}
?>
