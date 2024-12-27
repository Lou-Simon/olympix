<?php
namespace App\Controllers;
use App\Models\Db_model;
use CodeIgniter\Exceptions\PageNotFoundException;
class Accueil extends BaseController
{
// Fonction qui affiche le contenu de la page accueil avec le haut et le bas de page.
 public function afficher()
 {
 $model = model(Db_model::class);
 $data['titre']="Les dernières actualités :";
 $data['actus'] = $model->get_all_actualite();
 return view('templates/haut', $data)
 . view('affichage_accueil')
 . view('templates/bas');
 }
}

?>