<!DOCTYPE html>
<?php
include( '../conf/conexao.php' );
include( '../conf/util.php');

$fileLog = "crm_fullcalendar";


//
//===============================================================================

$idUsuario = ( isset( $_REQUEST['id'] ) )?$_REQUEST['id']:5;


logar( $fileLog, '*******  INICIO  **********' );




$sql = "select i.id_oportunidade
, 'new Date( '||to_char( i.inicio_dt, 'yyyy')||', '||cast( cast( to_char( i.inicio_dt, 'mm') as integer ) -1 as varchar)||', '||to_char( i.inicio_dt, 'dd')||')' as calendar
, to_char( inicio_hr, 'hh24:mi')|| ' ' ||nome || ' ' || cast( inicio_hr as varchar ) as titulo 
, 'success' as classe
, to_char( inicio_hr, 'hh24:mi')|| ' ' ||nome || ' ' || cast( inicio_hr as varchar ) as nome
, email
, fone
, ( select d.bs_cor from crm_etapa d where d.id_etapa = i.id_etapa ) as bs_cor
from crm_oportunidade i 
where i.id_usuario = $idUsuario
order by to_char( i.inicio_dt, 'yyymmdd')||to_char( inicio_hr, 'hh24mi') limit 200 ";



logar( $fileLog, "SQL:\n" . $sql );

$saida = '';
$prefixo = '';

try {
  $result = $conn->query( $sql );
  $rows = $result->fetchAll();
  

	foreach( $rows as $r)
	{

	    $param = '{';
	   	$param .= ' nome:"'. $r['nome'] . '"';
		$param .= ', email:"'. $r['email'] . '"';
		$param .= ', fone:"'. $r['fone'] . '"';
		$param .= '}';


		$saida .= $prefixo . '{ id: ' . $r['id_oportunidade'];
		$saida .= ',title:"'. $r['titulo'] . '"';
		$saida .= ',start: ' . $r['calendar'];
		// $saida .= ',url: "http://191.252.0.35/casadecinema/crm_oportunidade_edit/?id_oportunidade='. $r['id_oportunidade']. '"' ;
		 // $saida .= ',url: "http://www.deltaserver.net.br:8091/casadecinema/crm_oportunidade_edit/?id_oportunidade='. $r['id_oportunidade']. '"' ;
		$saida .= ', className:"'. $r['classe'] . '"';
		$saida .= ', id_oportunidade:'. $r['id_oportunidade'] ;
		$saida .= ', nome:"'. $r['nome'] . '"';
		$saida .= ', email:"'. $r['email'] . '"';
		$saida .= ', fone:"'. $r['fone'] . '"';
		$saida .= ', bs_cor:"'. $r['bs_cor'] . '"';
		$saida .= ', param: ' . $param . ' ';
		$saida .= '}';

		$prefixo = ', ';


	}	
	
		logar( $fileLog, $saida );

}
catch(PDOException $e) {
	$status = "FALHA";
	$mensagem = "Error: " . $e->getMessage();

  logar( $fileLog, $mensagem );
}


?>


<html>
<head>
    <title>CRM - Casa de Cinema</title>

	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<link rel="stylesheet" href="bs/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="bs/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="bs/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="bs/fonts/fontawesome5-overrides.min.css">

<link href='assets/css/fullcalendar.css' rel='stylesheet' />
<link href='assets/css/fullcalendar.print.css' rel='stylesheet' media='print' />

<script src='assets/js/jquery-1.10.2.js' type="text/javascript"></script>
<script src='assets/js/jquery-ui.custom.min.js' type="text/javascript"></script>
<script type="text/javascript">
$('.crmModal').on( "click", function() {
	var reg = $( this ).attr('reg');
	var obj = JSON.parse( reg );
	app.nome = obj.nome;
	console.log('param - ' + this.innerHTML );
	console.log('param - ' + reg );
	console.log( 'Form: ' + app.nome );
    $('#myModal').modal('show'); 

});

</script>
<script src='assets/js/fullcalendar.js' type="text/javascript"></script>
<script src='bs/bootstrap/js/bootstrap.min.js' type="text/javascript"></script>

<script src="https://cdn.jsdelivr.net/npm/vue@2"></script>

<script>


		 var itens = [<?=$saida;?>];
		 console.log( itens );
		// var itens = [{ id: 666777 , title: "Bortoletti ", start: new Date(2021, 1, 1, 0, 33, 30, 0) , className: "bg-warning", id_oportunidade : 121212}];
	$(document).ready(function() {
	    var date = new Date();
		var d = date.getDate();
		var m = date.getMonth();
		var y = date.getFullYear();

		/*  className colors

		className: default(transparent), important(red), chill(pink), success(green), info(blue)

		*/


		/* initialize the external events
		-----------------------------------------------------------------*/

		$('#external-events div.external-event').each(function() {

			// create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
			// it doesn't need to have a start or end
			var eventObject = {
				title: $.trim($(this).text())  // use the element's text as the event title
			};

			// store the Event Object in the DOM element so we can get to it later
			$(this).data('eventObject', eventObject);

			// make the event draggable using jQuery UI
			$(this).draggable({
				zIndex: 999,
				revert: true,      // will cause the event to go back to its
				revertDuration: 0  //  original position after the drag
			});

		});


		/* initialize the calendar
		-----------------------------------------------------------------*/

		var calendar =  $('#calendar').fullCalendar({
			header: {
				left: 'title',
				center: 'agendaDay,agendaWeek,month',
				right: 'prev,next today'
			},
			editable: true,
			firstDay: 1, //  1(Monday) this can be changed to 0(Sunday) for the USA system
			selectable: true,
			defaultView: 'month',

			axisFormat: 'h:mm',
			columnFormat: {
                month: 'ddd',    // Mon
                week: 'ddd d', // Mon 7
                day: 'dddd M/d',  // Monday 9/7
                agendaDay: 'dddd d'
            },
            titleFormat: {
                month: 'MMMM yyyy', // September 2009
                week: "MMMM yyyy", // September 2009
                day: 'MMMM yyyy'                  // Tuesday, Sep 8, 2009
            },
			allDaySlot: false,
			selectHelper: true,
			select: function(start, end, allDay) {
				console.log( 'TEste');
				var title = prompt('Event Title:');
				if (title) {
					calendar.fullCalendar('renderEvent',
						{
							title: title,
							start: start,
							end: end,
							allDay: allDay
						},
						true // make the event "stick"
					);
				}
				calendar.fullCalendar('unselect');
			},
			droppable: true, // this allows things to be dropped onto the calendar !!!
			drop: function(date, allDay) { // this function is called when something is dropped

				// retrieve the dropped element's stored Event Object
				var originalEventObject = $(this).data('eventObject');

				// we need to copy it, so that multiple events don't have a reference to the same object
				var copiedEventObject = $.extend({}, originalEventObject);

				// assign it the date that was reported
				copiedEventObject.start = date;
				copiedEventObject.allDay = allDay;

				// render the event on the calendar
				// the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
				$('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

				// is the "remove after drop" checkbox checked?
				if ($('#drop-remove').is(':checked')) {
					// if so, remove the element from the "Draggable Events" list
					$(this).remove();
				}

			},

			events: itens
		});


	});

</script>
<style>

	body {
		margin-top: 40px;
		text-align: center;
		font-size: 14px;
		font-family: "Helvetica Nueue",Arial,Verdana,sans-serif;
		background-color: #DDDDDD;
		}

	#wrap {
		width: 1100px;
		margin: 0 auto;
		}

	#external-events {
		float: left;
		width: 150px;
		padding: 0 10px;
		text-align: left;
		}

	#external-events h4 {
		font-size: 16px;
		margin-top: 0;
		padding-top: 1em;
		}

	.external-event { /* try to mimick the look of a real event */
		margin: 10px 0;
		padding: 2px 4px;
		background: #3366CC;
		color: #fff;
		font-size: .85em;
		cursor: pointer;
		}

	#external-events p {
		margin: 1.5em 0;
		font-size: 11px;
		color: #666;
		}

	#external-events p input {
		margin: 0;
		vertical-align: middle;
		}

	#calendar {
/* 		float: right; */
        margin: 0 auto;
		width: 900px;
		background-color: #FFFFFF;
		  border-radius: 6px;
        box-shadow: 0 1px 2px #C3C3C3;
		}

</style>
</head>
<body>





<button type="button" class="btn btn-primary" 
    data-toggle="modal" data-target="#myModal">Nova Oportunidade</button>

<button id='btnNovo' reg='{"nome":"Luis"}' type="button" class="btn btn-primary crmModal" >Nova Oportunidade</button>
<button id='btnNovo2' reg='{"nome":"Bortoletti"}' type="button" class="btn btn-primary crmModal" >Nova Oportunidade 2</button>

<div id='wrap'>

<div id='calendar'>


<!-- The Modal -->
<div id='editOportunidade'>

<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Modal Heading</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="card shadow mb-3">
                <div class="card-header  bg-primary  py-3">
                    <p class="text-white m-0 font-weight-bold">{{nome}}</p>
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="col">
                            <label for="username"><strong>Descrição</strong></label>
               <p>
                        </div>
                        <div class="col">
                            <label for="username"><strong>Ultimo Historico</strong></label>
               <p class="bg-dark text-white">
                        </div>
                    </div>                

                    <form>
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group "><label for="username"><strong>Fone</strong></label>
                                <input class="form-control" type="text" placeholder="user.name" name="username" value="xxxxxxxx" />
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
                                <input class="form-control" type="email" placeholder="user@example.com" name="email" value="ddddddddddd" />
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
            </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

	</div>



</div>

<div style='clear:both'></div>
</div>

<script>

var app = new Vue({
el: "#editOportunidade",
data: {
	id : 0
	, nome: "Teste"
	, celular: ""
	, email: ""
},
methods : {
	exibir: function( nomep )
	{
		this.nome = nomep 
	}
}
});

var formulario = {
	nome : ''
	, celular : ''
	, email : ''
	, id : 0
}

$('#btnNovo').on( "click", function() {

    $('#myModal').modal('show'); 

});

$('.crmModal').on( "click", function() {
	alert( 'Teste' );
		var url = 'http://191.252.0.35/casadecinema/crm_oportunidade_edit/';
	//window.location = url;
	/*
		var reg = $( this ).attr('reg');
	var obj = JSON.parse( reg );
	app.nome = obj.nome;
	console.log('param - ' + this.innerHTML );
	console.log('param - ' + reg );
	console.log( 'Form: ' + app.nome );
    $('#myModal').modal('show'); 
*/
});


function exibir( p )
{
	//console.log('Parametro - ' + Object.getOwnPropertyNames( p ) );

	//console.log( JSON.stringnify( p ) );
	app.exibir( p );
	$('#myModal').modal('show'); 

}

	</script>
</body>
</html>
