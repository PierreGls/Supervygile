<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AnonymousController extends Controller
{
	/**
      * @Route("/accueil")
    */
    public function accueil()
    {
        return $this->render('accueilTemplate.html.twig');
    }
	
	/**
      * @Route("/connexion")
    */
    public function connexion()
    {
        return $this->render('connexionTemplate.html.twig');
    }
	
	/**
      * @Route("/signin")
    */
    public function signin()
    {
		$repository = $this->getDoctrine()->getRepository(User::class);
		// look for a single User by login
		$user = $repository->findOneBy(['login' => $_POST['inscLogin'], 'password' => $_POST['inscPassword']]);
		
		if (!$user) {
			return $this->render('connexionTemplate.html.twig', array('errConn' => "Cet utilisateur n'existe pas"));;
		}
		
		//User Initialization 
		$response = $this->forward('App\Controller\UserController::index', array(
        "infos" => array('login' => $_POST['inscLogin'], "pwd" => $_POST['inscPassword']),
		));
		
		return $response;
    }
	
	/**
      * @Route("/register")
    */
    public function register()
    {
		$repository = $this->getDoctrine()->getRepository(User::class);
		// look for a single User by login
		$user = $repository->findOneBy(['login' => $_POST['inscLogin']]);

		if (!$user) {
			return $this->forward('App\Controller\UserController::create', array( 'infos' => array(
			'login' => $_POST['inscLogin'], 
			"pwd" => $_POST['inscPassword'], 
			"mail" => $_POST['mail'], 
			"nom" => $_POST['nom'], 
			"prenom" => $_POST['prenom']
			)));
		}
		
		return $this->render('connexionTemplate.html.twig', array('errLogin' => "Ce login existe déjà"));; 
    }
	
}