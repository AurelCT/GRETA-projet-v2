'use strict'

let btnMenu = document.getElementById('btn-menu');
let btnPlusMenu = document.getElementById('HeaderPlus');

btnMenu.addEventListener('click', ()=>{
    btnMenu.classList.toggle('has-focus');
    document.querySelector('.Header-nav').classList.toggle('active');
} )

btnPlusMenu.addEventListener('click', ()=>{
    document.querySelector('.Header-plus-menu').classList.toggle('active');
} )

window.addEventListener('resize', ()=>{
    if(window.matchMedia("(min-width:760px)").matches){
        document.querySelector('.Header-nav').classList.remove('active');
        btnMenu.classList.remove('has-focus');
    }
})

if(document.querySelector('.Header-nav').classList.contains('active')){
    window.addEventListener('click', () => {
        document.querySelector('.Header-nav').classList.remove('active');
    })
};