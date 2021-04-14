<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


chdir('..');
include_once 'service/classeService.php';
extract($_POST);

$ms = new classeService();

if (isset($op) && $op != '') {
    if ($op == 'add') {
        $ms->create(new classe(0, $code,$id));
    } elseif ($op == 'update') {
        $ms->update(new classe($id_classe, $code,$id));
    } elseif ($op == 'delete') {
        $ms->delete($ms->delete($id_classe));
    }elseif ($op == 'count') {
        header('Content-type: application/json');
        echo json_encode($ms->findByfil());
    }
}

header('Content-type: application/json');
echo json_encode($ms->findAll());