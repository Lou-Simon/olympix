<main class="main">
  <!-- Hero Section -->
  <section id="hero" class="hero section dark-background">

  <div class="container">
  <div class="row">
    <div class="col-md-8">
      <h2>Bienvenue sur Olympix</h2>
      <h4>La plateforme de <strong>concours de photographies maritimes</strong> en ligne de référence</h4>
    </div>
  </div>
</div>


  </section><!-- /Hero Section -->
  <section id="about" class="about section">
    <div class="container">
      <?php
      
      if (! empty($actus) && is_array($actus))
      {
        ?>
        <h2><?php echo $titre; ?></h2>
        <?php
      ?>
        <table class="table table-striped">
          <thead>
            <tr>
              <th scope="col">Titre</th>
              <th scope="col">Contenu</th>
              <th scope="col">Date</th>
              <th scope="col">Auteur</th>
            </tr>
          </thead>
          <tbody>
            <?php
              foreach ($actus as $act)
              {
                ?>
                <tr>
                  <td><?= $act["act_titre"] ?></td>
                  <td><?= $act["act_contenu"] ?></td>
                  <td><?php
                     $date = new DateTimeImmutable($act["act_date"]);
                     echo $date->format('d M Y à H\hm');
                  ?></td>
                  <td><?= $act["cpt_pseudo"] ?></td>
                </tr>
                <?php
              }
            ?>
          </tbody>
        </table>
      <?php
      }
      
      else {
      echo("<h3>Aucune actualité pour l'instant !</h3>");
      }

      ?>
    </div>
  </section>

</main>