<section id="featured" class="featured section">
    <div class="container py-5">
        <?php if(!empty($concours) && is_array($concours)) { ?>
          <h2 class="mt-4">Tous les concours :</h2>
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
                      <i class="bi bi-plus-circle fs-1 mx-2" style="color:blue"></i>
                      <?php if ($crs["phase"] == "2inscriptions") { ?>
                        <i class="bi bi-pencil-square fs-1 mx-2" style="color:green"></i>
                      <?php } else if ($crs["phase"] == "4finale" || $crs["phase"] == "5terminé"){ ?>
                        <a href="<?php echo base_url("index.php/concours/afficher_galerie");?>/<?= $crs["crs_id"] ?>"><i class="bi bi-people-fill fs-1 mx-2 text-dark"></i></a>
                      <?php } if ($crs["phase"] == "5terminé"){ ?>
                        <i class="bi bi-trophy-fill fs-1 mx-2" style="color:#ffd700"></i>
                      <?php } ?>
                    </div>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        <?php } else { ?>
          <h3>Aucun concours pour l'instant !</h3>
        <?php } ?>
      </div>
  </section>