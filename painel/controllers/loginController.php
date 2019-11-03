<?php
class loginController extends controller{
    
    public function __construct(){
        $u = new Usuarios();
        if($u->isLogged()){
            header("Location: ".BASE_URL);
        }
    }
    
    public function index(){
        $dados = [];
        if(!empty($_POST['email'])){
            $email = addslashes($_POST['email']);
            $senha = md5($_POST['senha']);
            $u = new Usuarios();
            if($u->fazerLogin($email,$senha)){
                header("Location: ".BASE_URL);
            }
        }
        
        $this->loadView('login',$dados);
    }
    public function logOut(){
        unset($_SESSION['lgAdmin']);
        header("Location: ".BASE_URL);
    }
}