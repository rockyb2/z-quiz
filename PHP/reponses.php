<?php
    include_once("config.php") ;
    include "trait_inscription.php";

?>


<section class="resultats">
        
        <h1>Résultat du QCM de
            <span class="change_color"><?php echo $_SESSION['pseudo'] ?></span>
        </h1>
        <?php
        
        $note = 0;

        foreach ($_POST as $cle => $val) {
            // $cle représente idq (identifiant de la question) et $val représente idr 

            // cette requête nous permet d'afficher les bonnes réponses
            $req = "SELECT * FROM reponse WHERE idr= :val AND verite = 1";
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
                $req2 = "SELECT * FROM questions WHERE idq = :cle";
                $statement = $connexionDB->prepare($req2);
                $statement->bindParam(":cle", $cle, PDO::PARAM_INT);
                $statement->execute();
                $res = $statement->fetch(PDO::FETCH_ASSOC);
                $ligne = $res;
                ?>
                <p class="question_error"><?=$ligne['libelleQ']?></p>
                <p class="color">Il fallait répondre:</p>
                <?php

                // liste des réponses qui étaient correctes pour la question
                $req3 = "SELECT * FROM reponses WHERE idq = :cle AND verite = 1";
                $statement = $connexionDB->prepare($req3);
                $statement->bindParam(":cle", $cle, PDO::PARAM_INT);
                $statement->execute();
                $res2 = $statement->fetch(PDO::FETCH_ASSOC);
                $ligne2 = $res2;
                ?>
                <p class="reponse_vrai"><?=$ligne2['libeller']?></p>
                <?php
            }
        }
        ?>
        <p class="change_color">Tu as obtenu <?=$note?>/20</p>

       
    <?php 
    
    // // Insérer le score dans la table note en utilisant l'ID de l'utilisateur
    // $sql = "INSERT INTO note (score) VALUES (:score)";
    // $statement = $connexionDB->prepare($sql);
    //  $statement->bindParam(':score', $note, PDO::PARAM_INT);
    
   
    // $statement->execute();

    ?> 
    </section>