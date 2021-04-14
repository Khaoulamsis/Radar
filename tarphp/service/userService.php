<?php

include_once 'classes/user.php';
include_once 'connexion/Connexion.php';
include_once 'dao/IDao.php';

class userService implements IDao {

    private $connexion;

    function __construct() {
        $this->connexion = new Connexion();
    }

    public function create($o) {
        $query = "INSERT INTO `user`(`cin`, `nom`, `prenom`, `email`, `password`, `role`, `photo`) "
                . "VALUES (?,?,?,?,?,?,?)";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute(array($o->getCin(), $o->getNom(), $o->getPrenom(), $o->getEmail(), $o->getPassword(), $o->getRole(), $o->getPhoto())) or die('Error');
    }

    public function delete($cin) {
        $query = "DELETE FROM user WHERE cin = ?";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute(array($cin)) or die("erreur delete");
    }

    public function findAll() {
        $query = "select * from user";
        $req = $this->connexion->getConnexion()->query($query);
        $f = $req->fetchAll(PDO::FETCH_OBJ);
        return $f;
    }

    public function findById($cin) {
        $query = "select * from user where cin =?";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute(array($cin));
        $res = $req->fetch(PDO::FETCH_OBJ);
        $user = new user($res->cin, $res->nom, $res->prenom, $res->email, $res->password, $res->role, $res->photo);
        return $user;
    }

    public function findByEmail($email) {
        $query = "select * from user where email =?";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute(array($email));
        $s = $req->fetchAll(PDO::FETCH_OBJ);
        if (count($s) != 0) {
            foreach ($s as $res) {
                $cin = $res->cin;
        }
            return $cin;
        } else
            return -1;
        
    }

    public function update($o) {
        $query = "UPDATE user SET  nom=?, prenom =?, email =?, password =?, role =?, photo =?  where cin = ?";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute(array($o->getNom(), $o->getPrenom(), $o->getEmail(), $o->getPassword(), $o->getRole(), $o->getPhoto(), $o->getCin())) or die('Error');
    }

}

