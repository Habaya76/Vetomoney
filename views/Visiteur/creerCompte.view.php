<article id="article_inscription">
    <h1>Création de compte</h1>
    <div id="form_inscription">
        <form method="POST" action="validation_creerCompte" id="creerCompte">
            <div class="mb-3" id="inscription">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" class="form-control" id="nom" name="nom">
            </div>
            <div class="mb-3" id="inscription">
                <label for="prenom" class="form-label">prenom</label>
                <input type="text" class="form-control" id="prenom" name="prenom">
            </div>
            <div class="mb-3" id="inscription">
                <label for="pays" class="form-label">Pays</label>
                <input type="text" class="form-control" id="pays" name="pays">
            </div>
            <div class="mb-3" id="inscription">
                <label for="telephone" class="form-label">N° de Téléphone</label>
                <input type="text" class="form-control" id="telephone" name="telephone">
            </div>

            <div class="mb-3" id="inscription">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" class="form-control" id="email" name="email">
            </div>
            <div class="mb-3" class="inscription">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>

            <button type="submit" class="btn btn-primary" id="button">Céer !</button>
        </form>
       
</article>