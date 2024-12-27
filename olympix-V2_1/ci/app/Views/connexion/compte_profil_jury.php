<main>
<?php
$session = session();


if (!empty($profil)) {
    ?>
    <div class="container mt-5">
        <h2 class="mb-3">Mon profil </h2>
        <table class="table">
            <tr>
                <td>Prénom :</td>
                <td><?= $profil->jry_prenom ?></td>
            </tr>
            <tr>
                <td>Nom :</td>
                <td><?= $profil->jry_nom ?></td>
            </tr>
            <tr>
                <td>Email :</td>
                <td><?= $profil->cpt_pseudo ?></td>
            </tr>
            <tr>
                <td>Discipline :</td>
                <td><?= $profil->jry_discipline ?></td>
            </tr>
            <tr>
                <td>Biographie :</td>
                <td><?= $profil->jry_biographie ?></td>
            </tr>
            <tr>
                <td>Site web :</td>
                <td><a href="<?= $profil->jry_url ?>" target="_blank"><?= $profil->jry_url ?></a></td>
            </tr>
            <tr>
                <td>    
                    <a href="<?php echo base_url('index.php/connexion/compte_modifier_jury');?>" class="btn btn-primary">Modifier</a>
                </td>
            </tr>
        </table>
    </div>
    <?php
} else {
    ?>
    <div class="alert alert-warning text-center" role="alert">
        <h4 class="alert-heading">Aucune information trouvée pour le profil du juré</h4>
    </div>
    <?php
}
?>
</main>