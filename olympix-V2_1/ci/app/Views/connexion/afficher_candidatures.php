<main>
<div class="container py-5">
        <?php if(!empty($candidats)) { ?>
                <h1 class="my-4">Toutes les candidatures du concours</h1>
                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">Nom</th>
                        <th scope="col">Prenom</th>
                        <th scope="col">Age</th>
                        <th scope="col">Email</th>
                        <th scope="col">Code</th>
                        <th scope="col">Code dossier</th>
                        <th scope="col">Présentation</th>
                        <th scope="col">Etat </th>
                        <th scope="col">Date</th>

                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($candidats as $cdt) { ?>
                      <tr>
                        <td><?= $cdt["cdt_nom"] ?></td>
                        <td><?= $cdt["cdt_prenom"] ?></td>
                        <td><?= $cdt["cdt_age"] ?></td>
                        <td><?= $cdt["cdt_email"] ?></td>
                        <td><?= $cdt["cdt_code"] ?></td>
                        <td><?= $cdt["cdt_code_dossier"] ?></td>
                        <td><?= $cdt["cdt_presentation"] ?></td>
                        <td><?= $cdt["cdt_etat"] ?></td>
                        <td class="align-middle"><?php
                        $date = new DateTimeImmutable($cdt["cdt_date"]);
                        echo $date->format('d M Y');
                        ?></td>  
                      </tr>
                      <?php
                        }
                    ?>
                    </tbody>
                </table>

        <?php } else { ?>
          <h3>Aucun canidats pour ce concours !</h3>
        <?php } ?>
      </div>
</main>