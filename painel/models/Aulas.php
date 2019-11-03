<?php

class Aulas extends Model {

    public function getAulasModulo($idModulo) {
        $array = [];
        $sql = $this->db->prepare("SELECT * FROM aulas WHERE id_modulo = ? ORDER BY ordem");
        $sql->execute([$idModulo]);
        if ($sql->rowCount() > 0) {
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);
            foreach ($array as $k => $v) {
                if ($v['tipo'] == '0') {
                    $sql = $this->db->prepare("SELECT * FROM videos WHERE id_aula = ?");
                    $sql->execute([$v['id']]);
                    if ($sql->rowCount() > 0) {
                        $sql = $sql->fetch(PDO::FETCH_ASSOC);
                        $array[$k]['nome'] = $sql['nome'];
                    }
                } elseif ($v['tipo'] == '1') {
                    $array[$k]['nome'] = "Questionário";
                }
            }
        }
        return $array;
    }

    public function addAula($curso, $nome, $modulo, $tipo) {
        $sql = $this->db->prepare("SELECT MAX(ordem)+1 as m FROM aulas WHERE id_modulo = :modulo AND id_curso = :curso");
        $sql->bindValue(":curso", $curso);
        $sql->bindValue(":modulo", $modulo);
        $sql->execute();
        $sql = $sql->fetch(PDO::FETCH_ASSOC);
        $ordem = $sql['m'];
        $sql = $this->db->prepare("INSERT INTO aulas(id_curso, id_modulo, tipo, ordem) VALUES(:curso, :modulo, :tipo, :ordem)");
        $sql->bindValue(":curso", $curso);
        $sql->bindValue(":modulo", $modulo);
        $sql->bindValue(":tipo", $tipo);
        $sql->bindValue(":ordem", $ordem);
        $sql->execute();
        $id = $this->db->lastInsertId();
        if ($tipo == '0') {
            $sql = $this->db->prepare("INSERT INTO videos(id_aula, nome) VALUES(:aula, :nome)");
            $sql->bindValue(":aula", $id);
            $sql->bindValue(":nome", $nome);
            $sql->execute();
        } elseif ($tipo == '1') {
            $sql = $this->db->prepare("INSERT INTO questionarios(id_aula, pergunta) VALUES(:aula, :nome)");
            $sql->bindValue(":aula", $id);
            $sql->bindValue(":nome", $nome);
            $sql->execute();
        }
    }

    public function getCursoAula($idAula) {
        $curso = "";
        $sql = $this->db->prepare("SELECT id_curso FROM aulas WHERE id = ?");
        $sql->execute([$idAula]);
        if ($sql->rowCount() > 0) {
            $sql = $sql->fetch(PDO::FETCH_ASSOC);
            $curso = $sql['id_curso'];
        }
        return $curso;
    }

    public function getAula($idAula) {
        $array = [];
        $sql = $this->db->prepare("SELECT tipo FROM aulas WHERE id = ?");
        $sql->execute([$idAula]);

        if ($sql->rowCount() > 0) {
            $array = $sql->fetch(PDO::FETCH_ASSOC);
            if ($array['tipo'] == '0') {
                $sql = $this->db->prepare("SELECT * FROM videos WHERE id_aula = ?");
                $sql->execute([$idAula]);
                if ($sql->rowCount() > 0) {
                    $array = $sql->fetch(PDO::FETCH_ASSOC);
                    $array['tipo'] = "video";
                }
            } elseif ($array['tipo'] == '1') {
                $sql = $this->db->prepare("SELECT * FROM questionarios WHERE id_aula = ?");
                $sql->execute([$idAula]);
                if ($sql->rowCount() > 0) {
                    $array = $sql->fetch(PDO::FETCH_ASSOC);
                    $array['tipo'] = 'poll';
                }
            }
        }
        return $array;
    }
    public function updateAulaVideo($id, $nome, $descricao, $url){
        $sql = $this->db->prepare("UPDATE videos SET nome = :nome, descricao = :desc, url = :url WHERE id_aula = :id");
        $sql->bindValue(":nome",$nome);
        $sql->bindValue(":desc",$descricao);
        $sql->bindValue(":url",$url);
        $sql->bindValue(":id",$id);
        $sql->execute();
    }
    public function updateAulaPoll($id, $pergunta, $op1, $op2, $op3, $op4, $resposta){
        $sql = $this->db->prepare("UPDATE questionarios SET pergunta = :pergunta, opcao1 = :op1, opcao2 = :op2, opcao3 = :op3, "
                . "opcao4 = :op4, resposta = :resp WHERE id_aula = :id");
        $sql->bindValue(":pergunta",$pergunta);
        $sql->bindValue(":op1",$op1);
        $sql->bindValue(":op2",$op2);
        $sql->bindValue(":op3",$op3);
        $sql->bindValue(":op4",$op4);
        $sql->bindValue(":resp",$resposta);
        $sql->bindValue(":id",$id);
        $sql->execute();
    }

    public function delAula($id) {
        $sql = $this->db->prepare("SELECT * FROM aulas WHERE id = ?");
        $sql->execute([$id]);
        $sql = $sql->fetch(PDO::FETCH_ASSOC);
        $tipo = $sql['tipo'];
        if ($tipo == '0') {
            $sql = $this->db->prepare("DELETE FROM videos WHERE id_aula = ?");
            $sql->execute([$id]);
        } elseif ($tipo == '1') {
            $sql = $this->db->prepare("DELETE FROM questionarios WHERE id_aula = ?");
            $sql->execute([$id]);
        }
        $sql = $this->db->prepare("DELETE FROM historico WHERE id_aula = ?");
        $sql->execute([$id]);
        $sql = $this->db->prepare("DELETE FROM aulas WHERE id = ?");
        $sql->execute([$id]);
    }

}
