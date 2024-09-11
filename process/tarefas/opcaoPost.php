<?php

// Incluindo a classe de usuário e a classe de conexão com o banco de dados
include_once __DIR__ . '/../../Classes/Database.php';
include_once __DIR__ . '/../../Classes/User.php';
include_once __DIR__ . '/../../Classes/Tarefas.php';


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_tasks = $_POST['id_tasks'];

    switch ($_POST['acao']) {
        case 'apagar':
            apagarTarefa($id_tasks);
            break;

        case 'editar':
            editarTarefa($id_tasks);
            break;

        case 'concluir':
            concluirTarefa($id_tasks);
            break;
        
         case 'iniciar':
            iniciarTarefa($id_tasks);
            break;

        default:
            echo "Ação inválida!";
            break;
    }
}

function editarTarefa($id) {
    header("Location: ../../views/editar.php?id={$id}");
    exit();
}


function apagarTarefa($id){
    $database = new Database();
    $db = $database->connect();

 // Crie uma instância da classe Usuario
    $Post = new Tarefa($db);

    $idPostApagar = $_POST['id_tasks'];

    if($Post->ApagarTarefa($idPostApagar)){

        $codigoAcao = "Sucesso";
    } else {
        $codigoAcao = "Falha";
    }
    MensagemAcao($codigoAcao);


    header("Location: ../../views/home.php");
    exit(); 

}



function MensagemAcao($text) {
    switch ($text) {
        case "Sucesso":
            $_SESSION['mensagemTrue'] = "block !important"; 
        
            break;
        case "Falha":
            $_SESSION['messagemFalse'] = "block !important"; 
            
            break;
    }


   
}


function concluirTarefa($id){
    $database = new Database();
    $db = $database->connect();


    $Tarefa = new Tarefa($db);

    $idPostConcluir = $_POST['id_tasks'];

    if($Tarefa->ConcluirPost($idPostConcluir)){
        $codigoAcao = "Sucesso";
    } else {
        $codigoAcao = "Falha";
    }
    MensagemAcao($codigoAcao);


    header("Location: ../../views/home.php");
    exit(); 

}

function iniciarTarefa($id){
    $database = new Database();
    $db = $database->connect();


    $Tarefa = new Tarefa($db);

    $idPostConcluir = $_POST['id_tasks'];

    if($Tarefa->IniciarPost($idPostConcluir)){
        $codigoAcao = "Sucesso";
    } else {
        $codigoAcao = "Falha";
    }
    MensagemAcao($codigoAcao);


    header("Location: ../../views/home.php");
    exit(); 

}




