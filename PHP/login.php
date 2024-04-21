<?php 
    session_start();
    include_once("config.php");

    if(isset($_POST['btn'])){
    // on récupère les donner du formulaire
    
    $pseudo_user = $_POST["pseudo"];
    $mdp= $_POST["mdp"];
   
    // verifier si les donnée entré corespondent
    $query = "SELECT * FROM utilisateur WHERE pseudo = :pseudo";
    $stmt = $connexionDB->prepare($query);
    $stmt->bindParam(':pseudo', $pseudo_user);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($mdp, $user['motDePasse'])) {
        // Si les informations sont correctes, crée une session pour l'utilisateur
       $_SESSION ['pseudo_user'] = $pseudo_user;
        header('Location: ../index.php'); // Redirige l'utilisateur vers la page de bienvenue
        exit; // Met fin au script actuel
    } else {
        echo 'Identifiants incorrects. Veuillez réessayer.';
    }

    }

?>