<?php

namespace App\Controller;

use App\Entity\User;
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
		
		return $this->render('connectedAccueilTemplate.html.twig',['controller_name' => 'UserController', "infos" => $infos]);
		
		
    }
	
	/**
     * @Route("/CreateUser", name="create_user")
     */
	public function create($infos){
		$entityManager = $this->getDoctrine()->getManager();

        $user = new User();
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
    public function connectedAccueil()	//Meme chose qu'
    {
        return $this->render('connectedAccueilTemplate.html.twig');
    }
	
	/**
     * @Route("/monProfil/{onglet}", name="monProfil")
     */
    public function monProfil($onglet)
    {
        return $this->render('connectedProfilTemplate.html.twig',['nom_onglet' => $onglet]);
    }
	
	/**
     * @Route("/profilGeneral", name="profilGeneral")
     */
    public function profilGeneral()
    {
        return $this->render('profilGeneralTemplate.html.twig');
    }
	
	/**
     * @Route("/profilClasse", name="profilClasse")
     */
    public function profilClasse()
    {
        return $this->render('profilClasseTemplate.html.twig');
    }
	
	/**
     * @Route("/profilParametres", name="profilParametres")
     */
    public function profilParametres()
    {
        return $this->render('profilParametresTemplate.html.twig');
    }
	
}
