
      var KanbanTest = new jKanban({
        element: "#myKanban",
        gutter: "10px",
        widthBoard: "250px",
        itemHandleOptions:{
          enabled: true,
        },
        click: function(el) {
          console.log("Trigger on all items click!");
          console.log( el );
        },
        dropEl: function(el, target, source, sibling){
          console.log(target.parentElement.getAttribute('data-id'));
          console.log(el, target, source, sibling)
        },
        buttonClick: function(el, boardId) {
          console.log('buttonClick');
          console.log(el);
          console.log(boardId);
          // create a form to enter element
          var formItem = document.createElement("form");
          formItem.setAttribute("class", "itemform");
          formItem.innerHTML =
            '<div class="form-group"><textarea class="form-control" rows="2" autofocus></textarea></div><div class="form-group"><button type="submit" class="btn btn-primary btn-xs pull-right">Submit</button><button type="button" id="CancelBtn" class="btn btn-default btn-xs pull-right">Cancel</button></div>';

          KanbanTest.addForm(boardId, formItem);
          formItem.addEventListener("submit", function(e) {
            e.preventDefault();
            var text = e.target[0].value;
            KanbanTest.addElement(boardId, {
              title: text
            });
            formItem.parentNode.removeChild(formItem);
          });
          document.getElementById("CancelBtn").onclick = function() {
            formItem.parentNode.removeChild(formItem);
          };
        },
        itemAddOptions: {
          enabled: true,
          content: '+ Add New Card',
          class: 'custom-button',
          footer: true
        },
        boards: [
          {
            id: "_todo",
            title: "Etapa 1",
            class: "info,good",
            dragTo: ["_working", "_fechamento", "_done"],
            item: [
              {
                id: "10001",
                title: "10001 - XXXXX ???????",
                valor: 10001,
                drag: function(el, source) {
                  console.log("DRAG start: " + el.dataset.eid);
                  console.log("DRAG valor: " + el.dataset.valor);
                },
                dragend: function(el) {
                  console.log("END DRAG: " + el.dataset.eid);
                  console.log("END DRAG: " + el.dataset);
                },
                drop: function(el) {
                  console.log("DROPPED: " + el.dataset.eid);
                }
                , click: function (el) {
                  // alert("click valor: " + el.dataset.valor );
                    mensagem('{"id":"' + el.dataset.eid + '","valor":"' + el.dataset.valor + '"}');
                    exibir();
                }
              }
             , {
                id: "10002",
                title: "10002 - XXXXX ???????",
                valor: 10002,
                drag: function (el, source) {
                  console.log("DRAG start: " + el.dataset.eid);
                  console.log("DRAG valor: " + el.dataset.valor);
                },
                dragend: function (el) {
                  console.log("END DRAG: " + el.dataset.eid);
                  console.log("END DRAG: " + el.dataset);
                },
                drop: function (el) {
                  console.log("DROPPED: " + el.dataset.eid);
                }
               , click: function (el) {
                 // alert("click valor: " + el.dataset.valor );
                 mensagem('{"id":"' + el.dataset.eid + '","valor":"' + el.dataset.valor + '"}');
               }
              }
            , {
                id : "99001"
                , title: "Try Click This!"
                , valor: "12.33"
                , class: ["peppe", "bello"]
                , click: function(el) {
                  // alert("click valor: " + el.dataset.valor );
                  mensagem( '{"id":"' + el.dataset.eid +'","valor":"'+el.dataset.valor+'"}' );
                }
              }
            ]
          },
          {
            id: "_working",
            title: "Working (Try drag me too)",
            class: "warning",
            item: [
              {
                title: "Tarefa 001"
                , id_tarefa : 99
                , dt_agenda : "01/02/2021"
              },
              {
                title: "Tarefa 002"
                , id_tarefa : 100
                , dt_agenda: "01/03/2021"
              }
            ]
          },
          {
            id: "_done",
            title: "Done (Can drop item only in working)",
            class: "success",
            dragTo: ["_working"],
            item: [
              {
                title: "All right"
              },
              {
                title: "Ok!"
              }
            ]
          }
          ,           {
            id: "_fechamento",
            title: "Fechamento",
            class: "warning",
            dragTo: ["_working"],
            item: [
              {
                title: "All right"
              },
              {
                title: "Ok!"
              }
            ]
          }
        ]
      });

      var toDoButton = document.getElementById("addToDo");
      toDoButton.addEventListener("click", function() {
        KanbanTest.addElement("_todo", {
          title: "Test Add"
        });
      });

      var addBoardDefault = document.getElementById("addDefault");
      addBoardDefault.addEventListener("click", function() {
        KanbanTest.addBoards([
          {
            id: "_default",
            title: "Kanban Default",
            item: [
              {
                title: "Default Item"
              },
              {
                title: "Default Item 2"
              },
              {
                title: "Default Item 3"
              }
            ]
          }
        ]);
      });

      var removeBoard = document.getElementById("removeBoard");
      removeBoard.addEventListener("click", function() {
        KanbanTest.removeBoard("_done");
      });

      var removeElement = document.getElementById("removeElement");
      removeElement.addEventListener("click", function() {
        KanbanTest.removeElement("_test_delete");
      });

      var allEle = KanbanTest.getBoardElements("_todo");
      allEle.forEach(function(item, index) {
      
        console.log(item);
      });


      function mensagem( msg )
      {
        console.log( msg );
      }
