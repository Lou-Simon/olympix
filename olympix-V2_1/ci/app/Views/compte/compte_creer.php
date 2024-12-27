<section id="contact" class="contact section" style='min-height: 100vh'>
    

    <?= session()->getFlashdata('error') ?>
    <?php
    // Création d’un formulaire qui pointe vers l’URL de base + /compte/creer
    ?>
    <div class="container col-md-6">
    <h2><?php echo $titre; ?></h2>
    <?php
    echo form_open('/compte/creer'); ?>
    <?= csrf_field() ?>
    <label for="pseudo">Email : </label>
    <input type="input" class="form-control" placeholder="Votre Email" name="pseudo">
    
    <label for="mdp">Mot de passe : </label>
    <input type="password" class="form-control" placeholder="Votre mot de passe" name="mdp">
    
    <div class="col-md-12 text-center">
        <div class="alert alert-danger">
            <?= validation_show_error('pseudo') ?>
            <?= validation_show_error('mdp') ?>
        </div>

            <input type="submit" name="submit" value="Créer un nouveau compte">
          </div>
    </form>
    </div> 
</section>