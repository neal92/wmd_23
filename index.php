<?php
// Démarre la session si elle n'est pas déjà démarrée
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Vérifie si l'utilisateur est connecté pour afficher les liens appropriés dans la navigation
$utilisateurConnecte = isset($_SESSION['user']);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Projet wmd_23</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
</head>

<nav>
    <ul>
        <li><a href="index.php?page=1">Accueil</a></li>
        <li><a href="index.php?page=2">Inscription</a></li>
        <?php if (!$utilisateurConnecte): ?>
        <li><a href="index.php?page=3">Se Connecter</a></li>
        <?php endif; ?>
        <?php if ($utilisateurConnecte): ?>
            <li><a href="index.php?page=4">Stat</a></li>
            <li><a href="index.php?page=5">Enquetes</a></li>
            <li><a href="index.php?page=6">Déconnexion</a></li> 
        <?php endif; ?>
    </ul>

    <?php
    // Affiche le nom de l'utilisateur s'il est connecté
    if ($utilisateurConnecte && isset($_SESSION['user']['nom'])) {
        echo "Bonjour " . $_SESSION['user']['nom'];
    }
    ?>
</nav>

<center>
    <h1>Projet wmd_23</h1>

    <?php
    require_once("controleur/user.class.php");
    require_once("controleur/controleur.class.php");

    // Instanciez la classe Controleur
    $unControleur = new Controleur();

    if (isset($_POST['Valider'])) {
        $user = new User();
        $user->renseigner($_POST);
        try {
            $unControleur->inscription($user->serialiser());
            $_SESSION['user'] = $user; // Stocker l'utilisateur dans la session
        } catch (PDOException $e) {
            echo "<p>Erreur lors de l'inscription.</p>";
        }
    }

    if (isset($_POST['Connecter'])) {
        $email = $_POST['email'];
        $mdp = $_POST['mdp'];
        $user = $unControleur->connexion($email, $mdp);
        if ($user) {
            $_SESSION['user'] = $user; // Stock l'utilisateur dans la session
        } else {
            echo "<p>Erreur de connexion. Veuillez vérifier vos identifiants.</p>";
            // Redirection vers la page d'accueil
            header("Location: index.php?page=1");
            exit(); 
        }
    }

    $page = isset($_GET['page']) ? $_GET['page'] : 1;

    switch ($page) {
        case 1:
            require_once("index.php");
            break;
        case 2:
            require_once("vues/vue_ins.php");
            break;
        case 3:
            require_once("vues/vue_form.php");
            break;
        case 4:
            require_once("vues/vue_users.php");
            break;
        case 5:
            require_once("vues/vue_enquete_1.php");
            break;
        case 6:
                require_once("controleur/deconnexion.php");
                break;
        }
    
    ?>
</center>

</html>
