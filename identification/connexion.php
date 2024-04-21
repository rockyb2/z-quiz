<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="shortcut icon" href="../IMG\icone.jpg" type="image/x-icon">
    <title>Connexion</title>
</head>
<body>
    <header>
        <span class="logo"><a href="../index.php">Z_QUIZ</a></span>
        <div class="lien">
            <ul class="liens">
                
                <!-- <li><a href="../index.php">acceuil</a></li>
                <li><a href="../quiz.php">quiz</a></li>
                <li><a href="../classement.php">classement</a></li>
                 -->
            </ul>
        
    </header>

    <main>
      
            <img src="../IMG/vert.jpg" class="img" alt="">
            
        
    
        <form action="../PHP/login.php" method="post" class="form">
            <h1>connexion</h1>

            <div class="champ">
                
                <input type="text" name="pseudo" id="" placeholder="pseudo: " required><br>
                <input type="password" name="mdp" id="" placeholder="mot de passe:"required><br>


            </div>
            <input type="submit" value="confirmé" name="btn"><br>

            vous n'avez pas de compte? <a href="inscription.php" class="vert">inscrivez-vous </a>

        </form>
    </main>
</body>
</html>