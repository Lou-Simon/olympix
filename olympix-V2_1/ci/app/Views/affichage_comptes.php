<section id="about" class="about section">
<div class="container">
    <h2><?php echo $titre; ?></h2>
<?php
if(!empty($nb_comptes)) {
    echo "Nombre de comptes : ";
    echo $nb_comptes->nombre;
} else {
    echo "0 comptes";
}
if (! empty($logins) && is_array($logins))
{
foreach ($logins as $pseudos)
{
echo "<br />";
echo " -- ";
echo $pseudos["cpt_pseudo"];
echo " -- ";
echo "<br />";
}
}
else {
 echo("<h3>Aucun compte pour le moment</h3>");
}

?>
</div>
</section>