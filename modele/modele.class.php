<?php
class Modele {
    private $unPdo;

    public function __construct() {
        try {
            $url = "mysql:host=localhost;dbname=wmd_23";
            $user = "root";
            $mdp = "";
            $this->unPdo = new PDO($url, $user, $mdp);
        } catch (PDOException $exp) {
            echo "<br> Erreur de connexion à la BDD : " . $exp->getMessage();
        }
    }

    public function inscription($tab) {
        try {
            $dateInscription = date("Y-m-d H:i:s"); // Obtient la date actuelle au format "Y-m-d H:i:s"
            
            $requete = "INSERT INTO Utilisateurs (Nom, Prenom, Age, Email, Telephone, Mdp_Utilisateur, Date_Inscription) 
                        VALUES (:nom, :prenom, :age, :email, :telephone, :mdp, :dateInscription)";
            
            $donnees = array(
                ":nom" => $tab["nom"],
                ":prenom" => $tab["prenom"],
                ":age" => $tab["age"],
                ":email" => $tab["email"],
                ":telephone" => $tab["telephone"],
                ":mdp" => $tab["mdp"],
                ":dateInscription" => $dateInscription // Utilise la date actuelle
            );
            
            $select = $this->unPdo->prepare($requete);
            $select->execute($donnees);
    
            // Redirection vers la page de connexion après inscription réussie
            header("Location: index.php?page=3");
            exit(); // Assure que le script s'arrête après la redirection
    
        } catch (PDOException $e) {
            if ($e->getCode() == '45000') {
                echo "<p>Erreur: " . $e->getMessage() . "</p>";
            } else {
                echo "<p>Erreur de base de données: " . $e->getMessage() . "</p>";
            }
        }
    }
    

    public function connexion($email, $mdp) {
        $requete = "SELECT * FROM utilisateurs WHERE email = :email AND mdp_utilisateur = :mdp";
        $donnees = array(
            ":email" => $email,
            ":mdp" => $mdp
        );
        $select = $this->unPdo->prepare($requete);
        $select->execute($donnees);
        $userData = $select->fetch(PDO::FETCH_ASSOC);
    
        if ($userData) {
            $user = new User();
            $user->renseigner($userData);
            return $user;
        } else {
            return null;
        }
    }
    


    public function getUsers() {
        $requete = "SELECT * FROM utilisateurs";
        $select = $this->unPdo->prepare($requete);
        $select->execute();
        return $select->fetchAll();
    }

    public function getInscriptions() {
        $requete = "SELECT Age, Date_Inscription FROM Utilisateurs";
        $select = $this->unPdo->prepare($requete);
        $select->execute();
        return $select->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function execute($requete) {
        return $this->unPdo->query($requete);
    }
    
    public function enregistrerEnquete($tab) {
        // Utilisation de la fonction MySQL NOW() pour la date actuelle
        $requete = "INSERT INTO Evaluations (Note, Commentaire, Date_Evaluation) VALUES (:note, :commentaire, NOW())";

        $donnees = array(
            ":note" => $tab["note"],
            ":commentaire" => $tab["commentaire"]
        );

        $select = $this->unPdo->prepare($requete);
        $select->execute($donnees);   
    }

    public function SejoursMoyennesNotes() {
        $requete = "SELECT Sejours.id_sejour, Station_Sejour, AVG(Evaluations.Note) AS MoyenneNote
                    FROM Sejours
                    LEFT JOIN Evaluations ON Sejours.id_sejour = Evaluations.id_sejour
                    GROUP BY Sejours.id_sejour, Station_Sejour";

        $select = $this->unPdo->prepare($requete);
        $select->execute();

        return $select->fetchAll(PDO::FETCH_ASSOC);
    }

    public function enregistrerEnqueteBase() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Capturez les données soumises
            $id_sejour = $_POST['id_sejour'];
            $note = $_POST['note'];
            $commentaire = $_POST['commentaire'];

            // Validez les données si nécessaire
            if (empty($id_sejour) || empty($note)) {

            } else {
                // Les données sont valides, utilisez le modèle pour enregistrer les données
                $tab = [
                    'id_sejour' => $id_sejour,
                    'note' => $note,
                    'commentaire' => $commentaire,
                ];
                header('Location: confirmation.php');
            }
        }

        // Affichez le formulaire si ce n'est pas encore soumis ou en cas d'erreur
        include 'vues/vue_enquete_1.php';
    }


    /*public function setCookie($name, $value, $days) {
        setcookie($name, $value, time() + (86400 * $days), "/");
    }

    public function getCookie($name) {
        if (isset($_COOKIE[$name])) {
            return $_COOKIE[$name];
        }
        return "";
    }
    

    public function stockerEnqueteDansCookies($nom, $prenom, $satisfaction) {
        // Utilisation de la méthode setCookie pour stocker les données dans des cookies
        $this->setCookie("enquete_nom", $nom, 30); // Stocke le nom dans un cookie pendant 30 jours
        $this->setCookie("enquete_prenom", $prenom, 30); // Stocke le prénom dans un cookie pendant 30 jours
        $this->setCookie("enquete_satisfaction", $satisfaction, 30); // Stocke la satisfaction dans un cookie pendant 30 jours
    }
    
    public function recupererEnqueteCookies() {
        // Utilisation de la méthode getCookie pour récupérer la note et le commentaire depuis les cookies
        $note = $this->getCookie("enquete_note");
        $commentaire = $this->getCookie("enquete_commentaire");
        return ['note' => $note, 'commentaire' => $commentaire];
    }
    */
    

}

?>
