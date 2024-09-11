<?php

// Incluindo a classe de usuário e a classe de conexão com o banco de dados
include_once __DIR__ . '/../../Classes/Database.php';
include_once __DIR__ . '/../../Classes/User.php';
include_once __DIR__ . '/../../Classes/Tarefas.php';

session_start();

// Função para iniciar a sessão e verificar o login do usuário

function UsuarioDaSessao(){
    if (!empty($_SESSION) && isset($_SESSION['user_id'])) {
       return  $_SESSION['user_id'];
       } else {
        header("Location: ../../public/index.php"); 
       }
}

function ConexaoBanco(){
    $database = new Database();
    $db = $database->connect();

  
    return $db;
}

function verificarSessaoUsuario() {

    // Verifica se a sessão está iniciada e se o usuário está logado
    $userId = UsuarioDaSessao();
    if ($userId !== null) {
        $db = ConexaoBanco();
       
   
        if ($db !== null) {
            $usuario = new User($db);

            
            $user = $usuario->leitura($userId);

            $leituras = new Tarefa($db);

            $tarefasCriadas = $leituras->lerTarefasUsuario($userId);

          $tarefasCriadasOrdenadas = OrdenandoPost($tarefasCriadas);


            return [
                'users' => $user,
                'leituras' => $tarefasCriadasOrdenadas,
            ];
        }
    } else {
        echo "Nenhum usuário logado.";
    }
    return false;
}



function OrdenandoPost($tarefasCriadas){
    $arrayPost = $tarefasCriadas;

    // Definindo a ordem personalizada
$ordemSituacao = [
    "Aberto" => 1,
    "Em andamento" => 2,
    "Concluido" => 3
];

// Função de comparação personalizada
if(!empty($arrayPost)){
usort($arrayPost, function($a, $b) use ($ordemSituacao) {
    $result = $ordemSituacao[$a['nm_status']] <=> $ordemSituacao[$b['nm_status']];
        
    // Se os status forem iguais, comparar pela data de criação
    if ($result === 0) {
        $result = strtotime($b['dt_criacao']) <=> strtotime($a['dt_criacao']);
    }

    return $result;
    });
}   

return $arrayPost;
}

function CorPost($situacao){
    $SituacaoAtual = $situacao;

    switch($SituacaoAtual){
        case "Aberto" : 
            $corfundo = "#A4A7F5";
            break;
        case "Em andamento" : 
            $corfundo = "#5BA39F";
            break;
        case "Concluido" : 
            $corfundo = "#324E75";
            break;
        default : "black";
    }


    return $corfundo;
}