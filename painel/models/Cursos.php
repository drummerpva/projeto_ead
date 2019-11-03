<?php

class Cursos extends Model {

    public function getCursos() {
        $array = [];
        $sql = $this->db->prepare("SELECT *,(SELECT COUNT(1) FROM aluno_curso WHERE aluno_curso.id_curso = cursos.id) as qtAlunos FROM cursos");
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        return $array;
    }

    public function removeCurso($curso) {
        $sql = $this->db->prepare("DELETE FROM aluno_curso WHERE id_curso = ?");
        $sql->execute([$curso]);
        $sql = $this->db->prepare("SELECT id,tipo from aulas WHERE id_curso = ?");
        $sql->execute([$curso]);
        if ($sql->rowCount() > 0) {
            $info = $sql->fetchAll(PDO::FETCH_ASSOC);
            foreach ($info as $v) {
                $sql = $this->db->prepare("DELETE FROM historico WHERE id_aula = ?");
                $sql->execute([$v['id']]);
                if ($v['tipo'] == '0') {
                    $sql = $this->db->prepare("DELETE FROM videos WHERE id_aula = ?");
                    $sql->execute([$v['id']]);
                } elseif ($v['tipo'] == '1') {
                    $sql = $this->db->prepare("DELETE FROM questionarios WHERE id_aula = ?");
                    $sql->execute([$v['id']]);
                }
            }
        }
        $sql = $this->db->prepare("DELETE FROM aulas WHERE id_curso = ?");
        $sql->execute([$curso]);
        $sql = $this->db->prepare("DELETE FROM cursos WHERE id = ?");
        $sql->execute([$curso]);
    }
    
    public function getCursosInscritos($aluno){
        $array = [];
        $sql = $this->db->prepare("SELECT id_curso FROM aluno_curso WHERE id_aluno = ?");
        $sql->execute([$aluno]);
        if($sql->rowCount()>0){
            $rows = $sql->fetchAll(PDO::FETCH_ASSOC);
            foreach ($rows as $row){
                $array[] = $row['id_curso'];
            }
        }
        return $array;
    }
    public function addCursoAluno($curso, $aluno){
        $sql = $this->db->prepare("INSERT INTO aluno_curso(id_curso, id_aluno) VALUES(:curso, :aluno)");
        $sql->bindValue(":curso", $curso);
        $sql->bindValue(":aluno", $aluno);
        $sql->execute();
    }
    public function delCursosAluno($aluno){
        $sql = $this->db->prepare("DELETE FROM aluno_curso WHERE id_aluno = ?");
        $sql->execute([$aluno]);
    }

    public function addCurso($nome, $descricao, $imagem = NULL) {
        if (!empty($imagem)) {
            $types = ["image/jpeg", "image/jpg", "image/png"];
            if (in_array($imagem['type'], $types)) {
                //$namemd5 = md5(time(), rand(0, 999)).".jpg";
                $namemd5 = $imagem['name'];
                move_uploaded_file($imagem['tmp_name'], "../assets/images/cursos/" . $namemd5);
                $sql = $this->db->prepare("INSERT INTO cursos(nome, descricao, imagem) VALUES(:nome, :descricao, :imagem)");
                $sql->bindValue(":nome", $nome);
                $sql->bindValue(":descricao", $descricao);
                $sql->bindValue(":imagem", $namemd5);
                $sql->execute();
            }
        } else {
            $sql = $this->db->prepare("INSERT INTO cursos(nome, descricao) VALUES(:nome, :descricao)");
            $sql->bindValue(":nome", $nome);
            $sql->bindValue(":descricao", $descricao);
            $sql->execute();
        }
    }

    public function getCurso($id) {
        $array = [];
        $sql = $this->db->prepare("SELECT * FROM cursos WHERE id = ?");
        $sql->execute([$id]);
        if ($sql->rowCount() > 0) {
            $array = $sql->fetch(PDO::FETCH_ASSOC);
        }
        return $array;
    }

    public function editarCurso($id, $nome, $descricao, $imagem = NULL) {
        if (!empty($imagem)) {
            $namemd5 = $imagem['name'];
            move_uploaded_file($imagem['tmp_name'], "../assets/images/cursos/" . $namemd5);
            $sql = $this->db->prepare("UPDATE cursos SET nome = :nome, descricao = :descricao, imagem = :imagem WHERE id = :id");
            $sql->bindValue(":id", $id);
            $sql->bindValue(":nome", $nome);
            $sql->bindValue(":descricao", $descricao);
            $sql->bindValue(":imagem", $namemd5);
            $sql->execute();
        } else {
            $sql = $this->db->prepare("UPDATE cursos SET nome = :nome, descricao = :descricao WHERE id = :id");
            $sql->bindValue(":id", $id);
            $sql->bindValue(":nome", $nome);
            $sql->bindValue(":descricao", $descricao);
            $sql->execute();
            
        }
    }

}
