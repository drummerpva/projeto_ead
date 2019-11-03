<?php
class loginController extends controller{
    
    public function __construct(){
        $a = new Alunos();
        if($a->isLogged()){
            header("Location: ".BASE_URL);
        }
    }
    
    public function index(){
        $dados = [];
        if(!empty($_POST['email'])){
            $email = addslashes($_POST['email']);
            $senha = md5($_POST['senha']);
            $a = new Alunos();
            if($a->fazerLogin($email,$senha)){
                header("Location: ".BASE_URL);
            }
        }
        
        $this->loadView('login',$dados);
    }
    public function logOut(){
        unset($_SESSION['lgEAD']);
        header("Location: ".BASE_URL);
    }
}