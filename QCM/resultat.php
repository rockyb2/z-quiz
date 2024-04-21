<?php
session_start();
include_once('../PHP/config.php');

// req pour recup l'id du user
$id_utilisateur = null;
if (isset($_SESSION['pseudo_user'])) {
    $pseudo_user = $_SESSION['pseudo_user'];
    $sql_user = "SELECT id_Utilisateur FROM utilisateur WHERE pseudo = :pseudo_user";
    $stmt_user = $connexionDB->prepare($sql_user);
    $stmt_user->bindParam(':pseudo_user', $pseudo_user, PDO::PARAM_STR);
    $stmt_user->execute();
    $user = $stmt_user->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        $id_utilisateur = $user['id_Utilisateur'];
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../IMG\icone.jpg" type="image/x-icon">
    <link rel="stylesheet" href="../CSS/resultats.css">
    <title>Resultats</title>
    <!-- du js pour gérer les interaction -->
    <script>
  let clics = 0; // Initialiser le compteur de clics à 0

  // Fonction pour gérer les clics sur la page
  document.addEventListener('click', function() {
    clics++; // Incrémenter le compteur à chaque clic

    // Rediriger vers la page d'accueil après 3 clics
    if (clics === 3) {
      window.location.href = "../index.php"; // Remplacer '/' par l'URL de votre page d'accueil
    }
  });
</script>
</head>
<body>
    

<section class="resultats">
    <h1>Résultat du QCM de
        <span class="change_color"><?php echo $_SESSION ['pseudo_user'] ?></span>
    </h1>
    <?php
    
    
    $note = 0;
    

    foreach ($_POST as $cle => $val) {
        // $cle représente idq (identifiant de la question) et $val représente idr 

        // cette requête nous permet d'afficher les bonnes réponses
        $req = "SELECT * FROM reponse WHERE id_Reponse= :val AND est_correcte = 1";
        $stm = $connexionDB->prepare($req);
        $stm->bindParam(":val", $val, PDO::PARAM_INT);
        $stm->execute();

        // Vous pouvez maintenant utiliser fetch pour obtenir les résultats de la requête
        $resultat = $stm->fetch(PDO::FETCH_ASSOC);

        if ($resultat) {
            // si cette requête retourne une ligne, on ajoute 4 à la note
            $note += 4;
        } else {
            ?>
            <p class="color">Tu t'es planté à la question <?=$cle?>: </p>
            <?php
            // liste des questions qui ont été mal répondues
            $req2 = "SELECT * FROM question WHERE id_Question = :cle";
            $statement = $connexionDB->prepare($req2);
            $statement->bindParam(":cle", $cle, PDO::PARAM_INT);
            $statement->execute();
            $res = $statement->fetch(PDO::FETCH_ASSOC);
            $ligne = $res;
            ?>
            <p class="question_error"><?=$ligne['enonce']?></p>
            <p class="color">Il fallait répondre:</p>
            <?php

            // liste des réponses qui étaient correctes pour la question
            $req3 = "SELECT * FROM reponse WHERE id_Question = :cle AND est_correcte = 1";
            $statement = $connexionDB->prepare($req3);
            $statement->bindParam(":cle", $cle, PDO::PARAM_INT);
            $statement->execute();
            $res2 = $statement->fetch(PDO::FETCH_ASSOC);
            $ligne2 = $res2;
            ?>
            <p class="reponse_vrai"><?=$ligne2['enonce']?></p>
            <?php
        }
    }

    // Insertion des résultats dans la table quiz
    $sql_quiz = "INSERT INTO quiz (id_Utilisateur, nom_theme, nom_niveau, score) VALUES (:id_utilisateur, :theme, :niveau, :score)";
    $stmt_quiz = $connexionDB->prepare($sql_quiz);
    $stmt_quiz->bindParam(':id_utilisateur', $id_utilisateur, PDO::PARAM_INT);
    $stmt_quiz->bindParam(':theme',  $_SESSION['theme'], PDO::PARAM_STR);
    $stmt_quiz->bindParam(':niveau',$_SESSION['niveau'], PDO::PARAM_STR);
    $stmt_quiz->bindParam(':score', $note, PDO::PARAM_INT);
    $stmt_quiz->execute();

    ?>
    <p class="change_color">Tu as obtenu <?=$note?>/20</p>

    <script> alert("cliquer 3 fois pour retourner à la page d'acceuil")</script>
</section>

</body>
</html>
