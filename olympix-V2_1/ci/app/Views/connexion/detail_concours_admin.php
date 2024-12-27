<main>
<div class="container py-5">
        <?php if(!empty($concours)) { ?>
          <h2 class="my-4">Information du concours <strong><u><?= $concours->nom ?></u></strong></h2>
          <table class="table table-borderless">
            <tr>
                <th>Date de début</th>
                <td>
                    <?php
                    $date = new DateTimeImmutable($concours->debut);
                    echo $date->format('d M Y');
                    ?>
                </td>
            </tr>
            <tr>
                <th>Date limite de candidature</th>
                <td>
                    <?php
                    $date = new DateTimeImmutable($concours->candidature);
                    echo $date->format('d M Y');
                    ?>
                </td>
            </tr>
            <tr>
                <th>Date limite de pré-sélection</th>
                <td>
                    <?php
                    $date = new DateTimeImmutable($concours->pre_selection);
                    echo $date->format('d M Y');
                    ?>
                </td>
            </tr>
            <tr>
                <th>Date limite de finale</th>
                <td>
                    <?php
                    $date = new DateTimeImmutable($concours->finale);
                    echo $date->format('d M Y');
                    ?>
                </td>
            </tr>
            <tr>
                <th>Catégories</th>
                <td class="align-middle">
                    <?php
                      if(empty($concours->categories)) {
                        echo "<p class='text-body-tertiary'>Aucune <strong>catégorie</strong></p>";
                      } else {
                        echo $concours->categories;
                      }
                    ?>
                  </td>
            </tr>
            <tr>
                <th>Phase</th>
                <td class="align-middle">
                  <?php
                    if($concours->phase == '2inscriptions') echo "Inscriptions";
                    else if($concours->phase == '1à venir') echo "A venir";
                    else if($concours->phase == '3sélection') echo "Sélection";
                    else if($concours->phase == '4finale') echo "Finale";
                    else if($concours->phase == '5terminé') echo "Terminé";
                    else echo "erreur dans la phase du concours";

                  ?>
                  </td>
            </tr>

            <tr>
                <th>Jurés</th>
                <td class="align-middle">
                    <?php
                      if(empty($concours->jures)) {
                        echo "<p class='text-body-tertiary'>Aucun membre du <strong>jury</strong></p>";
                      } else {
                        echo $concours->jures;
                      }
                    ?>
                  </td>
            </tr>
            <tr>
                <th>Organisateur</th>
                <td><?= $concours->organisateur ?></td>
            </tr>
          </table>
        <?php } else { ?>
          <h3>Aucunes infos sur le concours pour l'instant !</h3>
        <?php } ?>
      </div>
</main>