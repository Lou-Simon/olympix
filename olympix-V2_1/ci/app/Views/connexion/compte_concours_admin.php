<main>
<div class="container py-5">
        <?php if(!empty($concours)) { ?>
          <h2 class="mt-4">Tous les concours :</h2>
          <button class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#addConcoursForm'>Ajouter un concours</button>
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Nom</th>
                <th>Début</th>
                <th>Candidature (date limite)</th>
                <th>Pré-sélection (date limite)</th>
                <th>Finale (date limite)</th>
                <th>Phase</th>
                <th>Catégories</th>
                <th>Jurés</th>
                <th>Organisateur</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($concours as $crs) { ?>
                <tr>
                  <td class="align-middle"><?= $crs["nom"] ?></td>
                  <td class="align-middle"><?php
                    $date = new DateTimeImmutable($crs["debut"]);
                    echo $date->format('d M Y');
                  ?></td>
                  <td class="align-middle"><?php 
                    $date = new DateTimeImmutable($crs["candidature"]);
                    echo $date->format('d M Y');
                  ?></td>
                   <td class="align-middle"><?php 
                    $date = new DateTimeImmutable($crs["pre_selection"]);
                    echo $date->format('d M Y');
                  ?></td>
                   <td class="align-middle"><?php 
                    $date = new DateTimeImmutable($crs["finale"]);
                    echo $date->format('d M Y');
                  ?></td>
                 <td class="align-middle">
                  <?php
                    if($crs["phase"]== '2inscriptions') echo "Inscriptions";
                    else if($crs["phase"]== '1à venir') echo "A venir";
                    else if($crs["phase"]== '3sélection') echo "Sélection";
                    else if($crs["phase"]== '4finale') echo "Finale";
                    else if($crs["phase"]== '5terminé') echo "Terminé";
                    else echo "erreur dans la phase du concours";

                  ?>
                  </td>
                  <td class="align-middle">
                    <?php
                      if(empty($crs["categories"])) {
                        echo "<p class='text-body-tertiary'>Aucune <strong>catégorie</strong></p>";
                      } else {
                        echo $crs["categories"];
                      }
                    ?>
                  </td>
                  <td class="align-middle">
                    <?php
                      if(empty($crs["jures"])) {
                        echo "<p class='text-body-tertiary'>Aucun membre du <strong>jury</strong></p>";
                      } else {
                        echo $crs["jures"];
                      }
                    ?>
                  </td>
                  <td class="align-middle"><?= $crs["organisateur"] ?></td>
                  <td class="align-middle">
                    <div class="d-flex justify-content-center align-items-center h-100">
                        <a href="<?php echo base_url();?>index.php/connexion/detail_concours_admin/<?= $crs["crs_id"] ?>"><i class="fas fa-plus-circle fs-1 mx-2" style="color:blue"></i></a>
                        <?php if ($crs["phase"] == "2inscriptions" || $crs["phase"] == "4finale" || $crs["phase"] == "5terminé" || $crs["phase"] == "3sélection") { ?>
                        <a href="<?php echo base_url();?>index.php/connexion/afficher_candidatures/<?= $crs["crs_id"] ?>"><i class="fas fa-pencil-alt fs-1 mx-2" style="color:green"></i></a>
                        <?php } if ($crs["phase"] == "4finale" || $crs["phase"] == "5terminé") { ?>
                            <a href="<?php echo base_url();?>index.php/connexion/galerie/<?= $crs["crs_id"] ?>"><i class="fa-solid fa-users fs-1 mx-2 text-dark"></i></a>
                        <?php }  if ($crs["phase"] == "5terminé") { ?>
                            <a href="<?php echo base_url();?>index.php/connexion/palmares/<?= $crs["crs_id"] ?>"><i class="fa-solid fa-trophy fs-1 mx-2" style="color:#ffd700"></i></a>
                        <?php }  ?>
                        <?php   
                        $currentDate = date('Y-m-d');
                        if ($crs["debut"] > $currentDate) { ?>
                            <a href="<?php echo base_url();?>index.php/connexion/supprimer/<?= $crs['debut'] ?>_<?= $crs['crs_id']?>_<?= $crs['nom'] ?>"><i class="fa-solid fa-trash fs-1 mx-2 text-danger"></i></a>
                        <?php }  ?>
                    </div>
                  </td>

                </tr>
              <?php } ?>
            </tbody>
          </table>
        <?php } else { ?>
          <h3>Aucun concours pour l'instant !</h3>
        <?php } ?>
          <!-- Modal d'ajout de compte -->
          <div class="modal fade" id="addConcoursForm" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Ajouter un concours</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <?php echo form_open('compte/creerConcours', ['class' => 'needs-validation']); ?>
                            <?= csrf_field() ?>

                            <div class="form-floating mb-3">
                                <input class="form-control" name="nom" id="inputNom" 
                                       type="text" placeholder="Entrez le nom du concours" />
                                <label for="inputNom">Nom</label>
                                <div class="text-danger small"><?= validation_show_error('nom') ?></div>
                            </div>

                            <div class="form-floating mb-3">
                                <input class="form-control" name="desc" id="inputDesc" 
                                       type="text" placeholder="Entrez la description du concours" />
                                <label for="inputDesc">Description</label>
                                <div class="text-danger small"><?= validation_show_error('desc') ?></div>
                            </div>
                            
                            <div class="form-floating mb-3">
                                <input class="form-control" name="debut" id="inputDebut" 
                                       type="date" />
                                <label for="inputDebut">Date de début</label>
                                <div class="text-danger small"><?= validation_show_error('debut') ?></div>
                            </div>

                            <div class="form-floating mb-3">
                                <input class="form-control" name="j_candidature" id="inputJourCandidature" 
                                       type="number" />
                                <label for="inputJourCandidature">Nombre de jours de candidature</label>
                                <div class="text-danger small"><?= validation_show_error('j_candidature') ?></div>
                            </div>

                            <div class="form-floating mb-3">
                                <input class="form-control" name="j_preselection" id="inputJourPreselection" 
                                       type="number" />
                                <label for="inputJourPreselection">Nombre de jours de pré-sélection</label>
                                <div class="text-danger small"><?= validation_show_error('j_preselection') ?></div>
                            </div>

                            <div class="form-floating mb-3">
                                <input class="form-control" name="j_selection" id="inputJourSelection" 
                                       type="number" />
                                <label for="inputJourSelection">Nombre de jours de sélection</label>
                                <div class="text-danger small"><?= validation_show_error('j_selection') ?></div>
                            </div>

                            <div class="form-floating mb-3">
                                <input class="form-control" name="edition" id="inputEdition" 
                                       type="text" placeholder="Entrez le nom du concours" />
                                <label for="inputEdition">Edition</label>
                                <div class="text-danger small"><?= validation_show_error('edition') ?></div>
                            </div>

                            <?php if (isset($message) && $message): ?>
                                <div class="alert alert-danger">
                                    <?= $message ?>
                                </div>
                            <?php endif; ?>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                <button type="submit" class="btn btn-primary">Créer le concours</button>
                            </div>

                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>
      </div>
</main>