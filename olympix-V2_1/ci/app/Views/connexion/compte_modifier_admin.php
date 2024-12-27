<main>
<?php
$session = session();
$cpt_pseudo = $session->get('user');

if (!empty($profil)) {
    ?>
  <div class="container">
        <!-- Message d'erreur flash -->
        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger" role="alert">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>
        
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header">
                        <h3 class="text-center font-weight-light my-4">Modifier le profil Administrateur</h3>
                    </div>
                    <div class="card-body">
                        <?php echo form_open('compte/modifierProfil', ['class' => 'needs-validation']); ?>
                        <?= csrf_field() ?>
                        <div class="form-floating mb-3">
                            <input class="form-control" name="old_mdp" id="inputpassword" type="password" placeholder="Entrez votre mot de passe actuel" />
                            <label for="inputpassword">Mot de passe</label>
                            <div class="text-danger small"><?= validation_show_error('old_mdp') ?></div>
                        </div>

                        <div class="form-floating mb-3">
                            <input class="form-control" name="new_mdp1" id="inputPassword1" type="password" placeholder="Entrez votre nouveau mot de passe" />
                            <label for="inputPassword1">Confirmaton du mot de passe</label>
                            <div class="text-danger small"><?= validation_show_error('new_mdp1') ?></div>
                        </div>

                        <div>
                            <?php
                            if (isset($message) && $message) {
                                echo $message;
                            }
                            ?>
                        </div>

                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                            <button type="submit" class="btn btn-primary">Valider</button>
                            <a href="<?php echo base_url();?>index.php/compte/afficher_profil" class="btn btn-danger">Annuler</a>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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