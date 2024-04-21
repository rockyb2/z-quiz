<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/style.css">
    <link rel="stylesheet" href="CSS/acceuil.css">
    <link rel="shortcut icon" href="IMG\icone.jpg" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script src="JS/script.js"></script>
    <title>Acceuil</title>
</head>
<body>
    <header>
        <span class="logo"><a href="index.php">Z_QUIZ</a></span>
        <div class="lien">
            <ul class="liens">
                <li><a href="index.php">acceuil</a></li>
                
                <li><a href="a_propos.php">a propos</a></li>
                <li><a href="identification/connexion.php">connexion</a></li>
               
                <li><a href="utilisateur.php">profile<i class="fa fa-user" aria-hidden="true"></i></a></li>
            </ul>
        </div>
    </header>

    
    <section class="banniere">
    <div class="image-container">
        <img src="IMG/nature.jpg" alt="" class="image">
        <h2 class="color">Tester vos connaissances avec des qcm en rapport avec votre filière 
            et votre culture G...
        </h2>
    </div>
    </section>

    <!-- corps du site  -->
      <section class="corps">
        <div class="categorie">
            <h3>Theme</h3>
            <div class="liste">
                <?php
                    include "PHP/lien.php"
                ?>
            </div>
        </div>
        <?php

include_once('PHP/config.php');

$sql_classement = "SELECT pseudo, moyenne_score FROM (
    SELECT utilisateur.pseudo, AVG(quiz.score) AS moyenne_score
    FROM quiz
    JOIN utilisateur ON quiz.id_Utilisateur = utilisateur.id_Utilisateur
    WHERE quiz.nom_theme = :theme AND quiz.nom_niveau = :niveau
    GROUP BY quiz.id_Utilisateur
    ORDER BY AVG(quiz.score) DESC
) AS classement_general
WHERE moyenne_score IS NOT NULL
ORDER BY moyenne_score DESC
LIMIT 5"; // Limite les résultats aux 5 meilleurs utilisateurs avec une moyenne de score non nulle";
$stmt_classement = $connexionDB->prepare($sql_classement);
$stmt_classement->bindParam(':theme', $_SESSION['theme'], PDO::PARAM_STR);
$stmt_classement->bindParam(':niveau', $_SESSION['niveau'], PDO::PARAM_STR);
$stmt_classement->execute();
$classement = $stmt_classement->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="classement">
    <h3>Classement</h3>
    <?php if (count($classement) > 0) : ?>
        <table>
            <tr>
                <th>Utilisateur</th>
                <th>Moyenne Score</th>
            </tr>
            <?php foreach ($classement as $user) : ?>
                <tr>
                    <td><?= $user['pseudo'] ?></td>
                    <td><?= $user['moyenne_score'] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else : ?>
        <p>Aucun classement pour l'instant</p>
    <?php endif; ?>
</div>

      </section>
          
    
</body>
</html>