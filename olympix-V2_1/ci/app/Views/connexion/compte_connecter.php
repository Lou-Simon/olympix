<section id="contact" class="section contact container mt-5">
    <div class="container" style="min-height:90vh">
        <br><br><br><br><br>
        <h2 class="text-center mb-4">Se connecter</h2>

        <!-- Message d'erreur flash -->
        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger" role="alert">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <!-- Début du formulaire -->
        <?php echo form_open('/compte/connecter', ['class' => 'needs-validation']); ?>
        <?= csrf_field() ?>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <!-- Champ Pseudo -->
                <div class="form-group mb-3">
                    <label for="pseudo" class="form-label">Pseudo :</label>
                    <input type="text" class="form-control" id="pseudo" name="pseudo" value="<?= set_value('pseudo') ?>" placeholder="Entrez votre pseudo">
                    <div class="text-danger small"><?= validation_show_error('pseudo') ?></div>
                </div>

                <!-- Champ Mot de passe -->
                <div class="form-group mb-3">
                    <label for="mdp" class="form-label">Mot de passe :</label>
                    <input type="password" class="form-control" id="mdp" name="mdp" placeholder="Entrez votre mot de passe">
                    <div class="text-danger small"><?= validation_show_error('mdp') ?></div>
                </div>

                <div>
                    <?php
                    if (isset($message) && $message) {
                        echo $message;
                    }
                    ?>
                </div>

                <!-- Bouton de soumission -->
                <div class="d-grid">
                    <button type="submit" name="submit" class="text-light read-more border-0">Se connecter</button>
                </div>
            </div>
        </div>
        </form>
    </div>
</section>
