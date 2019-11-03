<?php

class Alunos extends Model {

    private $id;
    private $info;

    public function __construct($id = NULL) {
        parent::__construct();
        if (!empty($id)) {
            $this->id = $id;
        }
    }

    public function isLogged() {
        if (!empty($_SESSION['lgEAD'])) {
            return true;
        } else {
            return false;
        }
    }

    public function getQtAssistidas($curso) {
        $qt = NULL;
        $sql = $this->db->prepare("SELECT COUNT(1) as c FROM historico WHERE id_aluno = :aluno AND id_aula IN(SELECT aulas.id FROM aulas WHERE aulas.id_curso = :curso)");
        $sql->bindValue(":curso", $curso);
        $sql->bindValue(":aluno", $this->getId());
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $sql = $sql->fetch(PDO::FETCH_ASSOC);
            $qt = $sql['c'];
        }
        return $qt;
    }

    public function fazerLogin($email, $senha) {
        $sql = $this->db->prepare("SELECT * FROM alunos WHERE email = :email AND senha = :senha");
        $sql->bindValue(":email", $email);
        $sql->bindValue(":senha", $senha);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $sql = $sql->fetch();
            $_SESSION['lgEAD'] = $sql['id'];
            return true;
        }
        return false;
    }

    public function getNome() {
        return $this->info['nome'];
    }

    public function setAluno($id) {
        $sql = $this->db->prepare("SELECT * FROM alunos WHERE id = ?");
        $sql->execute([$id]);
        if ($sql->rowCount() > 0) {
            $this->info = $sql->fetch(PDO::FETCH_ASSOC);
            $this->id = $id;
        }
    }

    public function getId() {
        return $this->id;
    }

}
