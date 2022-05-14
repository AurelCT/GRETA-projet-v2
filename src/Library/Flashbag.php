<?php
namespace App\Library;

class Flashbag 
{
    //On initialise une session si elle n'exsite pas
    public function __construct()
    {
        if(session_status() == PHP_SESSION_NONE){
            session_start();
        }
    }
    
}