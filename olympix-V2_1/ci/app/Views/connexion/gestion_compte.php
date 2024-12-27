<main>
    <div class="container my-5">
        <?php
        $session = session();
        $email_connecte = $session->get('user');
        $compteur = 0;
        
        if(isset($comptes)) {
        ?>
            <h1 class="my-5">Comptes de l'application</h1>
            <?php if (isset($mess) && $mess): ?>
                <?= $mess ?>
            <?php endif; ?>

            <?php if (isset($message) && $message): ?>
                <?= $message ?>
            <?php endif; ?>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Nom</th>
                        <th scope="col">Prenom</th>
                        <th scope="col">Email</th>
                        <th scope="col">Status</th>
                        <th scope="col">Etat</th>
                        <th scope="col" colspan="2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($comptes as $cpt) {
                        $compteur++;
                    ?>
                        <tr>
                            <td>
                                <?php 
                                if(!empty($cpt['jry_nom'])) {
                                    echo $cpt['jry_nom'];
                                } else {
                                    echo "X";
                                }
                                ?>
                            </td>
                            <td>
                                <?php 
                                if(!empty($cpt['jry_prenom'])) {
                                    echo $cpt['jry_prenom'];
                                } else {
                                    echo "X";
                                }
                                ?>
                            </td>
                            <td><?= $cpt['cpt_pseudo'] ?></td>
                            <td>
                                <?php 
                                if(!empty($cpt['jry_etat'])) {
                                    echo "Juré";
                                } else {
                                    echo "Organisateur";
                                }
                                ?>
                            </td>
                            <td>
                                <?php 
                                if(!empty($cpt['jry_etat'])) {
                                    echo $cpt['jry_etat'];
                                } else {
                                    echo $cpt['grt_etat'];
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if(!empty($cpt['jry_etat'])) {
                                    if($cpt['jry_etat']=='A') {
                                        echo '<a href="'.base_url('index.php/compte/desactiver/'.$cpt['cpt_pseudo'].'/J').'" class="btn btn-danger">Désactiver</a>';
                                    } else if($cpt['jry_etat']=='D') {
                                        echo '<a href="'.base_url('index.php/compte/desactiver/'.$cpt['cpt_pseudo'].'/J').'" class="btn btn-success">Activer</a>';
                                    }
                                } else {
                                    if($cpt['grt_etat']=='S' || $cpt['cpt_pseudo'] == $email_connecte) {
                                        echo '<button class="btn btn-secondary" disabled>Désactiver</button>';
                                    } else if($cpt['grt_etat']=='A') {
                                        echo '<a href="'.base_url('index.php/compte/desactiver/'.$cpt['cpt_pseudo'].'/O').'" class="btn btn-danger">Désactiver</a>';
                                    } else if($cpt['grt_etat']=='D') {
                                        echo '<a href="'.base_url('index.php/compte/desactiver/'.$cpt['cpt_pseudo'].'/O').'" class="btn btn-success">Activer</a>';
                                    }
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                    if($cpt['grt_etat']=='S' || $cpt['cpt_pseudo'] == $email_connecte) {
                                        echo "<button class='btn btn-secondary' disabled>Modifier</button>";
                                    } else {
                                        echo "<button class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#modal".$compteur."'>Modifier</button>";
                                    }
                                ?>
                                
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

            <?php 
            $compteur = 0;
            foreach($comptes as $cpt) {
                $compteur++;
            ?>
                <div class="modal fade" id="modal<?= $compteur ?>" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">
                                    <?= !empty($cpt['jry_etat']) ? "Modifier le profil du juré" : "Modifier le profil de l'Administrateur" ?>
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <?php 
                                if(!empty($cpt['jry_etat'])) {
                                    $type = 'J';
                                } else {
                                    $type = 'O';
                                }
                                echo form_open('compte/modifierGestionProfil/'.$cpt['cpt_pseudo'].'/'.$type, ['class' => 'needs-validation']); 
                                echo csrf_field();
                                
                                if(!empty($cpt['jry_etat'])) { 
                                ?>
                                    <div class="form-floating mb-3">
                                        <input class="form-control" name="prenom" id="inputPrenom<?= $compteur ?>" 
                                               type="text" value="<?= $cpt['jry_prenom'] ?>" placeholder="Entrez votre prénom" />
                                        <label for="inputPrenom<?= $compteur ?>">Prénom</label>
                                        <div class="text-danger small"><?= validation_show_error('prenom') ?></div>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input class="form-control" name="nom" id="inputNom<?= $compteur ?>" 
                                               type="text" value="<?= $cpt['jry_nom'] ?>" placeholder="Entrez votre nom" />
                                        <label for="inputNom<?= $compteur ?>">Nom</label>
                                        <div class="text-danger small"><?= validation_show_error('nom') ?></div>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input class="form-control" name="discipline" id="inputDiscipline<?= $compteur ?>" 
                                               type="text" value="<?= $cpt['jry_discipline'] ?>" placeholder="Entrez votre discipline" />
                                        <label for="inputDiscipline<?= $compteur ?>">Discipline</label>
                                        <div class="text-danger small"><?= validation_show_error('discipline') ?></div>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <textarea class="form-control" name="biographie" id="inputBiographie<?= $compteur ?>" 
                                                 placeholder="Entrez votre biographie"><?= $cpt['jry_biographie'] ?></textarea>
                                        <label for="inputBiographie<?= $compteur ?>">Biographie</label>
                                        <div class="text-danger small"><?= validation_show_error('biographie') ?></div>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input class="form-control" name="url" id="inputUrl<?= $compteur ?>" 
                                               type="url" value="<?= $cpt['jry_url'] ?>" placeholder="Entrez votre site web" />
                                        <label for="inputUrl<?= $compteur ?>">Site web</label>
                                        <div class="text-danger small"><?= validation_show_error('url') ?></div>
                                    </div>
                                <?php } ?>

                                <div class="form-floating mb-3">
                                    <input class="form-control" name="mdp" id="inputpassword<?= $compteur ?>" 
                                           type="password" placeholder="Entrez votre mot de passe actuel" />
                                    <label for="inputpassword<?= $compteur ?>">Mot de passe</label>
                                    <div class="text-danger small"><?= validation_show_error('mdp') ?></div>
                                </div>

                                <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                    <button type="submit" class="btn btn-primary">Valider</button>
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Annuler</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <!-- Bouton d'ajout de compte -->
            <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#modalAjoutCompte">
                Ajouter un compte
            </button>

            <!-- Message d'erreur flash -->
            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger mt-3" role="alert">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <!-- Modal d'ajout de compte -->
            <div class="modal fade" id="modalAjoutCompte" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Ajouter un compte</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <?php echo form_open('compte/creerProfil', ['class' => 'needs-validation']); ?>
                            <?= csrf_field() ?>
                            
                            <div class="mb-3">
                                <label class="form-label">Statut</label>
                                <select class="form-select" name="statut">
                                    <option value="" selected disabled>Choisissez</option>
                                    <option value="admin">Administrateur</option>
                                    <option value="jure">Juré</option>
                                </select>
                                <div class="text-danger small"><?= validation_show_error('statut') ?></div>
                            </div>

                            <div class="form-floating mb-3">
                                <input class="form-control" name="email" id="inputEmail" 
                                       type="email" placeholder="Entrez l'email" />
                                <label for="inputEmail">Email</label>
                                <div class="text-danger small"><?= validation_show_error('email') ?></div>
                            </div>

                            <div class="form-floating mb-3">
                                <input class="form-control" name="mdp" id="inputPassword1" 
                                       type="password" placeholder="Entrez le mot de passe" />
                                <label for="inputPassword1">Mot de passe</label>
                                <div class="text-danger small"><?= validation_show_error('mdp') ?></div>
                            </div>

                            <?php if (isset($messages) && $messages): ?>
                                <div class="alert alert-danger">
                                    <?= $messages ?>
                                </div>
                            <?php endif; ?>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                <button type="submit" class="btn btn-primary">Créer le compte</button>
                            </div>

                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>

        <?php } else { ?>
            <div class="alert alert-info" role="alert">
                Aucun compte n'est disponible pour le moment.
            </div>
        <?php } ?>
    </div>
</main>