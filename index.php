<?php
// Inclure les fichiers de classe
require_once("controleur/user.class.php");
require_once("controleur/controleur.class.php");

// Démarrer la session si elle n'est pas déjà démarrée
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Vérifier si l'utilisateur est connecté pour afficher les liens appropriés dans la navigation
$utilisateurConnecte = isset($_SESSION['user']) && $_SESSION['user'] instanceof User;
?>

<!DOCTYPE html>
<html>
<head>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Projet wmd_23</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
</head>
<style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }
        footer {
            background-color: #f8f9fa;
            padding: 20px;
            margin-top: auto;
            width: 100%;
        }
    </style>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="index.php?page=1">Accueil</a>
            </li>
            <?php if ($utilisateurConnecte): ?>
            <li class="nav-item">
                <a class="nav-link" href="index.php?page=4">Stat</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php?page=5">Enquetes</a>
            </li>
            <?php endif; ?>
        </ul>

        <ul class="navbar-nav ml-auto">
            <?php if (!$utilisateurConnecte): ?>
            <li class="nav-item">
                <a class="nav-link" href="index.php?page=2">Inscription</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-success" href="index.php?page=3">Se Connecter</a>
            </li>
            <?php endif; ?>

            <?php if ($utilisateurConnecte): ?>
            <span class="navbar-text mr-3">
                Bienvenue <?php echo htmlspecialchars($_SESSION['user']->getNom()); ?>
            </span>
            <li class="nav-item">
                <a class="nav-link" href="index.php?page=6">
                    <img src="image/deconnexion.png" alt="Déconnexion" style="height: 20px;">
                </a>
            </li>
            <?php endif; ?>
        </ul>
    </nav>



    <center>

        <h1>Wemakedonation</h1>


        <?php
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
                $_SESSION['user'] = $user; // Stocker l'utilisateur dans la session
                header("Location: index.php?page=1");
                exit();
            } else {
                echo "<p>Erreur de connexion. Veuillez vérifier vos identifiants.</p>";
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
<br>
   
</body>

    <footer>
        <p>© 2024 Wemakedonation. Tous droits réservés.</p>
    </footer>
        

</html>
