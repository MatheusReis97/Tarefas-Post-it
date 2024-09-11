<?php

include_once __DIR__ . '/apresentacao.php';

session_start();  // Inicia a sessão

$usuario = UsuarioDaSessao();

if($usuario){
    session_destroy();    
    header("Location: ../../index.php");
    exit();
}else{
    header("Location: ../../index.php"); 
}