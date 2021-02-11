<?php
header("Access-Control-Allow-Origin: *");
include("../conf/conexao.php");
include("../conf/util.php");

$fileLog = 'oportunidades';
$status = 'SUCESSO'; // status de saida 
$mensagem = 'ok'; // mensagem.

logar( $fileLog, '=================   INICIO   =================' );
/*============================================================
                      MAIN
============================================================*/

/*========================================================================
                    RETORNO AO CLIENTE
========================================================================*/
$saida = '{"status":"'. $status . '","mensagem":"'. $mensagem . '","itens":' .  json_encode( $etapas ) . '}';

print( $saida );

logar( $fileLog, $saida );

logar( $fileLog, '------------------------------   Fim   ------------------------------' );



?>