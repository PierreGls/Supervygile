// script.js

console.log("script.js\n");

$(function () {
	
	/***************UserStory****************/
	
	var idUserStory=1;
	var nbrTache = nombreTache(1);
	
	
	//Petite indication sur les noms des UserStory 
	$('[data-toggle="popover"]').popover()	
	
	//nombre de tache de cette user story
	function nombreTache(idUserStory) {
		//TODO chercher le nombre de tache en fonction de l'id de la user story
		return 3;
	}
	
	//Ajout d'une ligne
	function nouvelleTache(unElement) {
		nbrTache++;
		var nouvelleLigne = "<tr><th scope='row'>" + nbrTache + "</th><td><input type='text' name='nomTache" + nbrTache + "' value='Nom tache " + nbrTache + "'></td><td><input type='checkbox' class='mx-auto' name='checkbox" + nbrTache + "'></td><td><div class='btn btn-outline-danger boutonSupprimerTache'> Supprimer </div></td></tr>"; 
		unElement.before(nouvelleLigne);
	}
	
	//Suppression d'une ligne d'une ligne
	function supprimerTache(unElement) {
		/*
		nbrTache--;
		unElement.remove();
		console.log(unElement);
		*/
		//TODO ne marche pas sur les taches venant d'être rajoutée
	}
	
	
	
	//Main
	$( window ).on( "load", function() {
		
		$(".boutonAjouterTache").on('click',function(){
			nouvelleTache($(this).parent().parent());
		});
		
		$(".boutonSupprimerTache").on('click',function(){
			supprimerTache($(this).parent().parent());
		});
	});
})

