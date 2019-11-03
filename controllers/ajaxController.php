<?php

class ajaxController extends controller {

    public function __construct() {
        $a = new Alunos();
        if (!$a->isLogged()) {
            header("Location: " . BASE_URL . "login");
        }
    }
    public function marcarAssistida($id){
      $a = new Aulas();
      $a->setAssistida($id, $_SESSION['lgEAD']);
    }

}
