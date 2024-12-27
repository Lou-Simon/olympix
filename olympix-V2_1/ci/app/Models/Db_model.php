<?php
namespace App\Models;
use CodeIgniter\Model;
class Db_model extends Model
{
 protected $db;
 public function __construct()
 {
 $this->db = db_connect(); //charger la base de données
 // ou
 // $this->db = \Config\Database::connect();
 }
// Fonction permettant de récupérer les email de tous les comptes.
 public function get_all_compte()
 {
 $resultat = $this->db->query("SELECT cpt_pseudo FROM t_compte_cpt;");
 return $resultat->getResultArray();
 }
// Fonction permettant de récupérer le nombre total de comptes.
 public function get_nb_comptes() {
    $requete = "SELECT COUNT(cpt_pseudo) AS nombre FROM t_compte_cpt;";
    $resultat = $this->db->query($requete);
    return $resultat->getRow();
 }

//  Fonction permettant de créer un compte (insérer des données dans la table t_compte_cpt)
 public function set_compte($saisie)
 {
 $login=$saisie['pseudo'];
 $mot_de_passe=$saisie['mdp'];
 $sql="INSERT INTO t_compte_cpt VALUES('".$login."','".$mot_de_passe."');";
 return $this->db->query($sql);
 }

//  Fonction permettant de connecter un organisateur ou juré au backoffice de l'application
 public function connect_compte($u, $p)
{
    $sell = 'ceciestmonsell1234';

    $sql = "
        SELECT cpt_pseudo, cpt_mdp
        FROM t_compte_cpt
        WHERE cpt_pseudo = '" . $u . "'
        AND cpt_mdp = SHA2(CONCAT('".$p."','".$sell ."'), 256)
    ";

    $resultat = $this->db->query($sql);

    if ($resultat->getNumRows() > 0) {
        return true;
    } else {
        return false;
    }
}

// Fonction permettant d'etiter le mot de passe d'un organisateur ou juré
public function editer_mdp($cpt_pseudo, $new_mdp)
{
    $sell = 'ceciestmonsell1234';
    $sql = "UPDATE t_compte_cpt 
            SET cpt_mdp = SHA2(CONCAT('".$new_mdp."','".$sell."'), 256) 
            WHERE cpt_pseudo = '".$cpt_pseudo."'";
    return $this->db->query($sql);   
}

// Fonction permettant de modifier le profil d'un juré (hormis son email)
public function modifier_profil_jry($cpt_pseudo, $prenom, $nom, $discipline, $biographie, $url)
{

    $sql = "UPDATE t_jury_jry 
            SET jry_prenom='".$prenom."', jry_nom='".$nom."', jry_discipline='".$discipline."', jry_biographie='".$biographie."', jry_url='".$url."' 
            WHERE cpt_pseudo = '".$cpt_pseudo."'";
    $query = $this->db->query($sql);

    if ($query) {
        return true;
    } else {
        return false;
    }
}


// fonction qui retourne le profil de l'admin si le pseudo et l'état correspondent, false sinon
public function get_admin($cpt_pseudo) {
    $sql = "SELECT * FROM t_gerant_grt WHERE cpt_pseudo = '".$cpt_pseudo."' AND grt_etat='A' OR grt_etat='S';";
    $resultat = $this->db->query($sql);
    if($resultat->getNumRows() > 0) {
      return $resultat->getRow();
    }
    return false;
  }

  // fonction qui retourne le profil du jury si le pseudo et l'état correspondent, false sinon
  public function get_jury($cpt_pseudo) {
    $sql = "SELECT * FROM t_jury_jry WHERE cpt_pseudo = '".$cpt_pseudo."' AND jry_etat='A';";
    $resultat = $this->db->query($sql);
    if($resultat->getNumRows() > 0) {
      return $resultat->getRow();
    }
    return false;
  }

// Fonction permettant de récupérer une actualitée dont l'identifiant est passé en paramètre.
 public function get_actualite($numero)
 {
 $requete="SELECT * FROM t_actualite_act WHERE act_id=".$numero.";";
 $resultat = $this->db->query($requete);
 return $resultat->getRow();
 }
// Fonction petmettant de récupérer toutes les informations des 5 dernières actualités triées dans l'ordre décroissant
 public function get_all_actualite()
 {
 $resultat = $this->db->query("SELECT * FROM t_actualite_act WHERE act_etat='A' ORDER BY act_date DESC LIMIT 5");
 return $resultat->getResultArray();
 }
// Fonction permettant de récupérer les informations d'un concours, les jurés associés, les catégories disponibles, les dates des différentes phases, ...
 public function get_all_concours() {
    $resultat = $this->db->query("SELECT 
    crs_id,
    crs_nom AS nom,
    crs_date_debut AS debut,
    ADDDATE(crs_date_debut, crs_nb_jour_candidature) AS candidature,
    ADDDATE(crs_date_debut, crs_nb_jour_candidature + crs_nb_jour_preselection) AS pre_selection, 
    ADDDATE(crs_date_debut, crs_nb_jour_candidature + crs_nb_jour_preselection + crs_nb_jour_selection) AS finale,
    donnee_categorie(crs_id) AS categories,
    donnee_phase(crs_id) AS phase,
    donnee_jury(crs_id) AS jures,
    cpt_pseudo AS organisateur 
    FROM 
        t_concours_crs
    ORDER BY 
    phase");
    return $resultat->getResultArray();
 }

//  fonction permettant de récupérer les informations de tous les concours qu'un juré juge
 public function get_concours_jury($pseudo) {
    $sql="SELECT 
        crs_id,
        crs_nom AS nom,
        crs_date_debut AS debut,
        crs_edition,
        t_concours_crs.cpt_pseudo AS organisateur,
        donnee_phase(crs_id) AS phase,
        donnee_categorie(crs_id) AS categories
        FROM t_concours_crs 
        JOIN t_juge_jug USING(crs_id)
        JOIN t_jury_jry ON t_juge_jug.cpt_pseudo = t_jury_jry.cpt_pseudo
        WHERE t_jury_jry.cpt_pseudo = '".$pseudo."'
        ORDER BY phase;

        ";
    $resultat = $this->db->query($sql);
    return $resultat->getResultArray();

 }

//  fonction permettant de connecter un candidat (en vérifiant les deux codes)
 public function connect_candidature($code_dossier, $code)
{

    $sql = "
        SELECT *
        FROM t_candidature_cdt
        WHERE cdt_code_dossier = '" . $code_dossier . "'
        AND cdt_code = '".$code."'
    ";

    $resultat = $this->db->query($sql);

    if ($resultat->getNumRows() > 0) {
        return true;
    } else {
        return false;
    }
}

//  Fonction permettant de récupérer toutes les informations d'une candidature en conaissant son code de dossier (on ne récupère pas les documents associés)
 public function get_candidature($code) {

   $requete = "SELECT * FROM t_candidature_cdt
               JOIN t_concours_crs USING (crs_id)
               JOIN t_categorie_cat USING(cat_id)
               JOIN t_document_doc USING(cdt_id)
               WHERE cdt_code_dossier = '".$code."';";
   $resultat = $this->db->query($requete);
   return $resultat->getRow();
 }

//  fonction permettant de récupérer tous les documents associés à une candidature en connaissant son code de dossier
 public function get_document($code) {

   $requete = "SELECT * FROM t_document_doc
               JOIN t_candidature_cdt USING(cdt_id)
               WHERE cdt_code_dossier = '".$code."';";
   $resultat = $this->db->query($requete);
   return $resultat->getResultArray();
 }

//  fonction permettant de récupérer tous les candidat d'un concours connaissant son id
 public function get_all_candidats($id_concours) {
    $sql = 'SELECT * FROM t_candidature_cdt
    JOIN t_categorie_cat USING(cat_id)
    WHERE crs_id = "'.$id_concours.'";';
    $resultat = $this->db->query($sql);
    return $resultat->getResultArray();
 }

// fonction permettant de récupérer les détails d'un concours connaissant son id
 public function get_detail_concours($id_concours) {
    $sql="SELECT 
    crs_nom AS nom,
    crs_date_debut AS debut,
    ADDDATE(crs_date_debut, crs_nb_jour_candidature) AS candidature,
    ADDDATE(crs_date_debut, crs_nb_jour_candidature + crs_nb_jour_preselection) AS pre_selection, 
    ADDDATE(crs_date_debut, crs_nb_jour_candidature + crs_nb_jour_preselection + crs_nb_jour_selection) AS finale,
    donnee_categorie(crs_id) AS categories,
    donnee_phase(crs_id) AS phase,
    donnee_jury(crs_id) AS jures,
    cpt_pseudo AS organisateur 
    FROM 
        t_concours_crs 
    WHERE crs_id = '".$id_concours."'";
    $resultat = $this->db->query($sql);
    return $resultat->getRow();
 }

//  fonction permettant de récupérer les candidatures d'un concours connaissant son id
 public function get_candidatures($id_concours) {
    $sql="SELECT *
    FROM 
        t_candidature_cdt
    WHERE crs_id = '".$id_concours."'";
    $resultat = $this->db->query($sql);
    return $resultat->getResultArray();
 }

 //  fonction permettant de récupérer les documents d'un concours connaissant son id

 public function get_documents($id_concours) {
    $sql = "
    SELECT 
        cdt_nom,
        cdt_prenom,
        doc_nom
    FROM t_document_doc
    JOIN 
        t_candidature_cdt USING(cdt_id)
    WHERE 
        crs_id = '".$id_concours."'
";
    $resultat = $this->db->query($sql);
    return $resultat->getResultArray();
 }

 //  fonction permettant de récupérer le palmarès d'un concours connaissant son id

 public function get_palmares($id_concours) {
    $sql = "SELECT cdt_nom, cdt_prenom, SUM(evl_note) AS total_points
    FROM t_evalue_evl
    JOIN t_candidature_cdt USING (cdt_id)
    JOIN t_concours_crs USING (crs_id)
    WHERE crs_id = '".$id_concours."'
    GROUP BY cdt_id, cdt_nom, cdt_prenom
    ORDER BY total_points DESC;";
    $resultat = $this->db->query($sql);
    return $resultat->getResultArray();
 }

//  fonction permettant de supprimer une candidature, connaissant son id
public function del_candidature($id_candidature) {
    $sql = "DELETE FROM t_candidature_cdt WHERE cdt_id = '$id_candidature'";
    $resultat = $this->db->query($sql);
    
    return $resultat ? true : false;
}

//  fonction permettant de récupérer la liste des comptes organisateurs et jurés
 public function get_all_comptes_admin(){
    $sql = "SELECT * FROM vue_jry_info";
    $resultat = $this->db->query($sql);
    return $resultat->getResultArray();
 }

//  fonction permettant de créer un compte organisateur ou juré
public function creer_compte($email, $mdp, $statut) {
    $check = "SELECT * FROM t_compte_cpt WHERE cpt_pseudo = '$email'";
    $etat = $this->db->query($check)->getRow();

    if ($etat) {
        return false;
    }

    $sql = "CALL creer_compte('$email', '$mdp', '$statut')";
    $resultat = $this->db->query($sql);

    return $resultat ? true : false;
}

// fonction permettant de désactiver/activer un compte organisateur ou juré
 public function desactiver_activer_compte($cpt_pseudo, $status) {
    if($status == 'J') {
        $check = "SELECT jry_etat FROM t_jury_jry WHERE cpt_pseudo = '".$cpt_pseudo."'";
        $etat = $this->db->query($check)->getRow();
        
        if($etat->jry_etat == 'A') {
            $nouvel_etat = 'D';
        } else {
            $nouvel_etat = 'A';
        }
        
        $sql = "UPDATE t_jury_jry SET jry_etat = '".$nouvel_etat."' WHERE cpt_pseudo = '".$cpt_pseudo."'";
        $resultat = $this->db->query($sql);
        
        if($resultat) {
            return true;
        } else {
            return false;
        }
        
    } else {
        $check = "SELECT grt_etat FROM t_gerant_grt WHERE cpt_pseudo = '".$cpt_pseudo."'";
        $etat = $this->db->query($check)->getRow();
        
        if($etat->grt_etat == 'A') {
            $nouvel_etat = 'D';
        } else {
            $nouvel_etat = 'A';
        }
        
        if($nouvel_etat == 'D') {
            $sql1 = "UPDATE t_concours_crs SET cpt_pseudo ='organisateur@concoursphotomaritime.com' 
                    WHERE cpt_pseudo = '".$cpt_pseudo."'";
            $sql2 = "DELETE FROM t_actualite_act 
                    WHERE cpt_pseudo = '".$cpt_pseudo."'";
            $sql3 = "UPDATE t_gerant_grt SET grt_etat = 'D' 
                    WHERE cpt_pseudo = '".$cpt_pseudo."'";

            $resultat1 = $this->db->query($sql1);
            $resultat2 = $this->db->query($sql2);
            $resultat3 = $this->db->query($sql3);

            if($resultat1 && $resultat2 && $resultat3) {
                return true;
            } else {
                return false;
            }
            
        } else {
            $sql = "UPDATE t_gerant_grt SET grt_etat = 'A' 
                    WHERE cpt_pseudo = '".$cpt_pseudo."'";
            $resultat = $this->db->query($sql);
            if($resultat) {
                return true;
            } else {
                return false;
            }
        }
    }
 }

//  fonction permettant de récupérer toutes les catégories d'un concours dont on passe l'id en paramètres
 public function get_categories($id_concours) {
    $sql = "SELECT DISTINCT cat_nom
            FROM t_candidature_cdt cdt
            JOIN t_document_doc doc USING(cdt_id)
            JOIN t_categorie_cat USING(cat_id)
            WHERE crs_id = '$id_concours'
            ORDER BY cat_nom";
            
    $resultat = $this->db->query($sql);
    return $resultat->getResultArray();
}

// fonction permettant de récupérer tous les candidats et leurs documents d'un concours classés par catégories
public function get_candidats_par_categorie($id_concours, $categorie) {
    $sql = "SELECT cdt.cdt_id, cdt_nom, cdt_prenom, doc_nom
            FROM t_candidature_cdt cdt
            JOIN t_document_doc doc USING(cdt_id)
            JOIN t_categorie_cat USING(cat_id)
            WHERE crs_id = '$id_concours' 
            AND cat_nom = '$categorie'
            ORDER BY cdt_nom, doc_nom";
            
    $resultat = $this->db->query($sql);
    return $resultat->getResultArray();
}

// fonction permettant de supprimer un concours 
 public function del_concours($id_concours) {
    $sql1 = "DELETE evl FROM t_evalue_evl evl JOIN t_candidature_cdt cdt USING (cdt_id) WHERE cdt.crs_id = '".$id_concours."';";
    $sql2 = "DELETE doc FROM t_document_doc doc JOIN t_candidature_cdt cdt USING (cdt_id) WHERE cdt.crs_id = '".$id_concours."';";
    $sql3 = "DELETE FROM t_candidature_cdt WHERE crs_id = '".$id_concours."';";
    $sql4 = "DELETE msg FROM t_message_msg msg JOIN t_discussion_dsc dsc USING (dsc_id) WHERE dsc.crs_id = '".$id_concours."';";
    $sql5 = "DELETE FROM t_discussion_dsc WHERE crs_id = '".$id_concours."';";
    $sql6 = "DELETE FROM t_actualite_act WHERE crs_id = '".$id_concours."';";
    $sql7 = "DELETE FROM t_possede_psd WHERE crs_id = '".$id_concours."';";
    $sql8 = "DELETE FROM t_juge_jug WHERE crs_id = '".$id_concours."';";
    $sql9 = "DELETE FROM t_concours_crs WHERE crs_id = '".$id_concours."';";

    $resultat1 = $this->db->query($sql1);
    $resultat2 = $this->db->query($sql2);
    $resultat3 = $this->db->query($sql3);
    $resultat4 = $this->db->query($sql4);
    $resultat5 = $this->db->query($sql5);
    $resultat6 = $this->db->query($sql6);
    $resultat7 = $this->db->query($sql7);
    $resultat8 = $this->db->query($sql8);
    $resultat9 = $this->db->query($sql9);

    if($resultat1 && $resultat2 && $resultat3 && $resultat4 && $resultat5 && $resultat6 && $resultat7 && $resultat8 && $resultat9) {
        return true;
    } else {
        return false;
    }
 }

//  fonction permettant de créer un concours
 public function creer_concours($nom, $desc, $debut, $j_candidature, $j_preselection, $j_selection, $edition, $organisateur) {
    $sql = "INSERT INTO t_concours_crs VALUES (NULL, '".$nom."', '".$desc."', '".$debut."' ,'".$j_candidature."','".$j_preselection."','".$j_selection."','image.jpg', '".$edition."', '".$organisateur."')";
    $resultat = $this->db->query($sql);
    if($resultat) {
        return true;
    } else {
        return false;
    }
}

}