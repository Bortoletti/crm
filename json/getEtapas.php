<?php
header("Access-Control-Allow-Origin: *");
include("../conf/conexao.php");
include("../conf/util.php");

$fileLog = 'oportunidades';
$status = 'SUCESSO'; // status de saida 
$mensagem = 'ok'; // mensagem.

/*============================================================
      
============================================================*/

	$sql = "
SELECT id_etapa, nome
, id_proxima, fl_ativo
, id_etapa_2, nm_reduzido, 
       cor_ativo
  FROM crm_etapa
  order by id_etapa_2";

logar( $fileLog, $sql );

$etapas = array();

try {
  $result = $conn->query( $sql );
  $rows = $result->fetchAll();
  

	foreach( $rows as $r)
	{
		$nome = ( $r['nome'] == null)?'':$r['nome'];  
		$cor = ( $r['cor_ativo'] == null)?'':$r['cor_ativo'];  
		$item = '{"nome":"'. $nome . '","cor":"'.$cor.'"}';
	

		$etapas[]  = $item;
		logar( $fileLog, $item );

	}	

}
catch(PDOException $e) {
	$status = "FALHA";
	$mensagem = "Error: " . $e->getMessage();
  logar( $fileLog, $mensagem );
}


$saida = '{"status":"'. $status . '","mensagem":"'. $mensagem . '","itens":' .  json_encode( $etapas ) . '}';
/*========================================================================
                    RETORNO AO CLIENTE
========================================================================*/

print( $saida );

logar( $fileLog, $saida );

logar( $fileLog, '------------------------------   Fim   ------------------------------' );



?>