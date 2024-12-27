<section id="contact" class="section contact container mt-5" style="height:100vh">
    <h2 class="text-center my-5"><?php echo $titre; ?></h2>

    <?php echo form_open('candidature/connecter', ['class' => 'needs-validation']); ?>
    <?= csrf_field() ?>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label for="code_dossier" class="form-label">Code de dossier :</label>
                <input type="password" 
                       class="form-control" 
                       id="code_dossier" 
                       name="code_dossier" 
                       value="<?= set_value('code_dossier') ?>" 
                       placeholder="Entrez votre code de dossier">
                <div class="text-danger small"><?= validation_show_error('code_dossier') ?></div>
            </div>

            <div class="form-group mb-3">
                <label for="code" class="form-label">Code</label>
                <input type="password" 
                       class="form-control" 
                       id="code" 
                       name="code" 
                       placeholder="Entrez votre code">
                <div class="text-danger small"><?= validation_show_error('code') ?></div>
            </div>

            <?php if(isset($message) && !empty($message)): ?>
                <?= $message ?>
            <?php endif; ?>

            <div class="d-grid">
                <button type="submit" 
                        name="submit" 
                        class="text-light read-more border-0">
                    Visionner sa candidature
                </button>
            </div>
        </div>
    </div>

    </form>
</section>