<?php
namespace App\Controller;
use App\Repository\UserModel;
use App\Middleware\VerifyUser;

class DefaultController extends AbstractController
{
    public function getHome()
    {
        $userSession = new Usermodel();
        $errors = [];
        // dump($userSession);
        if(!empty($_POST)){
            //On récupère les données du formulaire
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            //Vérifications des identifiants
            $user = (new UserModel())->checkUserInformations($email,$password);
            //Si les identifiants sont corrects
            if($user){
                $this->userSession->userRegister($user['id_user'],$user['prenom'],$user['nom'], $user['email'], $user['role'] );
                header('location: index.php?action=allMeeting');
            }
            $errors['message'] = 'Identifiants incorrects';
        }

        return $this->render('home', [
            'errors'=>$errors
        ]);
    }

    public function getSignUp()
    {
        $errors = [];
        if(!empty($_POST)){
            //Récupération des données du formulaire
            $lastName = trim($_POST['lastName']);
            $firstName = trim($_POST['firstName']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $passwordConfirm = $_POST['passwordConfirm'];

            // $errors = $this->validateUserForm($lastName,$firstName,$email,$password, $passwordConfirm);

            $errors = (new VerifyUser())->validateUserForm($lastName,$firstName,$email,$password, $passwordConfirm);
            if(empty($errors)){
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $newUser = (new UserModel())->createNewUser($lastName,$firstName,$email,$hash);
            }

        }
        return $this->render('signup', [
            'errors'=>$errors
        ]);
    }

    public function getLogout()
    {
        $this->userSession->logout();
        header('Location: index.php?action=home');
        exit;

        return $this->render('logout',[
        ]);
    }


    /**
     * Création d'une fonction pour sécuriser le formulaire d'ajout de candidat, gestion des erreurs si une partie du formulaire est vide/ne correspond pas
     * @return array
     */
    private function validateUserForm(string $lastName,string $firstName, string $email, string $password, string $passwordConfirm):array
    {
        $errors = [];

        if(empty($lastName)){
            $errors['lastName'] = 'Le nom est obligatoire';
        }
        if(empty($firstName)){
            $errors['firstName'] = 'Le prénom est obligatoire';
        }
        if(empty($email)){
            $errors['email'] = 'Un email est obligatoire';
        }
        elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) { // Vérifier que le format est valide
            $errors['email'] = "Veuillez rentrer un format d'email valide";
        }

        if (!$password) { 
        $errors['password'] = 'Le champ "Mot de passe" est obligatoire';
        }

        elseif (strlen($password) < 8) {
        $errors['password'] = 'Le champ "Mot de passe" doit comporter au moins 8 caractères';
        }

        elseif($password != $passwordConfirm) {
        $errors['password-confirm'] = 'Les mots de passe ne sont pas identiques';
        }
        return $errors;    
    }
}