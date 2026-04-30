<?php

header("acess-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, DELETE, PUT, OPTIONS");

echo json_encode(array("Mensagem"=>"Hello! Bem vindos a Juca Pizza!"));

