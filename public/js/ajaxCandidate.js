'use strict';

//Requête ajax pour la recherche de candidat
let filterResult = document.getElementById('TestAjax');

filterResult.addEventListener('submit', (e)=> {
    e.preventDefault();
    const formation = document.getElementById('formationValue').value;
    const url = e.currentTarget.action + '&orderby=' + formation;
    
    ajaxGet(url,function(response){
        let container = document.getElementById('CandidatesContainer');
        let allResult = JSON.parse(response);
        
        for (const i of allResult) {
            let filtername = document.getElementById('CandidateFilterName');
            let filterId = document.getElementById('CandidateFilterId');
            let div = document.createElement('div');
            div.classList.add('AllCandidate-info');
            filtername.textContent = `${i.nom} ${i.prenom} `;
            filterId.href = `index.php?action=candidate&id_candidat=${i.id_candidat}`;
           
            container.append(div);
        }
   });
});


//PARTIE DES FONCTIONS AJAX

/**
 * ajaxGet
 * 
 * Envoi d'une requête AJAX GET et récupération de la réponse
 * La réponse est passée à une fonction de callback (permet traitement en fonction du contexte d'appel)
 * 
 * @param  {string} url - url du script
 * @param  {requestCallback} callback - fonction de callback qui varie lors de l'appel
 */
 function ajaxGet(url, callback) {

    // Initialisation d'un objet XMLHttpRequest
    const XHRObject = new XMLHttpRequest();

    // Initialiser la requête en mode asynchrone (mode par défaut)
    XHRObject.open("GET", url, true); 

    // Quand la transaction est correctement terminée
    XHRObject.addEventListener('load', function() {
        if( 
            this.status >= 200
            && this.status < 400
        ) {
            // Traitement de la réponse par appel d'une fonction callback ()
            callback(this.response);   
        } 
        else {
            // Statut de la réponse renvoyée par le serveur 
            console.log(this.status); // Version numérique
            console.log(this.statusText); // Version texte
        }

    });

    XHRObject.addEventListener('error', function () {
        console.log('Problème réseau : la requête a échouée');
    });    

    // Fin de la transaction GET
    XHRObject.send(null);
}