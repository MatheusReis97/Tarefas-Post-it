<?php

// Incluindo a classe de usuário e a classe de conexão com o banco de dados
include_once __DIR__ . '/../../Classes/Database.php';
include_once __DIR__ . '/../../Classes/User.php';
include_once __DIR__ . '/../../Classes/Tarefas.php';

function OrganizadorTempo($datainicio, $dataVencimento){

    $datainicial = new DateTime($datainicio);
    $dataFim = new DateTime($dataVencimento);
    $dataAtual = new DateTime();
 


    $intervaloTotal = $datainicial->diff($dataFim)->days;

    $intervaloAtual = $datainicial->diff($dataAtual)->days;  

    if($dataFim == $datainicial){
        $intervaloAtual = 1;
        $intervaloTotal = 1;
        $porcentagemProgresso = 100;
    }elseif ($intervaloAtual == 0 && $intervaloTotal > 1) {
            $porcentagemProgresso =   100 / ($intervaloTotal);
            
        }elseif($intervaloAtual == 0 && $intervaloTotal == 1 ){
            $porcentagemProgresso = 90;
        }else 
        { 
            $porcentagemProgresso = ($intervaloAtual / $intervaloTotal) * 100;
        }
    

    if ($porcentagemProgresso > 100) {
        $porcentagemProgresso = 100;
    }

    return number_format($porcentagemProgresso, 2, '.', '');
}

function ComparadorData($datainicial , $dataFinal){
    $diaAtual = new DateTime();
    $dataInicio = new DateTime($datainicial);
    $dataFinal  = new DateTime($dataFinal);

    // tras a diferença do dia inicio e o atual 
    $diferenca = $dataInicio->diff($diaAtual);

    if($diferenca->days == 0){
        $diferenca = "Hoje";
    }elseif($diferenca->days == 1){
        $diferenca = "{$diferenca->days} dia"; 
    }else {
        $diferenca = "{$diferenca->days} dias"; 
 
    }

    $paraEncerramento = $dataFinal->diff($diaAtual);

    if ($paraEncerramento->days == 0 && $paraEncerramento->invert == 0) {
        $paraEncerramento = "Hoje";
    } 
    elseif ($paraEncerramento->days == 0 && $paraEncerramento->invert == 1) {
        $paraEncerramento = "Amanhã"; 
    }
    elseif ($paraEncerramento->invert == 1) {
        $paraEncerramento = "{$paraEncerramento->days} dias restantes";   
    }else {
        $paraEncerramento = "Está em atraso em {$paraEncerramento->days} dias";
    }
    
    
    // 
    return [ 
            'paraEncerramento' => $paraEncerramento,
            'intervaloAbertura' => $diferenca
];
}

