<?




function logar( $nomeParam, $msgv )
{
  date_default_timezone_set('America/Sao_Paulo');

  //$arq = "../logs/$nomeParam" . '_' . date_format( date_create()  , 'YmdH') . "0000.log";
  $arq  = "C:/Program Files/NetMake/v9-php73/wwwroot/crm/logs/" ;
  $arq .=  date_format( date_create()  , 'Ymd_H') . "0000_";
  $arq .= $nomeParam . '.log' ;
  
  $log = "# " . date_format( date_create()  , 'd/m/Y H:i:s') . "; $msgv \n";
  
  
  file_put_contents( $arq, $log, FILE_APPEND );
  
}


function logar2( $msgv, $fileDefault = 'arquivo', $pathDefault = '../logs' )
{
  date_default_timezone_set('America/Sao_Paulo');

  //$arq = "../logs/$nomeParam" . '_' . date_format( date_create()  , 'YmdH') . "0000.log";
  $arq  = $pathDefault . '/' ;
  $arq .= date_format( date_create()  , 'Ymd_H') . "0000_";
  $arq .= $fileDefault . '.log' ;
  
  $log = "# " . date_format( date_create()  , 'd/m/Y H:i:s') . "; $msgv \n";
  
  
  file_put_contents( $arq, $log, FILE_APPEND );
  
}


function codex( $param1 )
{
  $retorno = $param1;

  $retorno = str_replace(".", "w", $retorno );
  $retorno = str_replace("0", "a", $retorno );
  $retorno = str_replace("1", "z", $retorno );
  $retorno = str_replace("2", "i", $retorno );
  $retorno = str_replace("aa", "n", $retorno );

  return $retorno;
}

function decodex( $param1 )
{
  $retorno = $param1;

  $retorno = str_replace("n", "aa", $retorno );
  $retorno = str_replace("i", "2", $retorno );
  $retorno = str_replace("z", "1", $retorno );
  $retorno = str_replace("a", "0", $retorno );
  $retorno = str_replace("w", ".", $retorno );
  
  return $retorno;
}

function enviarEmail( $email, $titulo, $msg, $contexto = 'enviar_email', $id = 0 )
{
    
  $url = "https://deltasystems.com.br/o2/email/$contexto.php";

  $param = array();
  $param["email"]   = ($email);
  $param["titulo"]  =  $titulo;
  $param["msg"]     = $msg;


  $ch = curl_init();

  curl_setopt($ch, CURLOPT_URL, $url );
  curl_setopt($ch, CURLOPT_POST, true );
  curl_setopt($ch, CURLOPT_POSTFIELDS, $param );
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

  $retorno = curl_exec($ch);

  curl_close ($ch);

  return  $retorno ;
}
?>