<?php

class cursosController extends controller {

    public function __construct() {
        $a = new Alunos();
        if (!$a->isLogged()) {
            header("Location: " . BASE_URL . "login");
        }
    }

    public function index() {
        header("Location: " . BASE_URL);
    }

    public function entrar($idCurso) {
        $dados = [
            'info' => [],
            "curso" => [],
            "modulos" => []
        ];
        $m = new Modulos();
        $dados['modulos'] = $m->getModulos($idCurso);
        $a = new Alunos($_SESSION['lgEAD']);
        $a->setAluno($_SESSION['lgEAD']);
        $dados['info'] = $a;
        $c = new Cursos($_SESSION['lgEAD']);
        $dados['totalAulas'] = $c->getTotalAulas($idCurso);
        $dados['aulasAssistidas'] = $a->getQtAssistidas($idCurso);
        if ($c->isInscrito($idCurso)) {
            $c->setCurso($idCurso);
            $dados['curso'] = $c;
        } else {
            header("Location: " . BASE_URL);
        }

        $this->loadTemplate('cursoEntrar', $dados);
    }

    public function aula($idAula) {
        $dados = [
            'info' => [],
            "curso" => [],
            "modulos" => [],
            "aula" => [],
            "aulasAssistidas" => [],
            "isAssistida" => []
        ];
        $m = new Modulos();
        $a = new Alunos($_SESSION['lgEAD']);
        $c = new Cursos($_SESSION['lgEAD']);
        $au = new Aulas();
        $idCurso = $au->getCursoAula($idAula);

        $a->setAluno($_SESSION['lgEAD']);
        if ($c->isInscrito($idCurso)) {
            $c->setCurso($idCurso);
            if (!empty($_POST['duvida'])) {
                $duvida = addslashes($_POST['duvida']);
                $au->addDuvida($idAula, $duvida, $_SESSION['lgEAD']);
                header("Location: " . BASE_URL . "cursos/aula/" . $idAula);
            }
            $dados['info'] = $a;
            $dados['modulos'] = $m->getModulos($idCurso);
            $dados['curso'] = $c;
            $dados['aula'] = $au->getAula($idAula);
            $dados['totalAulas'] = $c->getTotalAulas($idCurso);
            $dados['aulasAssistidas'] = $a->getQtAssistidas($idCurso);
            $dados['isAssistida'] = $au->isAssistida($idAula, $_SESSION['lgEAD']);
            if (!empty($_POST['opcao'])) {
                $opcao = addslashes($_POST['opcao']);
                if ($opcao == $dados['aula']['resposta']) {
                    $dados['resposta'] = true;
                    $au->setAssistida($idAula, $_SESSION['lgEAD']);
                } else {
                    $dados['resposta'] = false;
                }
                $_SESSION['poll' . $idAula] ++;
            }
            $view = ($dados['aula']['tipo'] == 'video') ? "cursoAulaVideo" : "cursoAulaPoll";
            if ($view == "cursoAulaPoll") {
                if (!isset($_SESSION['poll' . $idAula])) {
                    $_SESSION['poll' . $idAula] = 1;
                }
            }
            $this->loadTemplate($view, $dados);
        } else {
            header("Location: " . BASE_URL);
        }
    }

}
