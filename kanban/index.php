<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Title</title>
    <link rel="stylesheet" href="./dist/jkanban.min.css" />
    <link
      href="https://fonts.googleapis.com/css?family=Lato"
      rel="stylesheet"
    />



<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<script src="../bootstrap/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>



<link rel="stylesheet" href="./index.css" />





  </head>
  <body>
    <div id="myKanban"></div>
    <button id="addDefault">Add "Default" board</button>
    <br />
    <button id="addToDo">Add element in "To Do" Board</button>
    <br />
    <button id="removeBoard">Remove "Done" Board</button>
    <br />
    <button id="removeElement">Remove "My Task Test"</button>



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

</div> <!-- The Modal -->


<script src="./dist/jkanban.js"></script>
<script src="./index.js"></script>
<script>
  function exibir()
{
	//console.log('Parametro - ' + Object.getOwnPropertyNames( p ) );

	//console.log( JSON.stringnify( p ) );
	// app.exibir( p );
	$('#myModal').modal('show'); 

}

</script>

  </body>
</html>
