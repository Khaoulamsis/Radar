<?php

include_once 'classes/filiere.php';
include_once 'connexion/Connexion.php';
include_once 'dao/IDao.php';

class filiereService implements IDao {

    private $connexion;

    function __construct() {
        $this->connexion = new Connexion();
    }

    public function create($o) {
        $query = "INSERT INTO filiere Values (NULL,?,?)";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute(array($o->getCode(),$o->getLibelle())) or die('Erreur SQL');
    }

    public function delete($id) {
        $query = "DELETE FROM filiere where id = ?";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute(array($id)) or die('Erreur SQL');
    }

    public function findAll() {
        $fil = array();
        $query = "select * from filiere";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute();
        $m= $req->fetchAll(PDO::FETCH_OBJ);
        return $m;
    }

    public function findById($id) {
        $query = "select * from filiere where id = " . $id;
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute();
        $res=$req->fetch(PDO::FETCH_OBJ);
        $fill = new filiere($res->id, $res->code, $res->libelle);
        return $fill;
    }

    public function update($o) {
        $query = "UPDATE `filiere` SET `code` = '" . $o->getCode() . "', `libelle` = '" . $o->getLibelle() . "' WHERE `filiere`.`id` = " . $o->getId();
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute() or die('Erreur SQL');
    }
}


