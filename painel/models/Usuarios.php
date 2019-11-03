<?php

class Usuarios extends Model {

    private $id;
    private $info;

    public function __construct($id = NULL) {
        parent::__construct();
        if (!empty($id)) {
            $this->id = $id;
        }
    }

    public function isLogged() {
        if (!empty($_SESSION['lgAdmin'])) {
            return true;
        } else {
            return false;
        }
    }

    public function fazerLogin($email, $senha) {
        $sql = $this->db->prepare("SELECT * FROM usuarios WHERE email = :email AND senha = :senha");
        $sql->bindValue(":email", $email);
        $sql->bindValue(":senha", $senha);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $sql = $sql->fetch();
            $_SESSION['lgAdmin'] = $sql['id'];
            return true;
        }
        return false;
    }

}
