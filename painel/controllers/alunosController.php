<?php

class alunosController extends controller {

    public function __construct() {
        $u = new Usuarios();
        if (!$u->isLogged()) {
            header("Location: " . BASE_URL . "login");
        }
    }

    public function index() {
        $dados = [
            "alunos" => []
        ];
        $a = new Alunos();
        $dados['alunos'] = $a->getAlunos();

        $this->loadTemplate('alunos', $dados);
    }

    public function excluir($id) {
        if (!empty($id)) {
            $a = new Alunos();
            $a->delAluno($id);
            header("Location: " . BASE_URL . "alunos" . $curso);
        } else {
            header("Location: " . BASE_URL . "alunos");
        }
    }

    public function adicionar() {
        $dados = [];
        if (!empty($_POST['nome'])) {
            $nome = addslashes($_POST['nome']);
            $email = addslashes($_POST['email']);
            $senha = md5($_POST['senha']);
            $a = new Alunos();
            $a->addAluno($nome, $email, $senha);
            header("Location: " . BASE_URL . "alunos");
        }
        $this->loadTemplate("adicionarAluno", $dados);
    }

    public function editar($id) {
        if (!empty($id)) {
            $dados = [
                "aluno" => [],
                "cursos" => [],
                "inscritos" => []
            ];
            $a = new Alunos();
            $c = new Cursos();
            $dados['inscritos'] = $c->getCursosInscritos($id);
            if (!empty($_POST['nome'])) {
                $nome = addslashes($_POST['nome']);
                $a->updateAluno($nome, $id);
                if (!empty($_POST['senha'])) {
                    $senha = md5($_POST['senha']);
                    $a->updateSenhaAluno($senha, $id);
                }
                if (!empty($_POST['cursos'])) {
                    $cursos = $_POST['cursos'];
                    $c->delCursosAluno($id);
                    foreach ($cursos as $cur) {
                        if ($cur > 0) {
                            $c->addCursoAluno($cur, $id);
                        }
                    }
                }
                header("Location: " . BASE_URL . "alunos");
                exit;
            }
            $dados['aluno'] = $a->getAluno($id);
            $dados['cursos'] = $c->getCursos();

            $this->loadTemplate("editarAluno", $dados);
        } else {
            header("Location: " . BASE_URL . "alunos");
        }
    }

}
