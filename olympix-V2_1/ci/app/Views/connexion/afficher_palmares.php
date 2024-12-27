<main>
    <div class="container py-5">
        <?php if (!empty($palmares)) { ?>
            <h1 class="my-4">Palmarès du concours : </h1>
            <div class="row">
               <table class="table">
                <thead>
                    <tr>
                        <th>Classement</th>
                        <th>Nom</th>
                        <th>Prenom</th>
                        <th>Total Points</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                $compteur = 1;
                foreach ($palmares as $pal) { ?>
                   <tr>
                    <td><?= $compteur ?></td>
                    <td><?= $pal["cdt_nom"] ?></td>
                    <td><?= $pal["cdt_prenom"] ?></td>
                    <td><?= $pal["total_points"] ?></td>
                    
                   </tr>
                <?php
                 $compteur++;
            } ?>
                </tbody>
               </table>
            </div>
        <?php } else { ?>
            <div class="text-center">
                <h3>Aucun palmarès pour l'instant !</h3>
            </div>
        <?php } ?>
    </div>
</main>
