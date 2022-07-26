'use strict'
//MENU HEADER
let btnMenu = document.getElementById('btn-menu');
let btnPlusMenu = document.getElementById('HeaderPlus');

btnMenu.addEventListener('click', ()=>{
    btnMenu.classList.toggle('has-focus');
    document.querySelector('.Header-nav').classList.toggle('active');
} )

btnPlusMenu.addEventListener('click', ()=>{
    document.querySelector('.Header-button-menu').classList.toggle('active');
} )

window.addEventListener('resize', ()=>{
    if(window.matchMedia("(min-width:760px)").matches){
        document.querySelector('.Header-nav').classList.remove('active');
        btnMenu.classList.remove('has-focus');
    }
})



//Requête ajax pour la recherche de candidat par son nom
let filterResult = document.getElementById('TestAjax');
if(filterResult){

    filterResult.addEventListener('submit', (e)=> {
        e.preventDefault();
        const formation = document.getElementById('formationValue').value;
        const url = e.currentTarget.action + '&orderby=' + formation;
        
        ajaxGet(url,function(response){
            let container = document.getElementById('CandidatesContainer');
            
            let allResult = JSON.parse(response);
            
            if(allResult.length == 0){
                return;
            }

            let filtername = document.getElementById('CandidateFilterName');
            let filterId = document.getElementById('CandidateFilterId');
            let div = document.createElement('div');
            div.classList.add('AllCandidate-info');
            filtername.textContent = `${allResult.nom} ${allResult.prenom} `;
            filterId.href = `index.php?action=candidate&id_candidat=${allResult.id_candidat}`;

        });
    });
}
    



//recherche ajax pour la recherche de réunion
//je cible mon formulaire avec l'ID ajouté 
let reunionFilter = document.getElementById('AjaxReunion');
 
if(reunionFilter){
    //J'installe un gestionaire d'évènement
    reunionFilter.addEventListener('submit', (e)=> {
        //J'annule le comportement par défaut
        e.preventDefault();
        const formationReunion = document.getElementById('ReunionValue').value;
        const urlReunion = e.currentTarget.action + '&reunion=' + formationReunion;
        
        ajaxGet(urlReunion, function(response){
            //JSON.parse permet de traiter les données Json pour retourner l'objet décrit par la chaine.
            let allResult = JSON.parse(response);

            //Je cible la section qui contient mes réunions
            let meetingsContainer = document.getElementById('meetingsContainer');
            //Je vide les réunions qui sont présentes par défaut
            meetingsContainer.innerHTML = "";
            if(allResult.length == 0){
                meetingsContainer.textContent = 'Aucune réunion pour le moment.'
            }
            for (const i of allResult) {
                //je crée un article en lui passant les mêmes classes que cellrd précédemment supprimées
                let articleMeeting = document.createElement('article');
                articleMeeting.classList.add('Meetings-content');

                //création du titre
                let meetingTitle = document.createElement('h2');
                meetingTitle.classList.add('Meetings-content-title');
                meetingTitle.textContent = i.name;
                

                //récupération de l'image
                let meetingPicture = document.createElement('img');
                meetingPicture.classList.add('Meetings-content-img');
                meetingPicture.src = `../public/img/${i.image}`;
                

                //Création du lien à cliquer de la réunion
                let meetingLink = document.createElement('a');
                meetingLink.href = `index.php?action=meeting&id_event=${i.id_event}`;
                meetingLink.append(meetingPicture);

                //Création de la date 
                let meetingDate = document.createElement('p');
                meetingDate.textContent = i.meetingDate;

                //On rajoute les éléments à l'article, et l'article à la section
                articleMeeting.append(meetingTitle, meetingLink, meetingDate,);
                meetingsContainer.append(articleMeeting);     
            }
            
        })
    });
}


//Ajouter un candidat dans la réunion
let formu = document.getElementById('addToMeetingForm');
if(formu){
    formu.addEventListener('submit', (e)=> {
        e.preventDefault();
        let urlForm = e.currentTarget.action;
        const formData = new FormData(e.target);
        
    
        ajaxPost(urlForm,formData, function(response){
            let tableContainer = document.getElementById('TableContainer');
            tableContainer.innerHTML = '';
            tableContainer.innerHTML = response;
        } )
    })
}


//PARTIE DES FONCTIONS AJAX

/**
 * ajaxGet
 * 
 * Envoi d'une requête AJAX GET et récupération de la réponse
 * La réponse est passée à une fonction de callback (permet le traitement en fonction du contexte d'appel)
 * 
 * @param  {string} url - url du script
 * @param  {requestCallback} callback - fonction de callback qui varie lors de l'appel
 */
function ajaxGet(url, callback) {

    // Initialisation de l'objet XMLHttpRequest
    const XHRObject = new XMLHttpRequest();

    // Initialiser la requête en mode asynchrone qui est le mode par défaut
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

    // Fin de la transaction
    XHRObject.send(null);
}



/**
 * ajaxPost
 * 
 * Envoi d'une requête AJAX GET et récupération de la réponse
 * La réponse est passée à une fonction de callback (permet le traitement en fonction du contexte d'appel)
 * 
 * @param  {string} url - url du script
 * @param  {requestCallback} callback - fonction de callback qui varie lors de l'appel
 */
 function ajaxPost(url, data,  callback) {

    // Initialisation d'un objet XMLHttpRequest
    const XHRObject = new XMLHttpRequest();

    // Initialiser la requête en mode asynchrone (mode par défaut)
    XHRObject.open("POST", url, true); 

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

    // Fin de la transaction
    XHRObject.send(data);
}



//EDITER UN CANDIDAT DANS UNE REUNION 
let formDiv = document.querySelector('.EditMeeting');
let eventOnTable = document.getElementById('TableContainer');

if(eventOnTable){

    eventOnTable.addEventListener('click', (e)=>{
        
        let candidateIdForm = document.getElementById('formCandidateIdValue');
        candidateIdForm.value = e.target.value;
        
        if(e.target.classList.contains('btnEditForm')){
            formDiv.classList.add('Active');
        }
    });
    
    let closeModal = document.getElementById('closeModalForm');
    closeModal.addEventListener('click', (e)=> {
        e.preventDefault();
        formDiv.classList.remove('Active');
    });
}
