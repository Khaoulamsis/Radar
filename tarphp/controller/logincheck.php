<?php


chdir('..');
include_once 'classes/user.php';
include_once 'service/userService.php';
extract($_POST);

$us = new userService();
$cin = $us->findByEmail($email);
if ($cin != -1) {
    $employe = $es->findById($cin);
    if ($employe->getPassword() == md5($password)) {
        header('Content-type: application/json');
        echo json_encode(array("cin"=>$employe->getCin(),"nom"=>$employe->getNom(),"prenom"=>$employe->getPrenom()
                ,"password"=>$employe->getPassword(),"email"=>$employe->getEmail(),"photo"=>$employe->getPhoto()
                ,"role"=>$employe->getRole()));
    } else
        echo 0;
}else {
    echo 0;
}

