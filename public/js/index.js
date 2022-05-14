'use strict'

let btnMenu = document.getElementById('btn-menu');

btnMenu.addEventListener('click', ()=>{
    btnMenu.classList.toggle('has-focus');
    document.querySelector('.Header-nav').classList.toggle('active');
} )

window.addEventListener('resize', ()=>{
    if(window.matchMedia("(min-width:760px)").matches){
        document.querySelector('.Header-nav').classList.remove('active');
        btnMenu.classList.remove('has-focus');
    }
})