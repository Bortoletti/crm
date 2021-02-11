<!DOCTYPE html>
<?php
include( './conf/conexao.php' );
include( './conf/util.php');

$fileLog = "oportunidades";


//
//===============================================================================

$id = ( isset( $_REQUEST['id'] ) )?$_REQUEST['id']:5;

$idUsuarioP = $id;


//
//===============================================================================
function fdetalhes( $idUsuarioP, $idp, $nomep )
{

    global $conn, $fileLog, $mensagem;

    $sql = "select nome ||' ' as nome, id_oportunidade
      , replace( replace( descricao, '<',''), '>','') as descricao
      , email, fone
       from crm_oportunidade
       where id_usuario = $idUsuarioP 
         and id_etapa = $idp 
           and id_crm_tipo_perda is null
         limit 10";

    logar( $fileLog, $sql );

    $linhas = array();

    try {
        $result = $conn->query( $sql );
        $rows = $result->fetchAll();
    

        foreach( $rows as $r)
        {
            $id = ( $r['id_oportunidade'] == null)?'':$r['id_oportunidade'];  
            $nome = ( $r['nome'] == null)?'':$r['nome'];  

            $descricao = ( $r['descricao'] == null)?'':$r['descricao'];  
            $descricao = htmlspecialchars( $descricao, ENT_QUOTES);

            $email = ( $r['email'] == null)?'':$r['email'];  
            $fone = ( $r['fone'] == null)?'':$r['fone'];  
            
            $reg  = '{"id":"' . $id . '","nome":"'. $nome . '"';
            $reg .= ',"descricao":"'. str_replace( "\n", '', $descricao) . '"';
            $reg .= ',"email":"'. $email . '"';
            $reg .= ',"fone":"'. $fone . '"';
            $reg .= '}';
        

            $linhas[]  = json_decode( $reg );
            logar( $fileLog, 'Ler Oportunidade:' . $reg );

        }	

    }
    catch(PDOException $e) {
        $status = "FALHA";
        $mensagem = "Error: " . $e->getMessage();
    logar( $fileLog, $mensagem );
    }

    $saida = "";
    foreach( $linhas as $item )
    {


        $saida .= '    <div class="card shadow mb-3">
                <div class="card-header  bg-primary  py-3">
                    <p class="text-white m-0 font-weight-bold">'. $item->nome . '</p>
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="col">
                            <label for="username"><strong>Descrição</strong></label>
               <p>' . $item->descricao . '
                        </div>
                        <div class="col">
                            <label for="username"><strong>Ultimo Historico</strong></label>
               <p class="bg-dark text-white">' . fhistorico( $idUsuarioP, $item->id ) . '
                        </div>
                    </div>                

                    <form>
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group "><label for="username"><strong>Fone</strong></label>
                                <input class="form-control" type="text" placeholder="user.name" name="username" value="' . $item->fone . '" />
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="historico">
                                    <strong>Historico</strong></label>
                                    <textarea class="form-control" aria-label="With textarea"></textarea>
                                    <button type="button" class="btn btn-success">Registrar</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                <label for="email">
                                <strong>Email Address</strong></label>
                                <input class="form-control" type="email" placeholder="user@example.com" name="email" value="'. $item->email .'" />
                                </div>
                            </div>
                            <div class="col">


                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                        <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                    
                                    </div>
                                </div>


                            </div>
                        </div>
                        <div class="form-group">
                          <button class="btn btn-primary btn-sm" type="submit">Atualizar</button>
                        </div>
                    </form>
                </div>
            </div>';

    }

    return $saida;
}




// HISTORICO
//===============================================================================




function fhistorico( $idUsuarioP, $idOportunidade )
{

    $saida = '';
// return '<div class="overflow-auto><p>'. $idOportunidade . '<div>';

    global $conn, $fileLog, $mensagem;

    $sql = "select u.nome
            , i.historico
            , i.ts_inclusao, to_char( i.ts_inclusao, 'dd/mm/yyyy hh24:mi:ss') as ts_inclusao_fmt
            , i.dt_inclusao, to_char( i.dt_inclusao, 'dd/mm/yyyy') as dt_inclusao_fmt
            , i.id_oportunidade_hist
        from usuario u, crm_oportunidade_hist i
            where i.id_oportunidade = $idOportunidade
            and u.id_usuario = i.id_usuario
            order by i.id_oportunidade_hist desc
            limit 1";

logar( $fileLog, $sql );

$linhas = array();

try {
  $result = $conn->query( $sql );
  $rows = $result->fetchAll();
  

	foreach( $rows as $r)
	{
        $nome      = ( $r['nome'] == null)?'':$r['nome'];  
        $historico = ( $r['historico'] == null)?'':$r['historico'];  
        $horario = ( $r['ts_inclusao_fmt'] == null)?'':$r['ts_inclusao_fmt'];  

        $saida .= '<b>' . $nome . '</b>';
        $saida .= '<br>' . $historico;
	    $saida .= '<br><b>' . $horario . '</b>';


	}	

}
catch(PDOException $e) {
	$status = "FALHA";
	$mensagem = "Error: " . $e->getMessage();
  logar( $fileLog, $mensagem );
}



    return $saida . '&nbsp;';
}






// USUARIO
//===============================================================================

	$sql = "select nome from usuario where id_usuario = $id ";

logar( $fileLog, $sql );

$usuario = array();

try {
  $result = $conn->query( $sql );
  $rows = $result->fetchAll();
  

	foreach( $rows as $r)
	{
		$nome = ( $r['nome'] == null)?'':$r['nome'];  
        
		$item = '{"nome":"'. $nome . '"}';
	

		$usuario  = json_decode( $item );
		logar( $fileLog, $item );

	}	

}
catch(PDOException $e) {
	$status = "FALHA";
	$mensagem = "Error: " . $e->getMessage();
  logar( $fileLog, $mensagem );
}


// ETAPAS
//===============================================================================

	$sql = "
SELECT id_etapa, nome
, id_proxima, fl_ativo
, id_etapa_2, nm_reduzido, 
       cor_ativo, bs_cor
, ( select count(1) 
    from crm_oportunidade d 
      where d.id_usuario = $idUsuarioP
        and d.id_etapa = e.id_etapa
          and d.id_crm_tipo_perda is null ) as linhas       
  FROM crm_etapa e
  order by id_etapa_2";

logar( $fileLog, $sql );

$etapas = array();

try {
  $result = $conn->query( $sql );
  $rows = $result->fetchAll();
  

	foreach( $rows as $r)
	{
		$nome = ( $r['nome'] == null)?'':$r['nome'];  
        $cor = ( $r['bs_cor'] == null)?'bg-warning':$r['bs_cor'];  
        $idEtapa = ( $r['id_etapa'] == null)?0:$r['id_etapa'];  
        $linhas = ( $r['linhas'] == null)?0:$r['linhas'];  
        

		$item = '{"id":"'. $idEtapa . '","nome":"'. $nome . '","cor":"'.$cor.'","linhas":"'. $linhas . '"}';
	

		$etapas[]  = json_decode( $item );
		logar( $fileLog, $item );

	}	

}
catch(PDOException $e) {
	$status = "FALHA";
	$mensagem = "Error: " . $e->getMessage();
  logar( $fileLog, $mensagem );
}

// TOTAL DE OPORTUNIDADES
//===============================================================================

$sql = "select count(1) as linhas
from crm_oportunidade
where id_usuario = $id 
  and id_crm_tipo_perda is null ";


logar( $fileLog, $sql );

$totalGeral = 0;

try {
  $result = $conn->query( $sql );
  $rows = $result->fetchAll();
  

	foreach( $rows as $r)
	{
		$totalGeral = ( $r['linhas'] == null)?0:$r['linhas'];  

	}	

}
catch(PDOException $e) {
	$status = "FALHA";
	$mensagem = "Error: " . $e->getMessage();
  logar( $fileLog, $mensagem );
}


// OPORTUNIDADES DO USUARIO POR ETAPA.
//===============================================================================
$sql = "select e.nome as etapa
      , e.bs_cor
      , ( select count(1) 
        from crm_oportunidade d where d.id_usuario = $id 
       and d.id_etapa = e.id_etapa
         and d.id_crm_tipo_perda is null ) as linhas
from crm_etapa e
order by e.id_etapa_2";

$resumoItens = array();

try {
  $result = $conn->query( $sql );
  $rows = $result->fetchAll();
  

	foreach( $rows as $r)
	{
		$nome = ( $r['etapa'] == null)?'':$r['etapa'];  
        $cor = ( $r['bs_cor'] == null)?'bg-warning':$r['bs_cor'];  
        $qtd = ( $r['linhas'] == null)?0:$r['linhas'];  
        $percentual = round( ( $qtd / $totalGeral ) * 100, 0 );
        
		$item = '{"nome":"'. $nome . '","cor":"'.$cor.'"';
		$item .= ',"qtd":"'. $qtd . '","percentual":"'.$percentual.'"}';
	

		$resumoItens[]  = json_decode( $item );

	}	

}
catch(PDOException $e) {
	$status = "FALHA";
	$mensagem = "Error: " . $e->getMessage();
  logar( $fileLog, $mensagem );
}







?>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Table - Brand</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
</head>

<body id="page-top">
    <div id="wrapper">
        <nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0">
            <div class="container-fluid d-flex flex-column p-0"><a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="#">
                    <div class="sidebar-brand-icon rotate-n-15"><i class="fas fa-laugh-wink"></i></div>
                    <div class="sidebar-brand-text mx-3"><span>Brand</span></div>
                </a>
                <hr class="sidebar-divider my-0">
                <ul class="nav navbar-nav text-light" id="accordionSidebar">
                    <li class="nav-item"><a class="nav-link" href="index.html"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="profile.html"><i class="fas fa-user"></i><span>Profile</span></a></li>
                    <li class="nav-item"><a class="nav-link active" href="table.html"><i class="fas fa-table"></i><span>Table</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="login.html"><i class="far fa-user-circle"></i><span>Login</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="register.html"><i class="fas fa-user-circle"></i><span>Register</span></a></li>
                </ul>
                <div class="text-center d-none d-md-inline"><button class="btn rounded-circle border-0" id="sidebarToggle" type="button"></button></div>
            </div>
        </nav>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <nav class="navbar navbar-light navbar-expand bg-white shadow mb-4 topbar static-top">
                    <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle mr-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button>
                        <form class="form-inline d-none d-sm-inline-block mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                            <div class="input-group"><input class="bg-light form-control border-0 small" type="text" placeholder="Search for ...">
                                <div class="input-group-append"><button class="btn btn-primary py-0" type="button"><i class="fas fa-search"></i></button></div>
                            </div>
                        </form>
                        <ul class="nav navbar-nav flex-nowrap ml-auto">
                            <li class="nav-item dropdown d-sm-none no-arrow"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#"><i class="fas fa-search"></i></a>
                                <div class="dropdown-menu dropdown-menu-right p-3 animated--grow-in" aria-labelledby="searchDropdown">
                                    <form class="form-inline mr-auto navbar-search w-100">
                                        <div class="input-group"><input class="bg-light form-control border-0 small" type="text" placeholder="Search for ...">
                                            <div class="input-group-append"><button class="btn btn-primary py-0" type="button"><i class="fas fa-search"></i></button></div>
                                        </div>
                                    </form>
                                </div>
                            </li>
                            <li class="nav-item dropdown no-arrow mx-1">
                                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#"><span class="badge badge-danger badge-counter">3+</span><i class="fas fa-bell fa-fw"></i></a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-list dropdown-menu-right animated--grow-in">
                                        <h6 class="dropdown-header">alerts center</h6><a class="d-flex align-items-center dropdown-item" href="#">
                                            <div class="mr-3">
                                                <div class="bg-primary icon-circle"><i class="fas fa-file-alt text-white"></i></div>
                                            </div>
                                            <div><span class="small text-gray-500">December 12, 2019</span>
                                                <p>A new monthly report is ready to download!</p>
                                            </div>
                                        </a><a class="d-flex align-items-center dropdown-item" href="#">
                                            <div class="mr-3">
                                                <div class="bg-success icon-circle"><i class="fas fa-donate text-white"></i></div>
                                            </div>
                                            <div><span class="small text-gray-500">December 7, 2019</span>
                                                <p>$290.29 has been deposited into your account!</p>
                                            </div>
                                        </a><a class="d-flex align-items-center dropdown-item" href="#">
                                            <div class="mr-3">
                                                <div class="bg-warning icon-circle"><i class="fas fa-exclamation-triangle text-white"></i></div>
                                            </div>
                                            <div><span class="small text-gray-500">December 2, 2019</span>
                                                <p>Spending Alert: We've noticed unusually high spending for your account.</p>
                                            </div>
                                        </a><a class="text-center dropdown-item small text-gray-500" href="#">Show All Alerts</a>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item dropdown no-arrow mx-1">
                                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#"><i class="fas fa-envelope fa-fw"></i><span class="badge badge-danger badge-counter">7</span></a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-list dropdown-menu-right animated--grow-in">
                                        <h6 class="dropdown-header">alerts center</h6><a class="d-flex align-items-center dropdown-item" href="#">
                                            <div class="dropdown-list-image mr-3"><img class="rounded-circle" src="assets/img/avatars/avatar4.jpeg">
                                                <div class="bg-success status-indicator"></div>
                                            </div>
                                            <div class="font-weight-bold">
                                                <div class="text-truncate"><span>Hi there! I am wondering if you can help me with a problem I've been having.</span></div>
                                                <p class="small text-gray-500 mb-0">Emily Fowler - 58m</p>
                                            </div>
                                        </a><a class="d-flex align-items-center dropdown-item" href="#">
                                            <div class="dropdown-list-image mr-3"><img class="rounded-circle" src="assets/img/avatars/avatar2.jpeg">
                                                <div class="status-indicator"></div>
                                            </div>
                                            <div class="font-weight-bold">
                                                <div class="text-truncate"><span>I have the photos that you ordered last month!</span></div>
                                                <p class="small text-gray-500 mb-0">Jae Chun - 1d</p>
                                            </div>
                                        </a><a class="d-flex align-items-center dropdown-item" href="#">
                                            <div class="dropdown-list-image mr-3"><img class="rounded-circle" src="assets/img/avatars/avatar3.jpeg">
                                                <div class="bg-warning status-indicator"></div>
                                            </div>
                                            <div class="font-weight-bold">
                                                <div class="text-truncate"><span>Last month's report looks great, I am very happy with the progress so far, keep up the good work!</span></div>
                                                <p class="small text-gray-500 mb-0">Morgan Alvarez - 2d</p>
                                            </div>
                                        </a><a class="d-flex align-items-center dropdown-item" href="#">
                                            <div class="dropdown-list-image mr-3"><img class="rounded-circle" src="assets/img/avatars/avatar5.jpeg">
                                                <div class="bg-success status-indicator"></div>
                                            </div>
                                            <div class="font-weight-bold">
                                                <div class="text-truncate"><span>Am I a good boy? The reason I ask is because someone told me that people say this to all dogs, even if they aren't good...</span></div>
                                                <p class="small text-gray-500 mb-0">Chicken the Dog · 2w</p>
                                            </div>
                                        </a><a class="text-center dropdown-item small text-gray-500" href="#">Show All Alerts</a>
                                    </div>
                                </div>
                                <div class="shadow dropdown-list dropdown-menu dropdown-menu-right" aria-labelledby="alertsDropdown"></div>
                            </li>
                            <div class="d-none d-sm-block topbar-divider"></div>
                            <li class="nav-item dropdown no-arrow">
                                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#"><span class="d-none d-lg-inline mr-2 text-gray-600 small"><?=$usuario->nome;?></span><img class="border rounded-circle img-profile" src="assets/img/avatars/avatar1.jpeg"></a>
                                    <div class="dropdown-menu shadow dropdown-menu-right animated--grow-in"><a class="dropdown-item" href="#"><i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Profile</a><a class="dropdown-item" href="#"><i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Settings</a><a class="dropdown-item" href="#"><i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Activity log</a>
                                        <div class="dropdown-divider"></div><a class="dropdown-item" href="#"><i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Logout</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
                <div class="container-fluid scroll-menu">

<div class="card-body">
<? foreach( $resumoItens as $item ) { ?>    
    <h4 class="small font-weight-bold"><?=$item->nome;?>(<?=$item->qtd;?>)<span class="float-right"><?=$item->percentual;?>%</span></h4>
    <div class="progress mb-4">
        <div class="progress-bar <?=$item->cor;?>" aria-valuenow="<?=$item->percentual;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?=$item->percentual;?>%;"><span class="sr-only"><?=$item->percentual;?>%</span></div>
    </div>
<? } ?>

</div>



<div class="row">

<div>
    <ul class="nav nav-tabs" role="tablist">
    <? $ativo = 'active'; 
    foreach( $etapas as $item ) { ?>
        <li class="nav-item" role="presentation">
            <a class="nav-link text-white <?=$item->cor;?> <?=$ativo;?>" role="tab" data-toggle="tab" href="#tab-<?=$item->id;?>">
            <?=$item->nome;?>(<?=$item->linhas;?>)
           </a>
        </li>
    <?
      $ativo = '';
    }
    ?>    
    </ul>
    <div class="tab-content">

    <?
    $ativo = 'active'; 
    foreach( $etapas as $item ) {  
        ?>
        <div class="tab-pane <?=$ativo;?>" role="tabpanel" id="tab-<?=$item->id;?>">
            <h3><?=$item->nome;?> </h3>
            <p><?=fdetalhes( $idUsuarioP, $item->id, $item->nome );?></p>
        </div>
    <?
        $ativo = ''; 
 } ?>

    </div>
</div>

</div>








                </div>









            </div>





            <footer class="bg-white sticky-footer">
                <div class="container my-auto">
                    <div class="text-center my-auto copyright"><span>Copyright © Brand 2021</span></div>
                </div>
            </footer>
        </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/chart.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
    <script src="assets/js/theme.js"></script>
</body>

</html>