<?php

class Aulas extends Model {

    public function getAulasModulo($idModulo) {
        $array = [];
        $sql = $this->db->prepare("SELECT *,(SELECT COUNT(1) FROM historico WHERE historico.id_aula = aulas.id AND historico.id_aluno = ?) as assistida FROM aulas WHERE id_modulo = ? ORDER BY ordem");
        $sql->execute([$_SESSION['lgEAD'],$idModulo]);
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

    public function isAssistida($aula, $aluno) {
        $sql = $this->db->prepare("SELECT * FROM historico WHERE id_aula = :aula AND id_aluno = :aluno");
        $sql->bindValue(":aula", $aula);
        $sql->bindValue(":aluno", $aluno);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            return true;
        } else {
            return false;
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
        $aluno = $_SESSION['lgEAD'];
        $sql = $this->db->prepare("SELECT tipo,(SELECT COUNT(1) FROM historico WHERE historico.id_aula = aulas.id AND historico.id_aluno = ?) as assistido FROM aulas WHERE id = ?");
        $sql->execute([$aluno, $idAula]);

        if ($sql->rowCount() > 0) {
            $array = $sql->fetch(PDO::FETCH_ASSOC);
            $assistida = $array['assistido'];
            if ($array['tipo'] == '0') {
                $sql = $this->db->prepare("SELECT * FROM videos WHERE id_aula = ?");
                $sql->execute([$idAula]);
                if ($sql->rowCount() > 0) {
                    $array = $sql->fetch(PDO::FETCH_ASSOC);
                    $array['tipo'] = "video";
                    $array['assistida'] = $assistida;
                }
            } elseif ($array['tipo'] == '1') {
                $sql = $this->db->prepare("SELECT * FROM questionarios WHERE id_aula = ?");
                $sql->execute([$idAula]);
                if ($sql->rowCount() > 0) {
                    $array = $sql->fetch(PDO::FETCH_ASSOC);
                    $array['tipo'] = 'poll';
                    $array['assistida'] = $assistida;
                }
            }
        }
        return $array;
    }

    public function addDuvida($aula, $duvida, $aluno) {
        $sql = $this->db->prepare("INSERT INTO duvidas SET duvida = :duvida, data = NOW(), id_aluno = :aluno, id_aula = :aula");
        $sql->bindValue(":duvida", $duvida);
        $sql->bindValue(":aluno", $aluno, PDO::PARAM_INT);
        $sql->bindValue(":aula", $aula, PDO::PARAM_INT);
        $sql->execute();
    }

    public function setAssistida($aula, $aluno) {
        $sql = $this->db->prepare("INSERT INTO historico (data_viewed, id_aluno, id_aula) VALUES(NOW(), :aluno, :aula)");
        $sql->bindValue(":aluno", $aluno);
        $sql->bindValue(":aula", $aula);
        $sql->execute();
    }

}
