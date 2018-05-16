<?php

namespace App\Controller;

use App\Entity\Utilisateur;
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
		/*
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController', "infos" => $infos,
        ]);
		*/
		$nbProjects = 4;
		return $this->render('connectedAccueilTemplate.html.twig',['controller_name' => 'UserController', "infos" => $infos,  "n" => $nbProjects]);
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
		$nbProjects = 4;
        return $this->render('connectedAccueilTemplate.html.twig',['n' => $nbProjects]);
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
     * @Route("/rejoindreProjet", name="rejoindreProjet")
     */
    public function rejoindreProjet()
    {
        return $this->render('rejoindreProjetTemplate.html.twig');
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
     * @Route("/projet", name="projet")
     */
    public function projet()
    {
        return $this->render('projetTemplate.html.twig');
    }
	
	/**
     * @Route("/fonctionnalite", name="fonctionnalite")
     */
    public function fonctionnalite()
    {
        return $this->render('fonctionnaliteTemplate.html.twig');
    }
	
}
