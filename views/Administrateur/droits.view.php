<article class="article_aller">


<h1>Page de gestion des droits des utilisateurs</h1>
<table class="table">
    <thead>
        <tr>
            <th>Login</th>
            <th>Validé</th>
            <th>Rôle</th>
        </tr>
        <?php foreach ($utilisateurs as $utilisateur) : ?>
            <tr>
                <td><?= $utilisateur['email'] ?></td>
                <td><?= (int)$utilisateur['est_valide'] === 0 ? "non validé" : "validé" ?></td>
                <td>
                    <?php if($utilisateur['role'] === "administrateur") : ?>
                        <?= $utilisateur['role'] ?>
                    <?php else: ?>
                        <form method="POST" action="<?= URL ?>administration/validation_modificationRole">
                            <input type="hidden" name="email" value="<?= $utilisateur['email'] ?>" />
                            <select class="form-select" name="role" onchange="confirm('confirmez vous la modification ?') ? submit() : document.location.reload()">
                                <option value="utilisateur" <?= $utilisateur['role'] === "utilisateur" ? "selected" : ""?>>Utilisateur</option>
                                <option value="Sutilisateur" <?= $utilisateur['role'] === "Sutilisateur" ? "selected" : ""?>>Super Utilisateur</option>
                                <option value="administrateur" <?= $utilisateur['role'] === "administrateur" ? "selected" : ""?>>Administrateur</option>
                            </select>
                        </form>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </thead>
</table>






















    <!-- <div class="formulaire">

        <form class="example" action="">
            <input type="text" placeholder="Recherche.." name="search">
            <button type="submit"><i class="fa fa-search"></i></button>
        </form>
        <form action="" class="date">
            <input type="date">
            <input type="date">
        </form>
        <form class="valide" action="">
            <a href=""><i class="icone fa-solid fa-thumbs-up"></i></a>
            <a href=""><i class="fa-solid fa-thumbs-down"></i></a>
        </form>
        </div>
      
    
    <div class="aller">
        <form action="">
            <table id="info_aller">

                <tr>
                    <th><input type="checkbox"></th>
                    <th>Code</th>

                    <th>Expéditeur</th>

                    <th>Destinateur</th>

                    <th>Montant</th>

                    <th>frais</th>

                    <th>Total</th>

                    <th>Retrait</th>

                    <th>Agent Expéditeur</th>

                    <th>Agent Destinateur</th>

                    <th>Date</th>
                    <th>Action</th>
                </tr>


                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td> 
                        <a href=""><i class="fa-solid fa-thumbs-up"></i></a>
                        <a href=""><i class="fa-solid fa-thumbs-down"></i></a>
                    </td>
                </tr>

            </table>
        </form>
    </div> -->
</article>