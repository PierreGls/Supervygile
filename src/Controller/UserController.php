<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Entity\Projet;
use App\Entity\Groupe;
use App\Entity\Fonctionnalite;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;

class UserController extends Controller
{
    /**
     * @Route("/user", name="user")
     */
    public function index($infos)
    {
		$session = new Session();
		$session->set('login', $infos['login']);
		
		$repository = $this->getDoctrine()->getRepository(Utilisateur::class);
		$user = $repository->findOneBy(['login' => $infos['login']]);
		
		//récupère les groupes associés à l'utilisateur courant
		$user_groupes = $user->getGroupes();
		$projets=array();
		foreach ( $user_groupes as &$groupe){
			$projets_du_groupe = $groupe->getProjet();
			foreach ($projets_du_groupe as &$projet){
				$projets[] = $projet;
			}
		}
		
		
		return $this->render('connectedAccueilTemplate.html.twig',['controller_name' => 'UserController', "infos" => $infos,  "projets" => $projets, ]);
    }
	
	/**
     * @Route("/CreateUser", name="create_user")
     */
	public function create($infos){
		$entityManager = $this->getDoctrine()->getManager();

        $user = new Utilisateur();
        $user->setLogin($infos['login']);
        $user->setPassword($infos['pwd']);
        $user->setMail($infos['mail']);
		$user->setNom($infos['nom']);
		$user->setPrenom($infos['prenom']);

        // tell Doctrine you want to (eventually) save the user (no queries yet)
        $entityManager->persist($user);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();
		
        return $this->index($infos);
	}
	
	/**
     * @Route("/signout", name="signout")
     */
    public function signOut()
    {
		$session = new Session();
		$session->invalidate();
        return $this->forward('App\Controller\AnonymousController::accueil');
    }
	
	/**
     * @Route("/connectedAccueil", name="connectedAccueil")
     */
    public function connectedAccueil()
    {
		$session = new Session();
		$login = $session->get('login');
		
		$repository = $this->getDoctrine()->getRepository(Utilisateur::class);
		$user = $repository->findOneBy(['login' => $login]);
		
		//récupère les groupes associés à l'utilisateur courant
		$user_groupes = $user->getGroupes();
		$projets=array();
		foreach ( $user_groupes as &$groupe){
			$projets_du_groupe = $groupe->getProjet();
			foreach ($projets_du_groupe as &$projet){
				$projets[] = $projet;
			}
		}

        return $this->render('connectedAccueilTemplate.html.twig',[ "projets" => $projets]);
    }
	
	/**
     * @Route("/monProfil/{onglet}", name="monProfil")
     */
    public function monProfil($onglet)
    {
		$session = new Session();
		$login = $session->get('login');
		
		$entityManager = $this->getDoctrine()->getManager();
		$user = $entityManager->getRepository(Utilisateur::class)->findOneBy(['login' => $login]);
		
        $infos = array();
		
		$infos['login']=$login;
		$infos['nom']=$user->getNom();
		$infos['prenom']=$user->getPrenom();
		$infos['mail']=$user->getMail();
		
		$entityManager->flush();
        return $this->render('connectedProfilTemplate.html.twig',['nom_onglet' => $onglet,'infos' => $infos]);
    }
	
	/**
     * @Route("/creerProjet", name="creerProjet")
     */
    public function creerProjet()
    {
		
        return $this->render('creerProjetTemplate.html.twig');
    }
	/**
     * @Route("/validerCreation", name="validerCreation")
     */
    public function validerCreation()
    {
		//récupère le login de l'utilisateur courant pour l'ajouter au groupe
		$session = new Session();
		$login = $session->get('login');
		$repository = $this->getDoctrine()->getRepository(Utilisateur::class);
		$user = $repository->findOneBy(['login' => $login]);
		
		
		//crée un nouveau groupe constitué d'une personne (le créateur du projet)
		$entityManager = $this->getDoctrine()->getManager();
        $groupe = new Groupe();
		$groupe->addUtilisateur($user);
        $entityManager->persist($groupe);
        $entityManager->flush();
		
		
		//crée le nouveau projet dans la base
		$entityManager = $this->getDoctrine()->getManager();
        $projet = new Projet();
        $projet->setNom($_POST['titreProjet']);
        $projet->setDescription($_POST['descriptionProjet']);
		$projet->setGroupe($groupe);
        $entityManager->persist($projet);
        $entityManager->flush();
		
		//récupère les groupes associés à l'utilisateur courant
		$user_groupes = $user->getGroupes();
		$projets=array();
		foreach ( $user_groupes as &$groupe){
			$projets_du_groupe = $groupe->getProjet();
			foreach ($projets_du_groupe as &$projet){
				$projets[] = $projet;
			}
		}

        return $this->render('connectedAccueilTemplate.html.twig',['projets' => $projets, ]);
    }
	
	/**
     * @Route("/rejoindreProjet", name="rejoindreProjet")
     */
    public function rejoindreProjet()
    {
        return $this->render('rejoindreProjetTemplate.html.twig');
    }
	
	
	/**
     * @Route("/validerReunion/{id}", name="validerReunion")
     */
    public function validerReunion($id)
    {
		$entityManager = $this->getDoctrine()->getManager();
		$projet =  $entityManager->getRepository(Projet::class)->find($id);
		
		//récupère le login de l'utilisateur courant pour l'ajouter au groupe
		$session = new Session();
		$login = $session->get('login');
		$repoUser = $this->getDoctrine()->getRepository(Utilisateur::class);
		$user = $repoUser->findOneBy(['login' => $login]);
		
		//récupère le groupe associé au projet
		$groupe = $projet->getGroupe();
		//ajoute l'utilisateur courant à ce groupe
		$groupe->addUtilisateur($user);
		
		$entityManager->flush();
		
        return $this->connectedAccueil();
    }
	
	/**
     * @Route("/recherche", name="recherche")
     */
    public function rechercheProjet()
    {
		$titre =null;
		$idProjet=null;
		$repository = $this->getDoctrine()->getRepository(Projet::class);
	
		if(isset($_POST['titreProjet']))
			$titre = $_POST['titreProjet'];
			$projets = $repository->findByTitre($titre);
		
		if(isset($_POST['idProjet'])){
			$id = $_POST['idProjet'];
			$projets[] = $repository->find($id);
		}
        return $this->render('rejoindreProjetTemplate.html.twig',['projets'=>$projets]);
    }
	
	
	/**
     * @Route("modifierInfos", name="modifierInfos")
     */
    public function modifierInfosGeneral()
    {
		$session = new Session();
		$login = $session->get('login');
		
		$entityManager = $this->getDoctrine()->getManager();
		$user = $entityManager->getRepository(Utilisateur::class)->findOneBy(['login' => $login]);
		
        $infos = array();
		
		if(isset($_POST['nom'])){
			$infos['nom']=$_POST['nom'];
			$user->setNom($_POST['nom']);
		}
		if(isset($_POST['prenom'])){
			$infos['prenom']=$_POST['prenom'];
			$user->setPrenom($_POST['prenom']);
		}
		if(isset($_POST['mail'])){
			$infos['mail']=$_POST['mail'];
			$user->setMail($_POST['mail']);
		}
		
		$entityManager->flush();
		return $this->monProfil('General');
    }
	
	/**
     * @Route("/projet/{id}", name="projet")
     */
    public function projet($id)
    {
		$projet = $this->getDoctrine()
			->getRepository(Projet::class)
			->find($id);
		$membres = $projet->getGroupe()->getUtilisateurs();
		$fonctionnalites = $projet->getFonctionnalites();
		
        return $this->render('projetTemplate.html.twig',['projet'=>$projet, 'membres'=>$membres,'fonctionnalites'=>$fonctionnalites]);
    }
	
	/**
     * @Route("/fonctionnalite", name="fonctionnalite")
     */
    public function fonctionnalite()
    {
        return $this->render('fonctionnaliteTemplate.html.twig');
    }
	
	/**
     * @Route("/projet/{id}/ajoutFonctionnalite", name="ajoutFonctionnalite")
     */
    public function ajoutFonctionnalite($id)
    {
		$entityManager = $this->getDoctrine()->getManager();
		//ajoute la fonctionnalité à la base
		$fonctionnalite = new Fonctionnalite();
		$fonctionnalite->setNom($_POST['nom']);
		$entityManager->persist($fonctionnalite);
		$entityManager->flush();
		
		 //récupère le projet courant et lui associe la nouvelle fonctionnalité
		$entityManager = $this->getDoctrine()->getManager();
		$projet =  $entityManager->getRepository(Projet::class)->find($id);
		$projet->addFonctionnalite($fonctionnalite);
		$entityManager->flush();
		
        return $this->projet($id);
    }
	
}
