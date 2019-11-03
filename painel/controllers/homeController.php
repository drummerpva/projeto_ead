<?php

class homeController extends controller {

    public function __construct() {
        $u = new Usuarios();
        if (!$u->isLogged()) {
            header("Location: " . BASE_URL . "login");
        }
    }

    public function index() {
        $dados = [
            "cursos" => []
        ];
        $u = new Cursos();


        $dados['cursos'] = $u->getCursos();

        $this->loadTemplate('home', $dados);
    }

    public function excluir($id) {
        $id = addslashes($id);
        $c = new Cursos();
        $c->removeCurso($id);

        header("Location: " . BASE_URL);
    }

    public function adicionar() {
        $dados = [];
        if (!empty($_POST['nome'])) {
            $nome = addslashes($_POST['nome']);
            $descricao = addslashes($_POST['descricao']);
            $c = new Cursos();
            if (!empty($_FILES['imagem']['tmp_name'])) {
                $imagem = $_FILES['imagem'];
                $c->addCurso($nome, $descricao, $imagem);
            } else {
                $c->addCurso($nome, $descricao);
            }
            header("Location: " . BASE_URL);
        }
        $this->loadTemplate('adicionarCurso', $dados);
    }

    public function editar($id) {
        $dados = [
            "curso" => [],
            "modulos" => []
        ];
        $c = new Cursos();
        $mod = new Modulos();
        $a = new Aulas();
        if (!empty($_POST['nome'])) {
            $nome = addslashes($_POST['nome']);
            $descricao = addslashes($_POST['descricao']);
            if (!empty($_FILES['imagem']['tmp_name'])) {
                $imagem = $_FILES['imagem'];
                $c->editarCurso($id, $nome, $descricao, $imagem);
            } else {
                $imagem = $_FILES['imagem'];
                $c->editarCurso($id, $nome, $descricao);
            }
            header("Location: " . BASE_URL . "home/editar/" . $id);
        }
        if (!empty($_POST['modulo'])) {
            $modulo = addslashes($_POST['modulo']);
            $mod->addModulo($id, $modulo);
            header("Location: " . BASE_URL . "home/editar/" . $id);
        }
        if (!empty($_POST['aula'])) {
            $nome = addslashes($_POST['aula']);
            $moduloA = addslashes($_POST['moduloAula']);
            $tipoA = addslashes($_POST['tipoAula']);
            $a->addAula($id, $nome, $moduloA, $tipoA);
            header("Location: ".BASE_URL."home/editar/".$id);
        }
        $dados['curso'] = $c->getCurso($id);
        $dados['modulos'] = $mod->getModulos($id);

        $this->loadTemplate('editarCurso', $dados);
    }

    public function delModulo($mod) {
        $m = new Modulos();
        $curso = $m->getCursoModulo($mod);
        if (!empty($mod)) {
            $m->delModulo($mod);
            header("Location: " . BASE_URL . "home/editar/" . $curso);
        } else {
            header("Location: " . BASE_URL);
        }
    }

    public function editarModulo($mod) {
        $dados = [
            "modulo" => []
        ];
        $m = new Modulos();
        $dados['modulo'] = $m->getModulo($mod);
        if (!empty($_POST['modulo'])) {
            $modulo = addslashes($_POST['modulo']);
            $m->updateModulo($mod, $modulo);
            header("Location: " . BASE_URL . "home/editar/" . $m->getCursoModulo($mod));
            exit;
        }
        $this->loadTemplate("editarModulo", $dados);
    }

    public function delAula($id) {
        if (!empty($id)) {
            $a = new Aulas();
            $curso = $a->getCursoAula($id);
            $a->delAula($id);
            header("Location: " . BASE_URL . "home/editar/" . $curso);
        } else {
            header("Location: " . BASE_URL);
        }
    }

    public function editarAula($id) {
        if (!empty($id)) {
            $dados = [
                'aula' => []
            ];
            $a = new Aulas();
            $dados['aula'] = $a->getAula($id);
            if (!empty($_POST['nome'])) {
                $curso = $a->getCursoAula($id);
                $nome = addslashes($_POST['nome']);
                $descricao = addslashes($_POST['descricao']);
                $url = addslashes($_POST['url']);
                $a->updateAulaVideo($id,$nome,$descricao, $url);
                header("Location: ".BASE_URL."home/editar/".$curso);
                exit;
            }
            if(!empty($_POST['pergunta'])){
                $curso = $a->getCursoAula($id);
                $pergunta = addslashes($_POST['pergunta']);
                $op1 = addslashes($_POST['opcao1']);
                $op2 = addslashes($_POST['opcao2']);
                $op3 = addslashes($_POST['opcao3']);
                $op4 = addslashes($_POST['opcao4']);
                $resposta = addslashes($_POST['resposta']);
                $a->updateAulaPoll($id, $pergunta, $op1, $op2, $op3, $op4, $resposta);
                header("Location: ".BASE_URL."home/editar/".$curso);
                exit;
            }
            $view = ($dados['aula']['tipo'] == 'video') ? "editarAulaVideo" : "editarAulaPoll";
            $this->loadTemplate($view, $dados);
        } else {
            header("Location: " . BASE_URL);
        }
    }

}
