<!DOCTYPE html>
<lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Utilisateur</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles -->
    <style>
        .card-container {
            margin-top: 50px;
        }
    </style>
</head>

    <div class="container">
        <div class="row justify-content-center card-container">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Inscription Utilisateur</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" id="inscription-form">
                            <div class="mb-3">
                                <label for="nom" class="form-label">Nom:</label>
                                <input type="text" class="form-control" id="nom" name="nom" onblur="c_nom()">
                                <div id="erreurNom" class="form-text" style="color: red; display: none;"></div>
                            </div>
                            <div class="mb-3">
                                <label for="prenom" class="form-label">Prénom:</label>
                                <input type="text" class="form-control" id="prenom" name="prenom" onblur="c_prenom()">
                                <div id="erreurPrenom" class="form-text" style="color: red; display: none;"></div>
                            </div>
                            <div class="mb-3">
                                <label for="age" class="form-label">Age:</label>
                                <input type="number" class="form-control" id="age" name="age" onblur="c_age()">
                                <div id="erreurAge" class="form-text" style="color: red; display: none;"></div>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email:</label>
                                <input type="email" class="form-control" id="email" name="email" onblur="c_email()">
                                <div id="erreurEmail" class="form-text" style="color: red; display: none;"></div>
                            </div>
                            <div class="mb-3">
                                <label for="telephone" class="form-label">Téléphone:</label>
                                <input type="text" class="form-control" id="telephone" name="telephone" onblur="c_telephone()">
                                <div id="erreurTelephone" class="form-text" style="color: red; display: none;"></div>
                            </div>
                            <div class="mb-3">
                                <label for="mdp" class="form-label">Mot de passe:</label>
                                <input type="password" class="form-control" id="mdp" name="mdp">
                            </div>
                            <button type="submit" name="Valider" class="btn btn-primary">Valider</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script type="text/javascript">
        window.addEventListener('load', function () {
            // Réinitialiser les champs email et mot de passe
            document.getElementById('email').value = '';
            document.getElementById('mdp').value = '';
        });
    </script>

    <script type="text/javascript">
        function c_nom() {
            var nomField = document.getElementById('nom');
            var nom = nomField.value;
            var nomRegex = /^[a-zA-Z' ]{1,20}$/;

            if (nom.match(nomRegex) && nom.length >= 3) {
                nomField.style.backgroundColor = "green";
                document.getElementById('erreurNom').style.display = 'none';
                return true;
            } else {
                nomField.style.backgroundColor = "red";
                if (nom.length < 3) {
                    document.getElementById('erreurNom').innerHTML = 'Le nom doit contenir au moins 3 caractères.';
                } else {
                    document.getElementById('erreurNom').innerHTML = 'Le champ nom est invalide. Veuillez fournir un nom valide.';
                }
                document.getElementById('erreurNom').style.color = 'red';
                document.getElementById('erreurNom').style.display = 'block';
                return false;
            }
        }

        function c_prenom() {
            var prenomField = document.getElementById('prenom');
            var prenom = prenomField.value;
            var prenomRegex = /^[a-zA-Z' ]{1,20}$/;

            if (prenom.match(prenomRegex) && prenom.length >= 3) {
                prenomField.style.backgroundColor = "green";
                document.getElementById('erreurPrenom').style.display = 'none';
                return true;
            } else {
                prenomField.style.backgroundColor = "red";
                if (prenom.length < 3) {
                    document.getElementById('erreurPrenom').innerHTML = 'Le prénom doit contenir au moins 3 caractères.';
                } else {
                    document.getElementById('erreurPrenom').innerHTML = 'Le champ prénom est invalide. Veuillez fournir un prénom valide.';
                }
                document.getElementById('erreurPrenom').style.color = 'red';
                document.getElementById('erreurPrenom').style.display = 'block';
                return false;
            }
        }

        function c_age() {
            var ageField = document.getElementById('age');
            var age = ageField.value;

            if (age >= 18 && age <= 99) {
                ageField.style.backgroundColor = "green";
                document.getElementById('erreurAge').style.display = 'none';
                return true;
            } else {
                ageField.style.backgroundColor = "red";
                document.getElementById('erreurAge').innerHTML = 'L\'âge doit être entre 18 et 99 ans.';
                document.getElementById('erreurAge').style.color = 'red';
                document.getElementById('erreurAge').style.display = 'block';
                return false;
            }
        }

        function c_email() {
            var emailField = document.getElementById('email');
            var email = emailField.value;
            var emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

            if (email.match(emailRegex)) {
                emailField.style.backgroundColor = "green";
                document.getElementById('erreurEmail').style.display = 'none';
                return true;
            } else {
                emailField.style.backgroundColor = "red";
                document.getElementById('erreurEmail').innerHTML = 'Le champ email est invalide. Veuillez fournir un email valide.';
                document.getElementById('erreurEmail').style.color = 'red';
                document.getElementById('erreurEmail').style.display = 'block';
                return false;
            }
        }

        function c_telephone() {
            var telephoneField = document.getElementById('telephone');
            var telephone = telephoneField.value;
            var telephoneRegex = /^\d{10}$/;

            if (telephone.match(telephoneRegex)) {
                telephoneField.style.backgroundColor = "green";
                document.getElementById('erreurTelephone').style.display = 'none';
                return true;
            } else {
                telephoneField.style.backgroundColor = "red";
                if (telephone.length === 10) {
                    document.getElementById('erreurTelephone').innerHTML = 'Le numéro de téléphone est invalide. Veuillez fournir un numéro de téléphone valide de 10 chiffres.';
                } else {
                    document.getElementById('erreurTelephone').innerHTML = 'Le numéro de téléphone doit contenir exactement 10 chiffres.';
                }
                document.getElementById('erreurTelephone').style.color = 'red';
                document.getElementById('erreurTelephone').style.display = 'block';
                return false;
            }
        }

        document.getElementById('inscription-form').addEventListener('submit', function (event) {
            var valid = true;

            if (!c_nom()) valid = false;
            if (!c_prenom()) valid = false;
            if (!c_age()) valid = false;
            if (!c_email()) valid = false;
            if (!c_telephone()) valid = false;

            if (!valid) {
                event.preventDefault(); // Empêche la soumission du formulaire si une validation échoue
            }
        });
    </script>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
