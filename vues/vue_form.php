<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Connexion Utilisateur</h5>

                    <form method="post" action="index.php?page=3">
                        <div class="mb-3">
                            <label for="email" class="form-label">Adresse Email</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="mdp" class="form-label">Mot de passe</label>
                            <input type="password" name="mdp" id="mdp" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary" value="Se Connecter" name="Connecter">Se Connecter</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
