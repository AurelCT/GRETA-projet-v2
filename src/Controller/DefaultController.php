<?php
namespace App\Controller;
use App\Repository\UserModel;
use App\Services\VerifyUser;

class DefaultController extends AbstractController
{
    public function getHome()
    {
        $userSession = new Usermodel();
        $errors = [];
    
        if(!empty($_POST)){
            //On récupère les données du formulaire
            $email = trim($_POST['email']);
            $password = $_POST['password'];

            //Vérifications des identifiants
            $user = (new verifyUser())->checkUserInformations($email,$password);
            
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
            
            $lastName = trim($_POST['lastName']);
            $firstName = trim($_POST['firstName']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $passwordConfirm = $_POST['passwordConfirm'];

            $errors = (new VerifyUser())->validateUserForm($lastName,$firstName,$email,$password, $passwordConfirm);

            if(empty($errors)){
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $newUser = (new UserModel())->createNewUser($lastName,$firstName,$email,$hash);
                header('Location: index.php?action=home');
            }

        }
        return $this->render('auth/signup', [
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

}