<section id="about" class="about section">
    <div class="container py-5">
        <?php 
        if(isset($categories) && !empty($categories)) {
            foreach($categories as $cat) {
                echo '<h2 class="mb-4">' . $cat['cat_nom'] . '</h2>';
                echo '<div class="row row-cols-1 row-cols-xl-3 g-4 mb-5">';
                
                $documents = $model->get_candidats_par_categorie($id_concours, $cat['cat_nom']);
                
                foreach($documents as $doc) {
                    echo '<div class="col col-xl-3" style="max-width:30rem">';
                        echo '<div class="card border-0">';
                            echo '<div class="card-body">';
                                echo '<h5 class="card-title">' . $doc['cdt_prenom'] . ' ' . strtoupper($doc['cdt_nom']) . '</h5>';
                                echo '<img src="' . base_url() . '/images/candidature/' . $doc['doc_nom'] . '" 
                                          class="img-fluid rounded mb-3" 
                                          alt="Document de ' . $doc['cdt_prenom'] . '">';
                            echo '</div>';
                        echo '</div>';
                    echo '</div>';
                }
                
                echo '</div>';
            }
        } else {
            echo "<h2>Aucun candiat</h2>";
        }
        ?>
    </div>
</section>