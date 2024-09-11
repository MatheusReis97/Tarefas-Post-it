<?php

include_once '../process/user/apresentacao.php';
include_once '../Classes/Tarefas.php';
include_once '../Classes/Database.php';




// Verifica a sessão do usuário
$user = verificarSessaoUsuario();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Conectar ao banco de dados
    $database = new Database();
    $db = $database->connect();

    // Criar uma instância da classe Tarefa
    $tarefa = new Tarefa($db);

   
    // Carregar os dados da tarefa
    $tarefaInfo = $tarefa->lerTarefaPorId($id);
    
    

    if ($tarefaInfo) {
        
    } else {
        echo "Tarefa não encontrada.";
    }
} else {
    echo "ID da tarefa não foi passado.";
}



?>

<?php foreach ($tarefaInfo as $tarefas){ 
$dataVencimento = date('Y-m-d', strtotime($tarefas['dt_vencimento']));    
$dataAbertura = date('Y-m-d', strtotime($tarefas['dt_criacao']));    
?>
<form action="../process/tarefas/atualizar.php" method="POST">
    
    <input type="hidden" name="id_tasks" value="<?php echo $tarefas['id_tasks']; ?>">
    <label for="nm_titulo">Título:</label>
    <input type="text" name="titulo" value="<?php echo $tarefas['nm_titulo']; ?>">
    <label for="Descricao">Texto:</label>
<textarea name="descricao"><?php echo $tarefas['text_descricao']; ?></textarea><br>
    <label for="Data_criacao">Data abertura:</label>
    <input type="date" name="data_criacao" value="<?php echo $dataAbertura; ?>"><br>
    <label for="Data_vencimento">Data de Vencimento:</label>
    <input type="date" name="data_vencimento" value="<?php echo $dataVencimento; ?>"><br>

    <label for="titulo">Situacao:</label>
        <select name="situacao" id="situacao"><br>
        <option value="<?php echo $tarefas['nm_status']; ?>"><?php echo $tarefas['nm_status']; ?></option>
        <option value="Aberto">Aberto</option>
        <option value="Andamento">Em andamento</option>
        <option value="Concluido">Concluido</option>
        </select><br>
    <button type="submit">Atualizar</button>
</form>

<?php } ?>