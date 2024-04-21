<?php
session_start();

include('../PHP/config.php');

$nom_user = $_SESSION['pseudo_user'];
$nom_theme = $_SESSION['theme'];
$nom_niveau = $_SESSION['niveau'];

$theme = $nom_theme; // Assurez-vous que $theme et $niveau sont initialisés correctement
$niveau = $nom_niveau;

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../IMG\icone.jpg" type="image/x-icon">
    <link rel="stylesheet" href="../CSS/quiz.css">
    <title>QCM <?php echo $nom_theme?></title>
</head>
<body>
    <h1>QCM: <?php echo $nom_theme ?> niveau <?php echo $nom_niveau?></h1>
    
    <form action="resultat.php" method="post">
        <ol>
<?php 
        $question_sql = "SELECT id_Question, enonce FROM question WHERE nom_Theme = :theme AND nom_Niveau = :niveau ORDER BY RAND() LIMIT 5";
        $statement_question = $connexionDB->prepare($question_sql);
        $statement_question->bindParam(':theme', $theme, PDO::PARAM_STR);
        $statement_question->bindParam(':niveau', $niveau, PDO::PARAM_STR);
        $statement_question->execute();

        while ($question = $statement_question->fetch(PDO::FETCH_ASSOC)) {
            $id_question = $question['id_Question'];

            $reponse_sql = "SELECT id_Reponse, enonce FROM reponse WHERE id_Question = :id_question";
            $statement_reponse = $connexionDB->prepare($reponse_sql);
            $statement_reponse->bindParam(':id_question', $id_question, PDO::PARAM_INT);
            $statement_reponse->execute();

?>
            <li>
                <h3 class="question"><?= $question['enonce'] ?></h3>
                <ul>
<?php 
                while ($reponse = $statement_reponse->fetch(PDO::FETCH_ASSOC)) {
?>
                    <li>
                        <input type="radio" name="<?= $id_question ?>" value="<?= $reponse['id_Reponse'] ?>" required>
                        <?= $reponse['enonce'] ?>
                    </li>
<?php 
                }
?>
                </ul>
            </li>
<?php 
        }
?><input type="submit" class="style_btn" value="Envoyer">
        </ol>
        
    </form>

</body>
</html>
