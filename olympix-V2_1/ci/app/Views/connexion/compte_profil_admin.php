<main>
<?php
$session = session();


if (!empty($profil)) {
    ?>
    <div class="container mt-5">
        <table class="table">
            <tr>
                <td>Email :</td>
                <td><?= $profil->cpt_pseudo ?></td>
            </tr>
            <tr>
                <td>Etat :</td>
                <td>
                    <?php
                    if ($profil->grt_etat == 'A') {
                        echo "Activé";
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td><a href="<?php echo base_url('index.php/connexion/compte_modifier_admin');?>" class="btn btn-primary">Modifier</a></td>
            </tr>
        </table>
    </div>
    <?php
} else {
    ?>
    <div class="alert alert-warning text-center" role="alert">
        <h4 class="alert-heading">Aucune information trouvée pour le profil de l'admin</h4>
    </div>
    <?php
}
?>

</main>