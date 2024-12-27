<?php
namespace App\Controllers;
use App\Models\Db_model;
use CodeIgniter\Exceptions\PageNotFoundException;
class Candidature extends BaseController
{
 public function __construct()
 {
   helper('form');
    $this->model = model(Db_model::class);
 }
 public function connecter() {
    if ($this->request->getMethod() == "post") {
        $code_dossier = addslashes(htmlspecialchars($this->request->getVar('code_dossier')));
        $code = addslashes(htmlspecialchars($this->request->getVar('code')));

        if (empty($code_dossier) || empty($code)) {
            $data["message"] = "<div class='alert alert-danger' role='alert'>
                Veuillez remplir tous les champs !
            </div>";
        }
        else if ($this->model->connect_candidature($code_dossier, $code) == true) {
            $data['candidature'] = $this->model->get_candidature($code_dossier);
            $data['document'] = $this->model->get_document($code_dossier);
            return view('templates/haut', $data)
                . view('candidature/affichage_candidature')
                . view('templates/bas');
        } 
        else {
            $data["message"] = "<div class='alert alert-danger' role='alert'>
                Code(s) erroné(s), aucune candidature (/inscription) trouvée ! 
            </div>";
        }

        return view('templates/haut', ['titre' => 'Accéder à sa candidature'])
            . view('candidature/candidature_connecter', $data)
            . view('templates/bas');
    }

    // Affichage initial du formulaire
    return view('templates/haut', ['titre' => 'Accéder à sa candidature'])
        . view('candidature/candidature_connecter')
        . view('templates/bas');
}

 public function afficher($code) {
   $data['candidature'] = $this->model->get_candidature($code);
   $data['document'] = $this->model->get_document($code);

   return view('templates/haut', $data)
       . view('candidature/affichage_candidature')
       . view('templates/bas');
  }

  public function supprimer($parametre) {
    // Séparation des paramètres
    $parts = explode('_', $parametre);
    $id = $parts[0];
    $id_concours = $parts[1];
    $code = $parts[2];
    $code_dossier = $parts[3];

    if ($id == 0) {
        return redirect()->to('/');
    }

    if($this->model->del_candidature($id)) {
        return view('templates/haut')
            . view('candidature/supprimer_succes')
            . view('templates/bas');
    } else {
        $data['candidature'] = $this->model->get_candidature($code_dossier);
        $data['document'] = $this->model->get_document($code_dossier);
        return view('templates/haut', $data)
            . view('candidature/affichage_candidature')
            . view('templates/bas');
    }
 }
}