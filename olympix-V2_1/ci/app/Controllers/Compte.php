<?php
namespace App\Controllers;
use App\Models\Db_model;
use CodeIgniter\Exceptions\PageNotFoundException;
class Compte extends BaseController
{
 public function __construct()
 {
    helper('form');
    $this->model = model(Db_model::class);
 }
 public function lister() 
 {
 $data['titre']="Liste de tous les comptes";
 $data['logins'] = $this->model->get_all_compte();
 $data['nb_comptes'] = $this->model->get_nb_comptes();
 return view('templates/haut', $data)
 . view('affichage_comptes')
 . view('templates/bas');
 }

 public function creer()
 {
    // L’utilisateur a validé le formulaire en cliquant sur le bouton
    if ($this->request->getMethod()=="post")
    {
        if (! $this->validate([
            'pseudo' => 'required|valid_email|max_length[255]|min_length[2]',
            'mdp' => 'required|max_length[255]|min_length[8]'
        ],
        [ // Configuration des messages d’erreurs
            'pseudo' => [
                'required' => 'Veuillez entrer un pseudo pour le compte !',
                'valid_email' => 'Veuillez entrer une adresse email valide pour le pseudo !'
            ],
            'mdp' => [
                'required' => 'Veuillez entrer un mot de passe !',
                'min_length' => 'Le mot de passe saisi est trop court !'
            ]
        ]
        ))
                
        {
        // La validation du formulaire a échoué, retour au formulaire !
        return view('templates/haut', ['titre' => 'Créer un compte'])
        . view('compte/compte_creer')
        . view('templates/bas');
        }
        // La validation du formulaire a réussi, traitement du formulaire
        $recuperation = $this->validator->getValidated();
        $this->model->set_compte($recuperation);
        $data['le_compte']=$recuperation['pseudo'];
        $data['le_message']="Nouveau nombre de comptes : ";
        //Appel de la fonction créée dans le précédent tutoriel :
        $data['le_total']=$this->model->get_nb_comptes();
        return view('templates/haut', $data)
        . view('compte/compte_succes')
        . view('templates/bas');
        }
        // L’utilisateur veut afficher le formulaire pour créer un compte
    return view('templates/haut', ['titre' => 'Créer un compte'])
    . view('compte/compte_creer')
    . view('templates/bas');
 }





 public function connecter()
 {
    // L’utilisateur a validé le formulaire en cliquant sur le bouton
    if ($this->request->getMethod()=="post"){
        if (! $this->validate([
        'pseudo' => 'required',
        'mdp' => 'required'
        ]))
        { // La validation du formulaire a échoué, retour au formulaire !
            $data['message'] = "<p class='text-danger'>Identifiants erronés ou inexistants !</p>";
            return view('templates/haut')
            . view('connexion/compte_connecter',$data)
            . view('templates/bas');
        }
        // La validation du formulaire a réussi, traitement du formulaire
        $username = addslashes(htmlspecialchars($this->request->getVar('pseudo')));
        $password = addslashes(htmlspecialchars($this->request->getVar('mdp')));
        if ($this->model->connect_compte($username,$password)==true)
        {
            $session=session();
            $session->set('user',$username);
            //  Vérification du compte ADMIN/JURY 
            $data['titre']="Bienvenue sur votre espace privé";

            if ($this->model->get_admin($session->get('user')) && !$this->model->get_jury($session->get('user'))) {
                return view('templates/menu_admin',$data)
                . view('connexion/compte_accueil')
                . view('templates/bas_admin');
            } else if (!$this->model->get_admin($session->get('user')) && $this->model->get_jury($session->get('user'))) {
                return view('templates/menu_jury',$data)
                . view('connexion/compte_accueil')
                . view('templates/bas_admin');
            } else {
                $data['message'] = "<p class='text-danger'>Identifiants erronés ou inexistants !</p>";
                return view('templates/haut', ['titre' => 'Se connecter'])
                . view('connexion/compte_connecter')
                . view('templates/bas');
            }
        }
        else
        { 
            $data['message'] = "<p class='text-danger'>Identifiants erronés ou inexistants !</p>";
            return view('templates/haut', ['titre' => 'Se connecter'])
        . view('connexion/compte_connecter',$data)
        . view('templates/bas');
        }
    }
    // L’utilisateur veut afficher le formulaire pour se connecter
    return view('templates/haut', ['titre' => 'Se connecter'])
    . view('connexion/compte_connecter')
    . view('templates/bas');
 }

 public function afficher_profil()
{
    $session = session();
    if ($session->has('user'))
    {
        $cpt_pseudo = $session->get('user');
        $admin_profile = $this->model->get_admin($cpt_pseudo);
        $jury_profile = $this->model->get_jury($cpt_pseudo);
        // si admin ET non jury -> profil de ladmin
        if ($admin_profile && !$jury_profile) {
            $data['profil'] = $admin_profile;
            return view('templates/menu_admin', $data)
                . view('connexion/compte_profil_admin', $data)
                . view('templates/bas_admin');
        } 
        // si jury ET non admin -> profil du jury
        else if (!$admin_profile && $jury_profile) {
            $data['profil'] = $jury_profile;
            return view('templates/menu_jury', $data)
                . view('connexion/compte_profil_jury', $data)
                . view('templates/bas_admin');
        } 
        //sinon on redirige vers page de connexion
        else {
            return view('templates/haut', ['titre' => 'Se connecter'])
                . view('connexion/compte_connecter')
                . view('templates/bas');
        }
    }
    else
    {
        return view('templates/haut', ['titre' => 'Se connecter'])
            . view('connexion/compte_connecter')
            . view('templates/bas');
    }
}

 public function deconnecter()
 {
 $session=session();
 $session->destroy();
 return view('templates/haut', ['titre' => 'Se connecter'])
 . view('connexion/compte_connecter')
 . view('templates/bas');
 }

 public function afficher_changer_profil()
{
    $session = session();
    if ($session->has('user'))
    {
        $cpt_pseudo = $session->get('user');
        $admin_profile = $this->model->get_admin($cpt_pseudo);
        $jury_profile = $this->model->get_jury($cpt_pseudo);
        // si admin ET non jury -> profil de ladmin
        if ($admin_profile && !$jury_profile) {
            $data['profil'] = $admin_profile;
            return view('templates/menu_admin', $data)
                . view('connexion/compte_modifier_admin', $data)
                . view('templates/bas_admin');
        } 
        // si jury ET non admin -> profil du jury
        else if (!$admin_profile && $jury_profile) {
            $data['profil'] = $jury_profile;
            return view('templates/menu_jury', $data)
                . view('connexion/compte_modifier_jury', $data)
                . view('templates/bas_admin');
        } 
        //sinon on redirige vers page de connexion
        else {
            return viafficherCandidatsw('templates/haut', ['titre' => 'Se connecter'])
                . view('connexion/compte_connecter')
                . view('templates/bas');
        }
    }
    else
    {
        return view('templates/haut', ['titre' => 'Se connecter'])
            . view('connexion/compte_connecter')
            . view('templates/bas');
    }
}

public function modifierProfil() {
    $session = session();
    $cpt_pseudo = $session->get('user');
    $admin_profile = $this->model->get_admin($cpt_pseudo);
    $jury_profile = $this->model->get_jury($cpt_pseudo);

    if ($this->request->getMethod() == "post") {
        // Validation des champs
        if (!$this->validate(
            [
                'prenom' => 'required',
                'nom' => 'required',
                'discipline' => 'required',
                'biographie' => 'required',
                'url' => 'valid_url',
            ]
        )) {
            $data['message'] = "<p class='text-danger'>Champs de saisie vides !</p>";
            $data['validation'] = $this->validator;

            if (!$admin_profile && $jury_profile) {
                $data['profil'] = $jury_profile;
                return view('templates/menu_jury', $data)
                    . view('connexion/compte_modifier_jury', $data)
                    . view('templates/bas_admin');
            }
        }

        if (!$admin_profile && $jury_profile) {
            $prenom = addslashes(htmlspecialchars($this->request->getVar('prenom')));
            $nom = addslashes(htmlspecialchars($this->request->getVar('nom')));
            $discipline = addslashes(htmlspecialchars($this->request->getVar('discipline')));
            $biographie = addslashes(htmlspecialchars($this->request->getVar('biographie')));
            $url = addslashes(htmlspecialchars($this->request->getVar('url')));
            $cpt_pseudo = addslashes(htmlspecialchars($session->get('user')));
    
            if ($this->model->modifier_profil_jry($cpt_pseudo, $prenom, $nom, $discipline, $biographie, $url)) {
                $data['message'] = "<p class='text-success'>Les informations de votre profil ont été mises à jour !</p>";
            } else {
                $data['message'] = "<p class='text-danger'>Erreur lors de la mise à jour des informations du profil.</p>";
            }
        }
        
        $new_mdp1 = addslashes(htmlspecialchars($this->request->getVar('new_mdp1')));
        
        if (!empty($new_mdp1)) {
            $old_mdp = addslashes(htmlspecialchars($this->request->getVar('old_mdp')));
            if (strcmp($new_mdp1, $old_mdp) != 0) {
                $data['message'] = "<p class='text-danger'>Confirmation du mot de passe erronée, veuillez réessayer !</p>";
            }
            else if ($this->model->editer_mdp($cpt_pseudo, $new_mdp1)) {
                $data['message'] = "<p class='text-success'>Votre mot de passe a été mis à jour avec succès !</p>";
            } else {
                $data['message'] = "<p class='text-danger'>Erreur lors de la mise à jour du mot de passe.</p>";
            }
        }

        

        if ($admin_profile && !$jury_profile) {
            $data['profil'] = $admin_profile;
            return view('templates/menu_admin', $data)
                . view('connexion/compte_modifier_admin', $data)
                . view('templates/bas_admin');
        } else if (!$admin_profile && $jury_profile) {
            $data['profil'] = $jury_profile;
            return view('templates/menu_jury', $data)
                . view('connexion/compte_modifier_jury', $data)
                . view('templates/bas_admin');
        } else {
            return view('templates/haut')
                . view('connexion/compte_connecter')
                . view('templates/bas');
        }
    }

    return $this->afficher_profil();
    
}

public function afficherConcours() {
    $session = session();
    $cpt_pseudo = $session->get('user');
    $admin_profile = $this->model->get_admin($cpt_pseudo);
    $jury_profile = $this->model->get_jury($cpt_pseudo);

    if (!$admin_profile && $jury_profile) {
        $data['concours'] = $this->model->get_concours_jury($cpt_pseudo);
        return view('templates/menu_jury',$data)
            . view('connexion/compte_concours_jury')
            . view('templates/bas_admin');

    } else if ($admin_profile && !$jury_profile) {
        $data['concours'] = $this->model->get_all_concours();
        return view('templates/menu_admin',$data)
            . view('connexion/compte_concours_admin',$data)
            . view('templates/bas_admin');
    } else {
        return view('templates/haut')
            . view('connexion/compte_connecter')
            . view('templates/bas');
    }

}

public function afficherCandidats($id_concours = 0) {
    if ($id_concours == 0)
    {
    return redirect()->to('/');
    }
    $session = session();
    $cpt_pseudo = $session->get('user');
    $admin_profile = $this->model->get_admin($cpt_pseudo);
    $jury_profile = $this->model->get_jury($cpt_pseudo);
    if (!$admin_profile && $jury_profile) {
        $data['candidats'] = $this->model->get_all_candidats($id_concours);

        return view('templates/menu_jury', $data)
            . view('connexion/afficher_candidats_jury', $data)
            . view('templates/bas_admin');
     } 
    else {
        return view('templates/haut')
            . view('connexion/compte_connecter')
            . view('templates/bas');
    }
}

    public function afficherDetailConcours($id_concours = 0) {
        if ($id_concours == 0)
        {
        return redirect()->to('/');
        }
        $session = session();
        $cpt_pseudo = $session->get('user');
        $admin_profile = $this->model->get_admin($cpt_pseudo);
        $jury_profile = $this->model->get_jury($cpt_pseudo);
        if ($admin_profile && !$jury_profile) {
            $data['concours'] = $this->model->get_detail_concours($id_concours);
    
            return view('templates/menu_admin', $data)
                . view('connexion/detail_concours_admin', $data)
                . view('templates/bas_admin');
         } 
        else {
            return view('templates/haut')
                . view('connexion/compte_connecter')
                . view('templates/bas');
        }
    }

    public function afficherCandidatures($id_concours = 0) {
        if ($id_concours == 0)
        {
        return redirect()->to('/');
        }
        $session = session();
        $cpt_pseudo = $session->get('user');
        $admin_profile = $this->model->get_admin($cpt_pseudo);
        $jury_profile = $this->model->get_jury($cpt_pseudo);
        if ($admin_profile && !$jury_profile) {
            $data['candidats'] = $this->model->get_candidatures($id_concours);
    
            return view('templates/menu_admin', $data)
                . view('connexion/afficher_candidatures', $data)
                . view('templates/bas_admin');
        } else {
            return view('templates/haut')
                . view('connexion/compte_connecter')
                . view('templates/bas');
        }
    }

    public function afficher_galerie($id_concours = 0) {
        if ($id_concours == 0)
        {
        return redirect()->to('/');
        }
        $session = session();
        $cpt_pseudo = $session->get('user');
        $admin_profile = $this->model->get_admin($cpt_pseudo);
        $jury_profile = $this->model->get_jury($cpt_pseudo);
        if ($admin_profile && !$jury_profile) {
            $data['galerie'] = $this->model->get_documents($id_concours);

            return view('templates/menu_admin', $data)
                . view('connexion/afficher_galerie', $data)
                . view('templates/bas_admin');
        } else {
            return view('templates/haut')
                . view('connexion/compte_connecter')
                . view('templates/bas');
        }
    }

    public function afficher_palmares($id_concours = 0) {
        if ($id_concours == 0)
        {
        return redirect()->to('/');
        }
        $session = session();
        $cpt_pseudo = $session->get('user');
        $admin_profile = $this->model->get_admin($cpt_pseudo);
        $jury_profile = $this->model->get_jury($cpt_pseudo);
        if ($admin_profile && !$jury_profile) {
            $data['palmares'] = $this->model->get_palmares($id_concours);

            return view('templates/menu_admin', $data)
                . view('connexion/afficher_palmares', $data)
                . view('templates/bas_admin');
        } else {
            return view('templates/haut')
                . view('connexion/compte_connecter')
                . view('templates/bas');
        }
    }

    public function afficher_gestion() {
        $session = session();
        $cpt_pseudo = $session->get('user');
        $admin_profile = $this->model->get_admin($cpt_pseudo);
        $jury_profile = $this->model->get_jury($cpt_pseudo);
    
        if ($admin_profile && !$jury_profile) {
            $data['comptes'] = $this->model->get_all_comptes_admin();
            return view('templates/menu_admin',$data)
                . view('connexion/gestion_compte',$data)
                . view('templates/bas_admin');
        } else {
            return view('templates/haut')
                . view('connexion/compte_connecter')
                . view('templates/bas');
        }
    }

    public function creerProfil() {
        $session = session();
        $cpt_pseudo = $session->get('user');
        $admin_profile = $this->model->get_admin($cpt_pseudo);
        $jury_profile = $this->model->get_jury($cpt_pseudo);
    
        if ($this->request->getMethod() == "post") {
            // Validation des champs
            if (!$this->validate(
                [
                    'email' => 'required',
                    'mdp' => 'required',
                    'statut' => 'required'                ]
            )) {
                $data['message'] = "<p class='text-danger'>Champs de saisie vides !</p>";
                $data['validation'] = $this->validator;
                $data['comptes'] = $this->model->get_all_comptes_admin(); 

    
                if ($admin_profile && !$jury_profile) {
                    return view('templates/menu_admin', $data)
                        . view('connexion/gestion_compte', $data)
                        . view('templates/bas_admin');
                }
            }
    
            if($admin_profile && !$jury_profile) {
                $email = addslashes(htmlspecialchars($this->request->getVar('email')));
                $mdp = addslashes(htmlspecialchars($this->request->getVar('mdp')));
                $statut = addslashes(htmlspecialchars($this->request->getVar('statut')));
                
                if($this->model->creer_compte($email, $mdp, $statut)) {
                    session()->setFlashdata('success', 'Compte créé avec succès');
                    $data['comptes'] = $this->model->get_all_comptes_admin(); 
                    $data['messages']='compte créer avec success';
                    return view('templates/menu_admin', $data)
                        . view('connexion/gestion_compte', $data)
                        . view('templates/bas_admin');
                } else {
                    $data['comptes'] = $this->model->get_all_comptes_admin(); 
                    $data['messages']="Le compte ne peut pas être créé !";
                    return view('templates/menu_admin', $data)
                        . view('connexion/gestion_compte', $data)
                        . view('templates/bas_admin');
                }
            } else {
                return view('templates/haut')
                    . view('connexion/compte_connecter')
                    . view('templates/bas');
            }
        }
    
        $data['comptes'] = $this->model->get_all_comptes_admin();
        return view('templates/menu_admin', $data)
            . view('connexion/gestion_compte', $data)
            . view('templates/bas_admin');
    }

    public function desactiver($cpt_pseudo_a_modifier, $status) {
        $session = session();
        $cpt_pseudo = $session->get('user');
        $admin_profile = $this->model->get_admin($cpt_pseudo);
        $jury_profile = $this->model->get_jury($cpt_pseudo);

        if (!$admin_profile || $cpt_pseudo == null) {
            return redirect()->to('/');
        }
        
        if($this->model->desactiver_activer_compte($cpt_pseudo_a_modifier, $status)) {
            $data['mess'] = " <div class='alert alert-success'>
            Etat du compte modifé avec succès
             </div>";
        } else {
            $data['mess'] = " <div class='alert alert-danger'>
            Erreur dans la modification du compte
             </div>";
        }
    
        if($admin_profile && !$jury_profile) {
            $data['comptes'] = $this->model->get_all_comptes_admin();
            return view('templates/menu_admin', $data)
                . view('connexion/gestion_compte', $data)
                . view('templates/bas_admin');
        } else {
            return view('templates/haut')
                . view('connexion/compte_connecter')
                . view('templates/bas');
        }
        
    }



    public function modifierGestionProfil($compte_pseudo, $status)
    {
        $session = session();
        $cpt_pseudo = $session->get('user');
        $admin_profile = $this->model->get_admin($cpt_pseudo);
    
        if ($this->request->getMethod() == "post") {
            if ($status == 'J') {
                if (!$this->validate([
                    'prenom' => 'required',
                    'nom' => 'required',
                    'discipline' => 'required',
                    'biographie' => 'required',
                    'url' => 'valid_url',
                ])) {
                    $data['message'] = "<p class='text-danger'>Champs de saisie vides !</p>";
                    $data['validation'] = $this->validator;
                    return $this->afficher_gestion();
                }
    
                $prenom = addslashes(htmlspecialchars($this->request->getVar('prenom')));
                $nom = addslashes(htmlspecialchars($this->request->getVar('nom')));
                $discipline = addslashes(htmlspecialchars($this->request->getVar('discipline')));
                $biographie = addslashes(htmlspecialchars($this->request->getVar('biographie')));
                $url = addslashes(htmlspecialchars($this->request->getVar('url')));
    
                if ($this->model->modifier_profil_jry($compte_pseudo, $prenom, $nom, $discipline, $biographie, $url)) {
                    $data['message'] = "<p class='text-success'>Les informations du profil ont été mises à jour !</p>";
                } else {
                    $data['message'] = "<p class='text-danger'>Erreur lors de la mise à jour des informations du profil.</p>";
                }
            }
    
            $mdp = $this->request->getVar('mdp');
            if (!empty($mdp)) {
                if ($this->model->editer_mdp($compte_pseudo, $mdp)) {
                    $data['message'] = "<p class='text-success'>Le mot de passe a été mis à jour avec succès !</p>";
                } else {
                    $data['message'] = "<p class='text-danger'>Erreur lors de la mise à jour du mot de passe.</p>";
                }
            }
    
            $data['comptes'] = $this->model->get_all_comptes_admin();
            return view('templates/menu_admin', $data)
                 . view('connexion/gestion_compte', $data)
                 . view('templates/bas_admin');
        }
    
        return $this->afficher_gestion();
    }

    public function supprimerConcours($parametre) {
        $session = session();
        $cpt_pseudo = $session->get('user');
        $admin_profile = $this->model->get_admin($cpt_pseudo);
        $jury_profile = $this->model->get_jury($cpt_pseudo);
        if($admin_profile && !$jury_profile) {
            // Séparation des paramètres
            $parts = explode('_', $parametre);
            $autre1 = $parts[0];
            $id = $parts[1];
            $autre2 = $parts[2];
            if ($id == 0) {
                return redirect()->to('/');
            }
        
            if($this->model->del_concours($id)) {
                $data['concours'] = $this->model->get_all_concours();
                return view('templates/menu_admin',$data)
                    . view('connexion/compte_concours_admin',$data)
                    . view('templates/bas_admin');
            } else {
                $data['concours'] = $this->model->get_all_concours();
                return view('templates/menu_admin',$data)
                . view('connexion/compte_concours_admin',$data)
                . view('templates/bas_admin');
            }
        } else {
            return view('templates/haut')
                . view('connexion/compte_connecter')
                . view('templates/bas');
        }
    }

    public function creerConcours() {
        $session = session();
        $cpt_pseudo = $session->get('user');
        $admin_profile = $this->model->get_admin($cpt_pseudo);
        $jury_profile = $this->model->get_jury($cpt_pseudo);
    
        if (!$admin_profile || $jury_profile) {
            return view('templates/haut')
            . view('connexion/compte_connecter')
            . view('templates/bas');
        }
    
        if ($this->request->getMethod() == "post") {
            $nom = addslashes(htmlspecialchars($this->request->getVar('nom')));
            $desc = addslashes(htmlspecialchars($this->request->getVar('desc')));
            $debut = addslashes(htmlspecialchars($this->request->getVar('debut')));
            $j_candidature = addslashes(htmlspecialchars($this->request->getVar('j_candidature')));
            $j_preselection = addslashes(htmlspecialchars($this->request->getVar('j_preselection')));
            $j_selection = addslashes(htmlspecialchars($this->request->getVar('j_selection')));
            $edition = addslashes(htmlspecialchars($this->request->getVar('edition')));

    
            if (empty($nom) || empty($desc) || empty($debut) || empty($j_candidature) || 
                empty($j_preselection) || empty($j_selection) || empty($edition)) {
                $data['message'] = "<p class='text-danger'>Tous les champs sont obligatoires !</p>";
            } 
            else if (strtotime($debut) < strtotime(date('Y-m-d'))) {
                $data['message'] = "<p class='text-danger'>La date de début ne peut pas être antérieure à aujourd'hui !</p>";
            }
            else {
                if ($this->model->creer_concours($nom, $desc, $debut, $j_candidature, 
                    $j_preselection, $j_selection, $edition, $cpt_pseudo)) {
                    $session->setFlashdata('success', 'Concours créé avec succès');
                    $data['concours'] = $this->model->get_all_concours();
                    return view('templates/menu_admin',$data)
                    . view('connexion/compte_concours_admin',$data)
                    . view('templates/bas_admin');
                } else {
                    $data['message'] = "<p class='text-danger'>Erreur lors de la création du concours !</p>";
                }
            }
        }
    
        $data['concours'] = $this->model->get_all_concours();
        return view('templates/menu_admin',$data)
        . view('connexion/compte_concours_admin',$data)
        . view('templates/bas_admin');
    }
}