<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
use App\Controllers\Accueil;
use App\Controllers\Page;
use App\Controllers\Admin_accueil;
use App\Controllers\Compte;
use App\Controllers\Actualite;
use App\Controllers\Concours;
use App\Controllers\Candidature;

// Routes Accueil
$routes->get('/', [Accueil::class, 'afficher']);
$routes->get('accueil/afficher', [Accueil::class, 'afficher']);

// Routes actualités
$routes->get('actualite/afficher', [Actualite::class, 'afficher']);
$routes->get('actualite/afficher/(:num)', [Actualite::class, 'afficher']);

// Routes concours
$routes->get('concours/afficher', [Concours::class, 'afficher']);
$routes->get('concours/afficher_galerie/(:num)', [Concours::class, 'afficherGalerie']);

// Routes comptes
$routes->get('compte/lister', [Compte::class, 'lister']);
$routes->get('compte/creer', [Compte::class, 'creer']);
$routes->post('compte/creer', [Compte::class, 'creer']);
$routes->get('compte/connecter', [Compte::class, 'connecter']);
$routes->post('compte/connecter', [Compte::class, 'connecter']);
$routes->get('compte/deconnecter', [Compte::class, 'deconnecter']);
$routes->get('compte/afficher_profil', [Compte::class, 'afficher_profil']); 
$routes->get('compte/compte_connecter', [Compte::class, 'connecter']); 
$routes->get('compte/modifierProfil', [Compte::class, 'modifierProfil']);
$routes->post('compte/modifierProfil', [Compte::class, 'modifierProfil']);
$routes->get('connexion/compte_modifier_jury', [Compte::class, 'afficher_changer_profil']);
$routes->get('connexion/compte_modifier_admin', [Compte::class, 'afficher_changer_profil']);
$routes->get('connexion/compte_concours_jury', [Compte::class, 'afficherConcours']);
$routes->get('connexion/compte_concours_admin', [Compte::class, 'afficherConcours']);
$routes->get('connexion/afficher_candidats_jury/(:num)', [Compte::class, 'afficherCandidats']);
$routes->get('connexion/detail_concours_admin/(:num)', [Compte::class, 'afficherDetailConcours']);
$routes->get('connexion/afficher_candidatures/(:num)', [Compte::class, 'afficherCandidatures']);
$routes->get('connexion/galerie/(:num)', [Compte::class, 'afficher_galerie']);
$routes->get('connexion/palmares/(:num)', [Compte::class, 'afficher_palmares']);
$routes->get('connexion/gestion_compte', [Compte::class, 'afficher_gestion']);
$routes->get('compte/creerProfil', [Compte::class, 'creerProfil']);
$routes->post('compte/creerProfil', [Compte::class, 'creerProfil']);
$routes->get('compte/desactiver/(:any)/(:any)', [Compte::class, 'desactiver']);
$routes->post('compte/modifierGestionProfil/(:any)/(:any)', [Compte::class, 'modifierGestionProfil']);
$routes->get('compte/modifierGestionProfil/(:any)/(:any)', [Compte::class, 'modifierGestionProfil']);
$routes->get('connexion/supprimer/(:any)', [Compte::class, 'supprimerConcours']);
$routes->get('compte/creerConcours', [Compte::class, 'creerConcours']);
$routes->post('compte/creerConcours', [Compte::class, 'creerConcours']);

//Routes candidatures
$routes->get('candidature/afficher/(:any)', [Candidature::class, 'afficher']);
$routes->get('candidature/candidature_connecter', [Candidature::class, 'connecter']);
$routes->match(['get', 'post'], 'candidature/connecter', [Candidature::class, 'connecter']);
$routes->get('candidature/supprimer/(:any)', [Candidature::class, 'supprimer']);

?>