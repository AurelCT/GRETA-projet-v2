'use strict'

//recherche ajax pour la recherche de réunion
//je cible mon formulaire avec l'ID ajouté 
let ReunionFilter = document.getElementById('AjaxReunion');

//J'installe un gestionaire d'évènement
ReunionFilter.addEventListener('submit', (e)=> {
    //J'annule le comportement du formulaire
    e.preventDefault();
    const formationReunion = document.getElementById('ReunionValue');
    const urlReunion = e.currentTarget.action + '&reunion=' + formationReunion;
    
    ajaxGet(urlReunion, function(response){
        let allResult = JSON.parse(response);
        console.log(allResult)
    })
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