<main>
    <div class="container py-5">
        <?php if (!empty($galerie)) { ?>
            <div class="row">
                <?php foreach ($galerie as $gal) { ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="<?= base_url(); ?>/images/candidature/<?= $gal['doc_nom'] ?>" class="card-img-top" alt="<?= $gal['cdt_nom'] ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?= $gal['cdt_nom'] ?></h5>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } else { ?>
            <div class="text-center">
                <h3>Aucun concours pour l'instant !</h3>
            </div>
        <?php } ?>
    </div>
</main>
