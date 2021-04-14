<?php

chdir('..');
include_once 'service/classeService.php';
extract($_POST);

$ds = new classeService();

header('Content-type: application/json');
echo json_encode($ds->findCountClasse());

