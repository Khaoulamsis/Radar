<?php

include_once 'classes/classe.php';
include_once 'connexion/Connexion.php';
include_once 'dao/IDao.php';

class classeService implements IDao {

    private $connexion;

    function __construct() {
        $this->connexion = new Connexion();
    }

    public function create($o) {
        $query = "INSERT INTO classe VALUES (NULL,?,?)";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute(array($o->getCode(), $o->getId())) or die('Error');
    }

    public function delete($id) {
        $query = "DELETE FROM classe WHERE id_classe = ?";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute(array($id)) or die("erreur delete");
    }

    public function findAll() {
        $cls = array();
        $query = "SELECT id_classe,classe.code,classe.id,filiere.code as fil from classe inner join filiere on classe.id=filiere.id";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute();
        $m = $req->fetchAll(PDO::FETCH_OBJ);
        return $m;
    }

    public function findAllByFil($fil) {
        if($fil == 0){
            $cls = array();
            $query = "SELECT id_classe,classe.code,classe.id,filiere.code as fil from classe inner join filiere on classe.id=filiere.id";
            $req = $this->connexion->getConnexion()->prepare($query);
            $req->execute();
            $m = $req->fetchAll(PDO::FETCH_OBJ);
            return $m;
        }
        $query = "SELECT id_classe,classe.code,classe.id,filiere.code as fil from classe inner join filiere on classe.id=filiere.id where classe.id=?";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute(array($fil));
        $m = $req->fetchAll(PDO::FETCH_OBJ);
        return $m;
    }

    public function findById($id) {
        $query = "SELECT * FROM classe WHERE id_classe = ?";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute(array($id));
        $e = $req->fetch(PDO::FETCH_OBJ);
        $clss = new classe($e->id_classe, $e->code, $e->id);
        return $clss;
    }

    public function findByfil() {
        $query = "select count(*)as nbr,filiere.code as fil from classe inner join filiere on classe.id=filiere.id GROUP BY fil";
        $req = $this->connexion->getConnexion()->prepare($query);
        $e = $req->fetch(PDO::FETCH_OBJ);
        return $e;
    }

    public function update($o) {
        $query = "UPDATE classe SET code = ?,id = ? where id_classe = ?";
        $req = $this->connexion->getConnexion()->prepare($query);
        $req->execute(array($o->getCode(), $o->getId(), $o->getId_classe())) or die('Error');
    }

    public function findCountClasse(){
        $query= "select count(classe.id) as nbr,filiere.code as filiere FROM classe,filiere where classe.id=filiere.id group by classe.id";
        $req = $this->connexion->getConnexion()->query($query);
        $f= $req->fetchAll(PDO::FETCH_OBJ);
        return $f; 
    }

}
