<?php
    class Cursos extends Model{
        private $idAluno;
        private $info;
        public function __construct($id = NULL){
            parent::__construct();
            if(!empty($id)){
                $this->idAluno = $id;
            }
        }
        public function getCursosAluno(){
            $array = [];
            $sql = $this->db->prepare("SELECT * FROM cursos WHERE id IN(SELECT id_curso FROM aluno_curso WHERE id_aluno = ?)");
            $sql->execute([$this->idAluno]);
            if($sql->rowCount()>0){
                $sql = $sql->fetchAll(PDO::FETCH_ASSOC);
                $array = $sql;
            }
            return $array;
        }
        public function getTotalAulas($curso){
            $qt = NULL;
            $sql = $this->db->prepare("SELECT COUNT(1) as c FROM aulas WHERE id_curso = ?");
            $sql->execute([$curso]);
            if($sql->rowCount()>0){
                $sql = $sql->fetch(PDO::FETCH_ASSOC);
                $qt = $sql['c'];
            }
            return $qt;
            
        }
        public function isInscrito($idCurso){
            $sql = $this->db->prepare("SELECT * FROM aluno_curso WHERE id_curso = :curso AND id_aluno = :aluno");
            $sql->bindValue(":curso", $idCurso);
            $sql->bindValue(":aluno", $this->idAluno);
            $sql->execute();
            if($sql->rowCount()>0){
                return true;
            }else{
                return false;
            }
        }
        public function setCurso($idCurso){
            $sql = $this->db->prepare("SELECT * from cursos WHERE id = ?");
            $sql->execute([$idCurso]);
            if($sql->rowCount()>0){
                $this->info = $sql->fetch(PDO::FETCH_ASSOC);
            }
        }
        public function getNome(){
            return $this->info['nome'];
        }
        public function getImagem(){
            return $this->info['imagem'];
        }
        public function getDescricao(){
            return $this->info['descricao'];
        }
    }