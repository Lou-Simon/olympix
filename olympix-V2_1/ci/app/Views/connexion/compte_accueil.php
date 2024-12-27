<?php
$session=session();
?> 
<main>
   <div class="container py-5">
    <h2 class='text-center my-5'>Bienvenue sur votre espace personnel <strong class="text-secondary"><?= $session->get('user') ?></strong></h2>
   </div>
</main>