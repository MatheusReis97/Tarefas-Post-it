<?php


// Incluindo a classe de usuário e a classe de conexão com o banco de dados
include_once '../../Classes/Database.php';
include_once '../../Classes/Tarefas.php';

session_start();

if(!empty($_POST)){
  

$database = new Database();
$db = $database->connect();



$tarefa = new Tarefa($db);

$tarefa->titulo = $_POST['titulo'];
$tarefa->texto = $_POST['descricao'];
$tarefa->criacao = $_POST['data-criacao'];
$tarefa->vencimento = $_POST['data-vencimento'];
$tarefa->situacao = $_POST['situacao'];
$tarefa->user = $_POST['id_user'];



if (!empty($_POST)) { // Verifica se os campos do formulário estão preenchidos
    if ($tarefa->CriarTarefa()) {
        $codigoAcao = "Sucesso";
    } else {
        $codigoAcao = "Falha";
    }
    MensagemAcao($codigoAcao);

    // Redireciona para a página desejada
    header("Location: ../../views/home.php");
    exit(); // Encerra o script para garantir que nada mais seja executado após o redirecionamento
} else {
    echo "Campos estão vazios";
}
}

function MensagemAcao($text) {
    switch ($text) {
        case "Sucesso":
            $_SESSION['mensagemTrue'] = "block !important"; // Define para exibir
        
            break;
        case "Falha":
            $_SESSION['messagemFalse'] = "block !important"; // Define para exibir
            
            break;
    }
}



