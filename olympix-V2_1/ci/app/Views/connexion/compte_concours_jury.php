<main>
    <div class="container">
        <?php if(!empty($concours) && is_array($concours)) { ?>
            <h2 class="mt-4">Tous les concours :</h2>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Nom</th>
                    <th>Début</th>
                    <th>Phase</th>
                    <th>Catégories</th>
                    <th>Edition</th>
                    <th>Organisateur</th>
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
                    <td class="align-middle"><?= $crs["crs_edition"] ?></td>
                    <td class="align-middle"><?= $crs["organisateur"] ?></td>
                    <td class="align-middle">
                        <div class="d-flex justify-content-center align-items-center h-100">
                        <?php if ($crs["phase"] == "4finale"){ ?>
                           <a href="<?php echo base_url();?>index.php/connexion/afficher_candidats_jury/<?= $crs["crs_id"] ?>"> <i class="fa-solid fa-users text-dark"></i></a>
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
</main>