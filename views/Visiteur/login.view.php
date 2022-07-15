
<article id="article">
    <h1>Page de connexion</h1>
    <div id="form_connexion">

        <form method="POST" action="<?= URL ?>validation_login">
            <div class="mb-3" id="connexion">
                <label for="login" class="form-label">E-mail</label>
                <input type="text" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3" id="connexion">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <button type="submit" class="btn btn-primary" id="button">Connexion</button>
        </form>
    </div>
</article>