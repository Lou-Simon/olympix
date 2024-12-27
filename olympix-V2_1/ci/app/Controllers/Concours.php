<?php
namespace App\Controllers;
use App\Models\Db_model;
use CodeIgniter\Exceptions\PageNotFoundException;
class Concours extends BaseController
{
    public function __construct()
    {
       $this->model = model(Db_model::class);
    }
// Fonction qui affiche le contenu de la page des concours avec le haut et le bas de page.
 public function afficher()
 {
 $model = model(Db_model::class);
 $data['concours'] = $model->get_all_concours();
 return view('templates/haut', $data)
 . view('affichage_concours')
 . view('templates/bas');
 }
 
 public function afficherGalerie($id_concours) {
   $data['categories'] = $this->model->get_categories($id_concours);
   $data['id_concours'] = $id_concours;
   $data['model'] = $this->model;
   
   return view('templates/haut', $data)
       . view('concours/affichage_galerie')
       . view('templates/bas');
 }
}

?>