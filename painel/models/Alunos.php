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

    public function getAlunos() {
        $array = [];
        $sql = $this->db->prepare("SELECT *,(SELECT count(1) FROM aluno_curso WHERE aluno_curso.id_aluno = alunos.id) as qtCursos FROM alunos");
        $sql->execute();
        if ($sql->rowCount()) {
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        return $array;
    }

    public function delAluno($id) {
        $sql = $this->db->prepare("DELETE FROM aluno_curso WHERE id_aluno = ?");
        $sql->execute([$id]);
        $sql = $this->db->prepare("DELETE FROM historico WHERE id_aluno = ?");
        $sql->execute([$id]);
        $sql = $this->db->prepare("DELETE FROM duvidas WHERE id_aluno = ?");
        $sql->execute([$id]);
        $sql = $this->db->prepare("DELETE FROM alunos WHERE id = ?");
        $sql->execute([$id]);
    }

    public function addAluno($nome, $email, $senha) {
        if (!$this->isCadastrado($email)) {
            $sql = $this->db->prepare("INSERT INTO alunos(nome, email, senha) VALUES(:nome, :email, :senha)");
            $sql->bindValue(":nome", $nome);
            $sql->bindValue(":email", $email);
            $sql->bindValue(":senha", $senha);
            $sql->execute();
        }
    }
    public function getAluno($id){
        $array = [];
        $sql = $this->db->prepare("SELECT * FROM alunos WHERE id = ?");
        $sql->execute([$id]);
        if($sql->rowCount()>0){
            $array = $sql->fetch(PDO::FETCH_ASSOC);
        }
        return $array;
    }
    
    public function updateAluno($nome, $id) {
            $sql = $this->db->prepare("UPDATE alunos SET nome = :nome WHERE id = :id");
            $sql->bindValue(":nome", $nome);
            $sql->bindValue(":id", $id);
            $sql->execute();
    }
    public function updateSenhaAluno($senha, $id){
            $sql = $this->db->prepare("UPDATE alunos SET senha = :senha WHERE id = :id");
            $sql->bindValue(":senha", $senha);
            $sql->bindValue(":id", $id);
            $sql->execute();
    }

    public function isCadastrado($email) {
        $retorno = "";
        $sql = $this->db->prepare("SELECT COUNT(1) as c FROM alunos WHERE email = ?");
        $sql->execute([$email]);
        if ($sql->rowCount() > 0) {
            $sql = $sql->fetch(PDO::FETCH_ASSOC);
            $retorno = $sql['c'];
        }
        return $retorno;
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
