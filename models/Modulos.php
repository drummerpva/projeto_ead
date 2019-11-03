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
    
    
}
