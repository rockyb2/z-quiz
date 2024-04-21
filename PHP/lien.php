
<?php
session_start();
include_once('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer le niveau de difficulté sélectionné par l'utilisateur
    $theme = $_POST['theme'];
    $niveau = $_POST['niveau'];

    // Vérifier si l'utilisateur est connecté
    if(isset($_SESSION['pseudo_user']) && $_SESSION['pseudo_user'] != null){
        // Utilisateur connecté, enregistrer les valeurs dans la session
        $_SESSION['theme'] = $theme;
        $_SESSION['niveau'] = $niveau;

        // Rediriger l'utilisateur vers la page du QCM avec le thème et le niveau sélectionnés
        header("Location: QCM/quiz.php");
        exit();
    } else {
        // Utilisateur non connecté, afficher une pop-up et rediriger vers la page de connexion
        echo '<script>alert("Vous n\'êtes pas connecté. Veuillez vous connecter pour accéder au QCM."); window.location.href = "identification/connexion.php";</script>';
        exit();
    }
    
}

$sql = "SELECT * FROM theme";
$stmt = $connexionDB->prepare($sql);
$stmt->execute();
$themes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<ul class="link">
    <?php foreach ($themes as $theme) : ?>
        <li>
            <a href="#" onclick="showForm('<?php echo $theme['nom_theme']; ?>')"> <?php echo $theme['nom_theme']; ?></a>
            <div id="<?php echo $theme['nom_theme']; ?>-form" style="display: none;">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <input type="hidden" name="theme" value="<?php echo $theme['nom_theme']; ?>">
                    <label for="niveau">Choisissez le niveau :</label>
                    <select name="niveau" id="niveau">
                        <option value="facile">Facile</option>
                        <option value="moyen">Moyen</option>
                        <option value="difficile">Difficile</option>
                    </select>
                    <input type="submit" value="Commencer le QCM">
                </form>
            </div>
        </li>
    <?php endforeach; ?>
</ul>

<script>
    function showForm(theme) {
        var formId = theme + "-form";
        document.getElementById(formId).style.display = "block";
    }
</script>
