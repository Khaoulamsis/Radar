<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


chdir('..');
include_once 'service/filiereService.php';
extract($_POST);

$ms = new filiereService();

if (isset($op) && $op != '') {
    if ($op == 'add') {
        $ms->create(new filiere(0, $code,$libelle));
    } elseif ($op == 'update') {
        $ms->update(new filiere($id, $code,$libelle));
    } elseif ($op == 'delete') {
        $ms->delete($ms->delete($id));
    }
}

header('Content-type: application/json');
echo json_encode($ms->findAll());