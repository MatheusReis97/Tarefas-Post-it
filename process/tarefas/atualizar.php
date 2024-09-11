<?php

// Incluindo a classe de usuário e a classe de conexão com o banco de dados
include_once '../../Classes/Database.php';
include_once '../../Classes/Tarefas.php';

session_start();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id_tasks'];

    $database = new Database();
    $db = $database->connect();

    $tarefa = new Tarefa($db);
    
    $dadosbanco=$tarefa->lerTarefaPorId($id);

    $dadosAtuais = $dadosbanco[0];

    $dadosFormulario = [
        'nm_titulo' => $_POST['titulo'],
        'text_descricao' => $_POST['descricao'],
        'dt_criacao' => $_POST['data_criacao'],
        'dt_vencimento' => $_POST['data_vencimento'],
        'nm_status' => $_POST['situacao']
    ];

    $camposAlterados = [];

   foreach ($dadosFormulario as $campo => $novoValor){
    if($dadosAtuais[$campo]!==$novoValor){
        $camposAlterados[$campo] = $novoValor;
    }
   }
   
    $camposAlterados['id'] = $_POST['id_tasks'];
   
  
    
   if(!empty($camposAlterados) && count($camposAlterados) > 1) {
    $resultado = $tarefa->alteracaoComplexa($camposAlterados);
    
    if($tarefa->alteracaoComplexa($camposAlterados)){
        $codigoAcao = "Sucesso";
    } else {
        $codigoAcao = "Falha";
    }
    MensagemAcao($codigoAcao);

    header("Location: ../../views/home.php");
    exit(); 

} else {
    echo "Nenhuma alteração foi detectada.";
}
    

/*  FUNCIONANDO  -  COMENTANDO PARA TENTATIVA MAIS COMPLEXA
    $tarefa->titulo = $_POST['titulo'];
    $tarefa->texto = $_POST['descricao'];
    $tarefa->criacao = $_POST['data_criacao'];
    $tarefa->vencimento = $_POST['data_vencimento'];
    $tarefa->situacao = $_POST['situacao'];



    if ($tarefa->editarTarefa($id)) {
        echo "Tarefa atualizada com sucesso.";
        // header("Location: ../../views/home.php");
    } else {
        echo "Erro ao atualizar a tarefa.";
    }*/


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
