<?php echo form_open('compte/modifierGestionProfil/'.$cpt['cpt_pseudo'].'/J', ['class' => 'needs-validation']); ?>                                                <?= csrf_field() ?>
    <!-- Prénom -->
    <div class="form-floating mb-3">
        <input class="form-control" name="prenom" id="inputPrenom" type="text" value="<?= $cpt['jry_prenom'] ?>" placeholder="Entrez votre prénom" />
        <label for="inputPrenom">Prénom</label>
        <div class="text-danger small"><?= validation_show_error('prenom') ?></div>
    </div>

    <!-- Nom -->
    <div class="form-floating mb-3">
        <input class="form-control" name="nom" id="inputNom" type="text" value="<?= $cpt['jry_nom'] ?>" placeholder="Entrez votre nom" />
        <label for="inputNom">Nom</label>
        <div class="text-danger small"><?= validation_show_error('nom') ?></div>
    </div>

                                                <!-- Discipline -->
                                                <div class="form-floating mb-3">
                                                    <input class="form-control" name="discipline" id="inputDiscipline" type="text" value="<?= $cpt['jry_discipline'] ?>" placeholder="Entrez votre discipline" />
                                                    <label for="inputDiscipline">Discipline</label>
                                                    <div class="text-danger small"><?= validation_show_error('discipline') ?></div>
                                                </div>

                                                <!-- Biographie -->
                                                <div class="form-floating mb-3">
                                                    <textarea class="form-control" name="biographie" id="inputBiographie" placeholder="Entrez votre biographie"><?= $cpt['jry_biographie'] ?></textarea>
                                                    <label for="inputBiographie">Biographie</label>
                                                    <div class="text-danger small"><?= validation_show_error('biographie') ?></div>
                                                </div>

                                                <!-- Site web -->
                                                <div class="form-floating mb-3">
                                                    <input class="form-control" name="url" id="inputUrl" type="url" value="<?= $cpt['jry_url'] ?>" placeholder="Entrez votre site web" />
                                                    <label for="inputUrl">Site web</label>
                                                    <div class="text-danger small"><?= validation_show_error('url') ?></div>
                                                </div>

                                                <!-- Message d'erreur pour le profil -->
                                                <div>
                                                    <?php
                                                    if (isset($message) && $message) {
                                                        echo $message;
                                                    }
                                                    ?>
                                                </div>

                                                <!-- Formulaire de changement de mot de passe -->
                                                <div class="form-floating mb-3">
                                                    <input class="form-control" name="mdp" id="inputpassword" type="password" placeholder="Entrez votre mot de passe actuel" />
                                                    <label for="inputpassword">Mot de passe</label>
                                                    <div class="text-danger small"><?= validation_show_error('mdp') ?></div>
                                                </div>

                                                <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                    <button type="submit" class="btn btn-primary">Valider</button>
                                                    <a href="<?php echo base_url();?>index.php/connexion/gestion_compte" class="btn btn-danger">Annuler</a>
                                                </div>
                                                </form>