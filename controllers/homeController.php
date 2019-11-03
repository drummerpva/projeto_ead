<?php

class homeController extends controller {

    public function __construct() {
        $a = new Alunos();
        if(!$a->isLogged()){
            header("Location: ".BASE_URL."login");
        }
    }

    public function index() {
        $dados = [
            'info' => [],
            'cursos' => []
        ];
        $a = new Alunos($_SESSION['lgEAD']);
        $c = new Cursos($_SESSION['lgEAD']);
        $a->setAluno($_SESSION['lgEAD']);
        $dados['info'] = $a;
        $dados['cursos'] = $c->getCursosAluno();
        $this->loadTemplate('home', $dados);
    }

}