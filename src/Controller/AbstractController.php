<?php
namespace App\Controller;
use App\Library\UserSession;
use App\Library\Flashbag;

class AbstractController
{
    protected Flashbag $flashbag;
    protected UserSession $userSession;
    public function __construct() 
    {
        $this->flashbag = new Flashbag;
        $this->userSession = new UserSession;
    }
    
    protected function render(string $template, array $params, string $baseTemplate = 'base.phtml' ):string
    {
        extract($params);
        unset($params);
        //on déclenche la temporisation de sortie
        ob_start();
         include TEMPLATE_DIR . DIRECTORY_SEPARATOR . $baseTemplate;
         return ob_get_clean();
    }
}