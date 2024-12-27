<main>
  <div class="container">
   <?php
     if(!empty($candidats)) {
   ?>
      <h1 class="mt-5">Candidats pour le concours sélectionné</h1>
      <table class="table">
         <thead>
            <tr>
            <th scope="col">Nom</th>
            <th scope="col">Prénom</th>
            <th scope="col">Age</th>
            <th scope="col">Email</th>
            <th scope="col">Présentation</th>
            <th scope="col">Etat</th>
            <th scope="col">Date d'inscription</th>
            <th scope="col">Catégorie</th>
            </tr>
         </thead>
         <tbody>
            <?php
            foreach($candidats as $cdt) {
               ?>
               <tr>
                  <td><?= $cdt["cdt_nom"] ?></td>
                  <td><?= $cdt["cdt_prenom"] ?></td>
                  <td><?= $cdt["cdt_age"] ?></td>
                  <td><?= $cdt["cdt_email"] ?></td>
                  <td><?= $cdt["cdt_presentation"] ?></td>
                  <td><?= $cdt["cdt_etat"] ?></td>
                  <td class="align-middle"><?php
                        $date = new DateTimeImmutable($cdt["cdt_date"]);
                        echo $date->format('d M Y');
                        ?></td>            
                  <td>   <?php
                      if(empty($cdt["cat_nom"])) {
                        echo "<p class='text-body-tertiary'>Aucune <strong>catégorie</strong></p>";
                      } else {
                        echo $cdt["cat_nom"];
                      }
                    ?></td>
               </tr>
               <?php
            }
            ?>
         </tbody>
      </table>
      <?php
     } else {
      echo '<h1>Il n\'y a pas de candidatures pour ce concours</h1>';
     }
     ?>
  </div>
</main>
