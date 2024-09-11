<?php

// Incluindo o arquivo de funções comuns
include_once '../process/user/apresentacao.php';
include_once '../process/tarefas/opcaoPost.php';
include_once '../process/data/manipulacaodata.php';

include '../header.php';


// Verifica a sessão do usuário
$user = verificarSessaoUsuario();

$usuario = $user['users'];
$PostAtuais = $user['leituras'];


// manipulando data 
$hoje = date('Y-m-d');
$Newhoje = new DateTime();




?>



<main class="home">
   <div class=" container topo-suspenso">
      <div class="row g-2">
         <div class="col-9 text-inicio">
            <p>Olá <?php echo $usuario['nm_nome'] ?> , como estão as atividades hoje ?</p>
         </div>
         <div class="col-3 caixa-saida">
            <form class="form-acao" action="../process/user/deslogar.php" method="POST">
               <input type="hidden" name="id_user" value="<?php echo $usuario['id_user']; ?>"><br>
               <button class="btn btn-danger btn-sair" type="submit">SAIR</button>
            </form>
         </div>
      </div>
   </div>
   </div>

   <div class="criar-post container d-grid gap-2">
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
         Criar nova Tarefa
      </button>
   </div>

   <br>
   <div class="container caixa-mensagem" style="display:<?php echo !empty($_SESSION['mensagemTrue']) ? $_SESSION['mensagemTrue'] : "none"; 
unset($_SESSION['mensagemTrue']);?>;">
   <div class="alert alert-success d-flex align-items-center alert-dismissible fade show" role="alert">
  <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
  <div>
    - AÇÃO REALIZADA COM SUCESSO - 
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
</div>
</div>
<div class="container"  style="display:<?php  echo !empty($_SESSION['mensagemFalse']) ? $_SESSION['mensagemFalse'] : "none"; 
unset($_SESSION['mensagemFalse']);?>;">
<div class="alert alert-danger d-flex align-items-center" role="alert">
  <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
  <div>
    - NÃO FOI POSSÍVEL REALIZAR AÇÃO -
  </div>
</div>


   </div>

   <!-- Modal TAREFA -->
   <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
      aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="staticBackdropLabel">NOVA TAREFA</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <form action="../process/tarefas/criarPost.php" method="POST">
                  <label for="titulo" class="col-form-label">titulo:</label><br>
                  <input type="text" name="titulo" id="name" class="form-control" placeholder="Insira o Titulo" required><br>
                  <label for="Descricao" class="col-form-label" >Descricão:</label><br>
                  <textarea type="textarea" name="descricao" class="form-control" id="descricao"
                     placeholder="Insira o texto" required> </textarea><br>
                  <label for="Data-criacao" class="col-form-label">Data abertura:</label>
                  <input type="date" name="data-criacao"  class="form-control"  id="data-criacao" value="<?php echo $hoje; ?>"><br>
                  <label for="Data-vencimento" class="col-form-label">Data Conclusão:</label>
                  <input type="date" name="data-vencimento"  class="form-control" id="data-vencimento" required><br>
                  <label for="titulo" class="col-form-label">Situacão:</label>
                  <select name="situacao" id="situacao"  class="form-control" required><br>
                     <option value="">--</option>
                     <option value="Aberto">Aberto</option>
                     <option value="Em andamento">Em andamento</option>
                     <option value="Concluido">Concluido</option>
                  </select><br>
                  <input type="hidden" name="id_user" value="<?php echo $usuario['id_user']; ?>"><br>

            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
               <button type="submit" class="btn btn-primary">Salvar</button>
               </form>
            </div>
         </div>
      </div>
   </div>
   <br>

   <div class="container">
      <div class="row row-cols-1 row-cols-md-3 g-4 ">

         <?php
         if(!empty($PostAtuais)){
         foreach ($PostAtuais as $Post => $tarefa) { 
          
            $progresso = OrganizadorTempo($tarefa['dt_criacao'],$tarefa['dt_vencimento']);
            $ComparaData = ComparadorData($tarefa['dt_criacao'],$tarefa['dt_vencimento']);
               $backGround = CorPost($tarefa['nm_status']);
            
            ?>

            <div class="col">
               <div class="card mb-3" style="background-color: <?php echo $backGround ?>;">
                  <div class="card-header"> <?php echo $tarefa['nm_status'] ?> </div>
                  <div class="card-body">
                     <input type="hidden" name="id_tasks" value="<?php echo $tarefa['id_tasks'] ?>"><br>
                     <h5 class="card-title"> <?php echo $tarefa['nm_titulo'] ?> </h5>

                  

                     <p class="card-text"> <?php echo $tarefa['text_descricao'] ?> </p>

                     <p class="apoio-text"> Data de Criação:  <?php echo (new DateTime($tarefa['dt_criacao']))->format('d-m-Y') ?><br>
                      aberto : <?php
                         echo $ComparaData['intervaloAbertura'];
                         ?> </p>
                     <p > Data de Vencimento: <?php echo (new DateTime($tarefa['dt_vencimento']))->format('d-m-Y') ?><br>Encerramento  : <?php
                         echo $ComparaData['paraEncerramento'];
                         ?>

                     </p>

                     <p>Gerenciador de Prazos: </p> 
                     <div class="progress">
                     <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $progresso ?>%" aria-valuenow="<?php echo $progresso ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $progresso ?>%</div>
                     </div><br>

                     <div class="btn-group card-footer" role="group" aria-label="Basic outlined example">
                        <?php if ($tarefa['nm_status'] == "Aberto") { ?>

                        
                           <form method="POST" action="../process/tarefas/opcaoPost.php">
                              <input type="hidden" name="acao" value="iniciar">
                              <input type="hidden" name="id_tasks" value="<?php echo $tarefa['id_tasks']; ?>">
                              <button type="submit" class="btn btn-outline-light">Iniciar</button>
                           </form>
                        <?php }   ?>
                        
                    
                           <button type="button" class="btn btn-outline-light" style="   border-radius: 5%;"data-bs-toggle="modal" data-bs-target="#ModalAp<?php echo $tarefa['id_tasks']; ?>">Apagar</button>

<div class="modal fade" id="ModalAp<?php echo $tarefa['id_tasks']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> APAGAR TAREFA </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
         <p>TEM CERTEZA QUE DESEJA APAGAR A SEGUINTE TAREFA ?</p>
      <form action="../process/tarefas/opcaoPost.php" method="POST">
      <input type="hidden" name="acao" value="apagar">
      <input type="hidden" name="id_tasks" value="<?php echo $tarefa['id_tasks']; ?>">
                  <label for="titulo" class="col-form-label">titulo:</label><br>
                  <input type="text" name="titulo" id="name" class="form-control" value="<?php echo $tarefa['nm_titulo']?>" disabled><br>
                  <label for="Descricao" class="col-form-label" >Descricão:</label><br>
                  <textarea type="textarea" name="descricao" class="form-control" id="descricao" disabled
                     ><?php echo $tarefa['text_descricao'] ?></textarea><br>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
               <button type="submit" class="btn btn-primary">Apagar</button>
               </form>
      </div>
    </div>
  </div>
</div>


                        <button type="button" class="btn btn-outline-light" style="   border-radius: 5%;"data-bs-toggle="modal" data-bs-target="#ModalEd<?php echo $tarefa['id_tasks']; ?>">
                        Editar
                        </button>

                      
 <div class="modal fade" id="ModalEd<?php echo $tarefa['id_tasks']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> EDITAR TAREFA </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="../process/tarefas/atualizar.php" method="POST">
      <input type="hidden" name="id_tasks" value="<?php echo $tarefa['id_tasks']; ?>">
                  <label for="titulo" class="col-form-label">titulo:</label><br>
                  <input type="text" name="titulo" id="name" class="form-control" value="<?php echo $tarefa['nm_titulo'] ?>" required><br>
                  <label for="Descricao" class="col-form-label" >Descricão:</label><br>
                  <textarea type="textarea" name="descricao" class="form-control" id="descricao" required
                     ><?php echo $tarefa['text_descricao'] ?></textarea><br>
                  <label for="Data-criacao" class="col-form-label">Data abertura:</label>
                  <input type="date" name="data_criacao"  class="form-control"  id="data_criacao" value="<?php echo $tarefa['dt_criacao'] ?>"><br>
                  <label for="Data-vencimento" class="col-form-label">Data Conclusão:</label>
                  <input type="date" name="data_vencimento"  class="form-control" id="data_vencimento" value="<?php echo $tarefa['dt_vencimento'] ?>" required><br>
                  <label for="titulo" class="col-form-label">Situacão:</label>
                  <select name="situacao" id="situacao"  class="form-control" required><br>
                     <option value="<?php echo $tarefa['nm_status'] ?>"><?php echo $tarefa['nm_status'] ?></option>
                     <option value="Aberto">Aberto</option>
                     <option value="Em andamento">Em andamento</option>
                     <option value="Concluido">Concluido</option>
                  </select><br>
                  <input type="hidden" name="id_user" value="<?php echo $usuario['id_user']; ?>"><br>

            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
               <button type="submit" class="btn btn-primary">Atualizar</button>
               </form>
      </div>
    </div>
  </div>
</div>

      <?php if ($tarefa['nm_status'] != "Concluido") { ?>

                 
         <button type="button" class="btn btn-outline-light" style="   border-radius: 5%;"data-bs-toggle="modal" data-bs-target="#ModalCon<?php echo $tarefa['id_tasks']; ?>">Concluir</button>
                      


<div class="modal fade" id="ModalCon<?php echo $tarefa['id_tasks']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> CONCLUIR TAREFA </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
         <p>TEM CERTEZA QUE DESEJA CONCLUIR ESSA TAREFA ?</p>
      <form action="../process/tarefas/opcaoPost.php" method="POST">
      <input type="hidden" name="acao" value="concluir">
      <input type="hidden" name="id_tasks" value="<?php echo $tarefa['id_tasks']; ?>">
                  <label for="titulo" class="col-form-label">titulo:</label><br>
                  <input type="text" name="titulo" id="name" class="form-control" value="<?php echo $tarefa['nm_titulo']?>" disabled><br>
                  <label for="Descricao" class="col-form-label" >Descricão:</label><br>
                  <textarea type="textarea" name="descricao" class="form-control" id="descricao" disabled
                     ><?php echo $tarefa['text_descricao'] ?></textarea><br>
                     <label for="Data-criacao" class="col-form-label">Data abertura:</label>
                  <input type="date" name="data_criacao"  class="form-control"  id="data_criacao" value="<?php echo $tarefa['dt_criacao'] ?>" disabled ><br>
                  <label for="Data-vencimento" class="col-form-label">Data Conclusão:</label>
                  <input type="date" name="data_vencimento"  class="form-control" id="data_vencimento" value="<?php echo $tarefa['dt_vencimento'] ?>" disabled><br>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
               <button type="submit" class="btn btn-primary">Concluir</button>
               </form>
      </div>
    </div>
  </div>
</div>


                        <?php } ?>
                     </div>
                     <br>
                  </div>
               </div>
            </div>




         <?php } } ?>

      
      </div>
   </div>
   <br>