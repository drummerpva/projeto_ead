<?php

class Modulos extends Model {

    public function getModulos($idCurso){
        $array = [];
        $sql = $this->db->prepare("SELECT * FROM modulos WHERE id_curso = ?");
        $sql->execute([$idCurso]);
        if($sql->rowCount()>0){
            $a = new Aulas();
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);
            foreach ($array as $k => $v){
                $array[$k]['aulas'] = $a->getAulasModulo($v['id']);
            }
        }
        return $array;
    }
    public function addModulo($curso, $mod){
        $sql = $this->db->prepare("INSERT INTO modulos SET nome = ?, id_curso = ?");
        $sql->execute([$mod, $curso]);
    }
    public function delModulo($mod){
        $sql = $this->db->prepare("DELETE FROM modulos WHERE id = ?");
        $sql->execute([$mod]);
    }
    public function getCursoModulo($mod){
        $modulo = "";
        $sql = $this->db->prepare("SELECT id_curso FROM modulos WHERE id = ?");
        $sql->execute([$mod]);
        if($sql->rowCount()>0){
            $sql = $sql->fetch(PDO::FETCH_ASSOC);
            $modulo = $sql['id_curso'];
        }
        return $modulo;
    }
    public function getModulo($id){
        $array = [];
        $sql = $this->db->prepare("SELECT * FROM modulos WHERE id = ?");
        $sql->execute([$id]);
        if($sql->rowCount()>0){
            $array = $sql->fetch(PDO::FETCH_ASSOC);
        }
        return $array;
    }
    public function updateModulo($id, $modulo){
        $sql = $this->db->prepare("UPDATE modulos SET nome = ? WHERE id = ?");
        $sql->execute([$modulo, $id]);
    }
    
    
}
