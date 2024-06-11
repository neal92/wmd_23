<?php
// Supprime toutes les variables de session
session_unset();

// Détruit la session
session_destroy();

// Rediriger l'utilisateur vers la page d'accueil ou une autre page appropriée
header("Location:index.php?page=1");
exit();
?>
