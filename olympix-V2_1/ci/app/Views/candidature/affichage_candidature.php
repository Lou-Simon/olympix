<section id="about" class="about section py-5">
    <div class="container my-5">

        <?php
        if (empty($candidature)) {
            ?>
            <div class="alert alert-warning text-center" role="alert">
                <h4 class="alert-heading">Aucune candidature trouvée</h4>
                <p>Il n'y a pas de candidature correspondant à ce code.</p>
            </div>
            <?php
        } else {
        ?>
            <h3 class="text-center">Détails de la Candidature</h3>

            <table class="table table-borderless">
                <tbody>
                    <tr>
                        <td class="font-weight-bold">Prénom :</td>
                        <td><?= $candidature->cdt_prenom; ?></td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Nom :</td>
                        <td><?= $candidature->cdt_nom; ?></td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Code :</td>
                        <td><?= $candidature->cdt_code; ?></td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Code dossier :</td>
                        <td><?= $candidature->cdt_code_dossier; ?></td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Âge :</td>
                        <td><?= $candidature->cdt_age?></td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Email :</td>
                        <td><?= $candidature->cdt_email ?></td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Présentation :</td>
                        <td><?= $candidature->cdt_presentation ?></td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Date d'inscription :</td>
                        <td><?= $candidature->cdt_date ?></td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Concours concerné :</td>
                        <td><?= $candidature->crs_nom ?></td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Catégorie concernée :</td>
                        <td><?= $candidature->cat_nom?></td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Etat :</td>
                        <td><?= $candidature->cdt_etat ?></td>
                    </tr>
                </tbody>
            </table>
            
            <h4 class="mt-4">Documents :</h4>
            <div class="d-flex flex-wrap gap-3">
                <?php
                foreach ($document as $doc) {
                    if (!empty($doc['doc_nom'])) {
                        echo '<img style="width:20rem" src="' . base_url('images/candidature/' . $doc['doc_nom']) . '" alt="Document de la candidature">';
                    } else {
                        echo "Il n'y a pas de documents pour cette candidature"; 
                    }
                }
                ?>
            </div>
            <a href="<?php echo base_url('index.php/candidature/supprimer/' . $candidature->cdt_id . '_' . $candidature->crs_id . '_' . $candidature->cdt_code . '_' . $candidature->cdt_code_dossier); ?>">
                <button class="btn btn-danger mt-5">Supprimer ma candidature</button>
            </a>
        <?php
        }
        ?>

    </div>
</section>
