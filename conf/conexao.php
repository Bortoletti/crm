<?
$credencial = '612136fdeb92a650245091130f12e12640e768d4';
$chave      = 'd0ed7ef96755abb83b483013e23146d2df2e615e';

$conn = new PDO("pgsql:dbname=casadecinema;host=191.252.2.252", "delta", "DeltaDb@10" ); 
$conn->setAttribute(PDO::ATTR_ERRMODE, $conn::ERRMODE_EXCEPTION);

$GLOBALS['sqlConn'] = $conn;

$URL_ROOT = 'https://www.deltasystems.com.br/o2';

$GLOBALS['URL_ROOT'] = $URL_ROOT;

/*
function addLog( $sqlParam )
{
  $rs = $conn->prepare( $sqlParam );
   $rs->execute();  
}
*/
/*
class Boleto{
  public $idBoleto = 0;
  public $grupov = 0;
  public $venctov = '12/31/2020';
  public $boletoValor = 789.45;
  public $boletoJuros = 0;
  public $boletoJurosFixo = 0;
  public $boletoMultaValor = 0;
  public $boletoMultaFixo = 0;
  public $boletoFaturaDesc = 'MENSALIDADE DE SERVICOS DE SUPORTE E ATUALIZACAO DE SISTEMA';
  public $boletoFaturaEspecie = 'DS'; // DS = Duplicata de Servico ou DM Duplicata Mercantil.
  public $boletoFaturaInstrucao = '';

  public $boletoDesconto = 0;
  public $boletoDiasDesconto = 0;

  public $boletoDesconto2 = 0;
  public $boletoDiasDesconto2 = 0;

  public $boletoDesconto3 = 0;
  public $boletoDiasDesconto3 = 0;


  public $clienteNome = 'LUIS ALEXANDRE BORTOLETTI';
  public $clienteEmail = 'lbortoletti@gmail.com';
  public $clienteTelefone = '11963676461';
  public $clienteCPF = '12952947880';
  public $clienteEnd = 'RUA MARIO DE JESUS RODRIGUES';
  public $clienteEndNr = '106';
  public $clienteEndComplemento = '';
  public $clienteEndBairro = 'VILA RIO';
  public $clienteEndCidade = 'GUARULHOS';
  public $clienteEndUf = 'SP';
  public $clienteEndCep = '07115360';
  	
	
}

===============*/

/*
$rs = $conn->prepare("SELECT id_usuario, nome FROM cob_usuario order by nome");
$rs->execute();

$result = $rs->fetchAll();
// print_r($result);
foreach( $result as $r )
{
	print( "<br>" . $r[1] . "(" . $r[0] . ")" );
}

*/



/*
$conn = pg_connect( "host=191.252.2.252 port=5432 dbname=delta user=delta password=delta" );
$result = pg_query($conn, "select * from usuario");

$linhas = pg_fetch_array( $result );

foreach( $linhas as $r )
{
	print("<br>" . $r[0] );
}

*/


?>