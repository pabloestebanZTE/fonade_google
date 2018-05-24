////////////////////////////////////////////////////////////////////////////////////////////////////////
/********************este metodo para llenar datatables es para usarlo directo, sin server side progresing********************/
////////////////////////////////////////////////////////////////////////////////////////////////////////

//funcion Autodeclarable
$(function () {
    vista = {
        init: function () {
            //inicializamos las funciones
            vista.events();
            vista.getListPreventive();
        },

        //Eventos de la ventana.
        events: function () {
            //Al darle clic a una fila llama la funcion onClickTrTablePreventive
            $('#tablePreventive').on('click', 'tr', vista.onClickTrTablePreventive);
            //funcion para llenar select del formulario del modal
            vista.fillSelect();
            if (permisos == 1) {
              $('#mbtnUpdticket').on('click', vista.onClickBotonActualizar);              
            } else {
              $('#mbtnUpdticket').on('click',alert('no tienes permiso para editar tickets'));
            }

            // $('table').off('click', '.btn-preview', vista.onClickPreviewBtn);
            // $('table').on('click', '.btn-preview', vista.onClickPreviewBtn);
            // $('.tab-tables').on('click', vista.onClickTabTables);
        },
        // Capturo los valores de la fila a la que le doy clic
        onClickTrTablePreventive: function(){
          var tr = $(this);
          vista.tr = tr;
            if (vista.tablePreventive) {
                var registro = vista.tablePreventive.row(tr).data();
                //si selecciona el header de la tabla no se muestre el modal
                if (registro != undefined) {
                  vista.modalEditar(registro);   
                }
            }
            
        },
        //llama el modal
        modalEditar: function(registro){
          //mostrar modal
          $('#modalEditTicket').modal('show');
          // se compara si viene vacio alguno de los campos de usuarios
          var valTecIT = registro.T_IT ? registro.T_IT.K_IDUSER.K_IDUSER : "";
          var valAuxIT = registro.A_IT ? registro.A_IT.K_IDUSER.K_IDUSER : "";
          var valTecAA = registro.T_AA ? registro.T_AA.K_IDUSER.K_IDUSER : "";
          var valAuxAA = registro.A_AA ? registro.A_AA.K_IDUSER.K_IDUSER : "";
          //añade clase al estado para pintarlo de lo que venga en base de datos
          var letter = ((registro.N_COLOR == "FFFFFF") || (registro.N_COLOR == "FFFF00")) ? "#000000" : "#fff"
          $("#statusColor").attr('style', 'background-color: #' + registro.N_COLOR + '; color: ' + letter + ';');
          //llenar formulario conlos datos existentes
          $ ('#mtxtTicket').val(registro.K_IDTICKET);
          
          $ ('#mtxtPVD').val(registro.K_IDMAINTENANCE.K_IDPVD.K_IDPVD);
          $ ('#mtxtProgramado').val(registro.K_IDMAINTENANCE.D_STARTDATE);
          $ ('#mtxtIniMant').val(registro.D_STARTDATE);
          $ ('#mtxtEstado').val(registro.K_IDSTATUSTICKET);
          $ ('#mtxtDuracion').val(registro.I_DURATION);
          $ ('#mtxtFinMant').val(registro.D_FINISHDATE);
          $('#mtxtTecIT').val(valTecIT);           
          $ ('#mtxtIniIT').val(registro.D_STARTDATEIT);
          $('#mtxtAuxIT').val(valAuxIT);            
          $ ('#mtxtFinIT').val(registro.D_FINISHDATEIT);
          $('#mtxtTecAA').val(valTecAA);            
          $ ('#mtxtIniAA').val(registro.D_STARTDATEAA);
          $('#mtxtAuxAA').val(valAuxAA);
          $ ('#mtxtFinAA').val(registro.D_FINISHDATEAA);
          $ ('#mtxtObservaciones').val(registro.K_OBSERVATION_I);
          // pintp el titulo del modal con el ticket correspondiente
          $ ('#myModalLabel').html('Editar Ticket&nbsp;&nbsp;&nbsp;&nbsp;<b>' + registro.K_IDTICKET +'</b>');
          
        },

        fillSelect: function(){
          $.post(baseurl + "user/getTechnical",
              {
                // "sitReg": 1
              },
              function (data) {
                // Decodifica el objeto traido desde el controlador
                var users = JSON.parse(data);
                // Pinto el select de Tecnico IT 
                $.each(users['IT-T'],function(i,item){
                  $('#mtxtTecIT').append('<option value="'+item.id+'">'+item.nombre+'</option>');
                }); 
                // Pinto el select de Auxiliar IT 
                $.each(users['IT-A'],function(i,item){
                  $('#mtxtAuxIT').append('<option value="'+item.id+'">'+item.nombre+'</option>');
                });
                 // Pinto el select de Tecnico AA 
                $.each(users['AA-T'],function(i,item){
                  $('#mtxtTecAA').append('<option value="'+item.id+'">'+item.nombre+'</option>');
                }); 
                // Pinto el select de Auxiliar AA 
                $.each(users['AA-A'],function(i,item){
                  $('#mtxtAuxAA').append('<option value="'+item.id+'">'+item.nombre+'</option>');
                });

          });

            // $('#cboCiudad').change(function(){
            //   $('#cboCiudad option:selected').each(function(){
            //     var id = $('#cboCiudad').val();
            //     alert(id);
            //   });
            // });
        },




        //obtenemos los datos deseados con ajax
        getListPreventive: function () {
          //declaro ruta del controlador + metodo
          var url = "Mantenimientos/getEditarMP";
          $.ajax({
            //completo la url base + final
            url: baseurl + '/' + url,
            type: 'POST',
            //si es exitoso cambio los datos a JSON y le envio los datos para pintar la tabla
            success: function(response){
              var data = JSON.parse(response);
             vista.printTable(data);
            },
            //si existe un error al recibir los datos envio vacio al pintar la tabla
            error: function (e){
              console.error(e);
              vista.printTable([]);
            }
          });
        },
        // pintamos los datos a la tabla
        printTable: function(data){
          // Llamamos la tabla y le asignamos el datatable y le pasamos la configuracion para
          // datatable y l< data
           vista.tablePreventive = $('#tablePreventive').DataTable(vista.configTable(data, [

                    {title: "Ticket", data: "K_IDTICKET"},
                    {title: "PVD", data: "K_IDMAINTENANCE.K_IDPVD.K_IDPVD"},
                    {title: "Ciudad", data: "K_IDMAINTENANCE.K_IDPVD.K_IDCITY.N_NAME"},
                    {title: "Región", data: "K_IDMAINTENANCE.K_IDPVD.K_IDCITY.K_IDDEPARTMENT.K_IDREGION.N_NAME"},
                    {title: "Estado", data: vista.getStatus},//llamo una funcion para pintar este campo
                    {title: "Inicio_IT", data: "D_STARTDATEIT"},
                    {title: "Fin_IT", data: "D_FINISHDATEIT"},
                    {title: "Téc_IT", data: vista.getT_IT},
                    {title: "Aux_IT", data: vista.getA_IT},
                    {title: "Inicio_AA", data: "D_STARTDATEAA"},
                    {title: "Fin_AA", data: "D_FINISHDATEAA"},
                    {title: "Téc_AA", data: vista.getT_AA},
                    {title: "Aux_AA", data: vista.getA_AA},
                ]));
        },
        // Datos de configuracion del datatable
        configTable: function (data, columns, onDraw) {
            return {
              data: data,
              columns: columns,
              "language": {
                  "url": baseurl + "assets/plugins/datatables/lang/es.json"
              },
              columnDefs: [{
                      defaultContent: "",
                      targets: -1,
                      orderable: false,
                  }],
              order: [[0, 'asc']],
              drawCallback: onDraw
            }
        },
        // Funcion para calcular y pintar el estado
        getStatus: function(obj){
            // console.log(obj);
            var status = "";
            switch (obj.K_IDSTATUSTICKET) {
                case "1":
                   status = "Abierto";
                    break;
                case "2":
                   status = "En Progreso";
                    break;
                case "3":
                   status = "Cancelado";
                    break;
                case "4":
                   status = "En Espera Interventoria";
                    break;
                case "5":
                   status = "Ejecutado";
                    break;
                default:
                    status = "estado no definido";
            }

              return status + "<div style='width: 100%;height: 2px; background-color: #" +obj.N_COLOR + ";'></div>";
        },
        //buscamos tecnico it
        getT_IT: function(obj){
          var tecIT = "";
          if (obj.T_IT) {
            var firstName = obj.T_IT.K_IDUSER.N_NAME.split(" ");
            var firstLastname = obj.T_IT.K_IDUSER.N_LASTNAME.split(" ");
            tecIT = firstName[0] + " " + firstLastname[0];
          }
          return tecIT;
        },
        //buscamos Auxiliar it
        getA_IT: function(obj){
          var auxIT = "";
          if (obj.A_IT) {
            var firstName = obj.A_IT.K_IDUSER.N_NAME.split(" ");
            var firstLastname = obj.A_IT.K_IDUSER.N_LASTNAME.split(" ")
            auxIT = firstName[0] + " " + firstLastname[0];
          }
          return auxIT;
        },
        //buscamos Tecnico AA
        getT_AA: function(obj){
          var tecAA = "";
          if (obj.T_AA) {
            var firstName = obj.T_AA.K_IDUSER.N_NAME.split(" ");
            var firstLastname = obj.T_AA.K_IDUSER.N_LASTNAME.split(" ");
            tecAA = firstName[0] + " " + firstLastname[0];
          }
          return tecAA;
        },
        //buscamos Auxiliar AA
        getA_AA: function(obj){
          var auxAA = "";
          if (obj.A_AA) {
            var firstName = obj.A_AA.K_IDUSER.N_NAME.split(" ");
            var firstLastname = obj.A_AA.K_IDUSER.N_LASTNAME.split(" ");
            auxAA = firstName[0] + " " + firstLastname[0];
          }
          return auxAA;
        },

        onClickBotonActualizar: function(){
          /*********************Calculo la fecha actual*********************/
          var f = new Date();
          fechaActual = f.getFullYear() + "-" + (f.getMonth() +1) + "-" + f.getDate();
          /******************Traemos valores del formulario******************/
          var ticket = $ ('#mtxtTicket').val();
          var tecIT = $('#mtxtTecIT').val();           
          var auxIT = $('#mtxtAuxIT').val();            
          var iniIT = $ ('#mtxtIniIT').val();
          var finIT = $ ('#mtxtFinIT').val();

          // si la fecha viene 0000-00-00 la toma como vacia
          if (iniIT == "0000-00-00") {iniIT = ""}    
          if (finIT == "0000-00-00") {iniIT = ""}    

          var color = "";
          var iniMant = "";
          var finMant = "";
          var duracion = 0;

          var tecAA = $('#mtxtTecAA').val();            
          var auxAA = $('#mtxtAuxAA').val();
          var iniAA = $ ('#mtxtIniAA').val();
          var finAA = $ ('#mtxtFinAA').val();

          var estado = $ ('#mtxtEstado').val();
          var observacion = $ ('#mtxtObservaciones').val();

          // si la fecha viene 0000-00-00 la toma como vacia
          if (iniAA == "0000-00-00") {iniAA = ""}    
          if (finAA == "0000-00-00") {finAA = ""}

          /********************Calcular Fecha Inicio********************/
          // si las fechas son vacias inimant es vacio
          if (iniIT == "" && iniAA == "") {
            iniMant = "";  
          } 
          // si ambos son iguales inimant = a esa fecha
          else if (iniIT == iniAA) {
            iniMant = iniAA;
          }
          //si inicio it es menor que inicio AA inimant = inicio it
          else if(iniIT <  iniAA && iniIT != ""){
            iniMant = iniIT;
          }
          //si inicio AA es menor a inicio IT Ini mant = inicio AA
          else if(iniAA < iniIT && iniAA!= ""){
            iniMant = iniAA;
          }
          // si existe inicio AA e IT no, toma inicio AA
          else if(iniAA != "" && iniIT == ""){
            iniMant = iniAA;
          }
          // si existe inicio IT y AA no, toma inicio it
          else if (iniIT !="" && iniAA == "") {
            iniMant = iniIT;
          }

          /*********************Calcular fecha fin*********************/
          // Si fin IT es vacio y fin AA es vacio fin Mant es vacio
          if (finIT == "" && finAA == "") {
            finMant = "";  
          } 
          // si son iguales toma la fecha igual
          else if (finIT == finAA) {
            finMant = finAA;
          }
          // Si fin IT es mayor a fin AA fin Mant es igual a Fin IT
          else if(finIT > finAA && finAA != ""){
            finMant = finIT;
          }
          // Si fin AA es mayor a fin IT finMant = finAA
          else if(finAA > finIT && finIT != ""){
            finMant = finAA;
          }
          //Si existe fin aa pero no fin it... fin mant es vacio
          else if (finAA != "" && finIT == "") {
            finMant = "";
          }
          //Si existe fin it pero no fin AA... fin mant es vacio
          else if (finIT != "" && finAA == "") {
            finMant = "";
          }

          /****************Calcular duracion****************/
          //Si no hay inicio ni fin duracion es null
          if (iniMant == "" && finMant == "") {
            duracion = null;
          }
          //si fin mant es vacio se toma desde inimant a fecha actual
          else if(finMant == ""){
            duracion = vista.transcurrido(iniMant, fechaActual);
          }
          // Si inicio y fin mant tienen una fecha duracion = a los dias transcurridos entre esas fechas
          else if (finMant != "" && finMant != "") {
            duracion = vista.transcurrido(iniMant, finMant);
          }

          /******************calcular color*****************/
          switch (estado){
            case "1"://abierto
               color = "FFFFFF";
                break;
            case "2"://en progreso
               color = "00CC00";
                break;
            case "3"://cancelado
               color = "000000";
                break;
            case "4":
               // color = "En Espera Interventoria";
                break;
            case "5":// ejecutado
               color = "3399FF";
                break;
          }
          /************colores por duracion si está en progreso************/
          if (estado == 2) {
             if(duracion <=  2){
               color = "00CC00";
             }
             if(duracion > 2 && duracion <= 4){
               color = "FFFF00";
             }
             if(duracion > 4 && duracion <= 6){
               color = "660066";
             }
             if(duracion > 6){
               color = "FF0000";
             }
          }
          /************************para repintar al actualizar************************/
          var nameStatus = $("#mtxtEstado option:selected").html();
          var nameTIT = $("#mtxtTecIT option:selected").html();
          var nameAIT = $("#mtxtAuxIT option:selected").html();
          var nameTAA = $("#mtxtTecAA option:selected").html();
          var nameAAA = $("#mtxtAuxAA option:selected").html();
          var repaint = [nameStatus, color, iniIT, finIT, nameTIT, nameAIT, iniAA, finAA, nameTAA, nameAAA];


          /***************Envio los datos obtenidos por ajax al controlador para actualizar***************/
          // Ruta del controlador y funcion donde enviamos la peticion
          $.post(baseurl+"Mantenimientos/updateMantPreventivo", 
            //parametros que vamos a enviar por POST
             {
              mtxtTicket:ticket,
              mtxtEstado:estado,
              mtxtTecIT:tecIT,
              mtxtAuxIT:auxIT,
              mtxtIniIT:iniIT,
              mtxtFinIT:finIT,
              mtxtColor:color,
              mtxtDuracion:duracion,
              mtxtIniMant:iniMant,
              mtxtFinMant:finMant,
              mtxtTecAA:tecAA,
              mtxtAuxAA:auxAA,
              mtxtIniAA:iniAA,
              mtxtFinAA:finAA,
              mtxtObservaciones:observacion
             },
              //callback, metodo que va a recibir la respuesta del controlador   
              function(data){
                var respuesta = data;
                var title = 'El ticket ' + $ ('#mtxtTicket').val();
                var body = "";
                var image = "";
                  if (respuesta == 1) {
                    body = 'fue actualizado exitosamente!';
                    image = 'logoblue.png';
                    vista.painUpdate(repaint);
                    // location.reload();
                  } else {
                    body = 'NO PUDO ACTUALIZARSE!';
                    image = 'error.png';
                  }
                  $('#mbtnCerrarModal').click();
                  vista.showMessage(title, body, image);
              }

          );
        },

        // Funcion para calcular los dias transcurridos entre dos fechas
        transcurrido: function(f1,f2){
           f1 = f1.split('-').reverse().join('/');
           f2 = f2.split('-').reverse().join('/');

           var aFecha1 = f1.split('/');
           var aFecha2 = f2.split('/');
           var fFecha1 = Date.UTC(aFecha1[2],aFecha1[1]-1,aFecha1[0]);
           var fFecha2 = Date.UTC(aFecha2[2],aFecha2[1]-1,aFecha2[0]);
           var dif = fFecha2 - fFecha1;
           var dias = Math.floor(dif / (1000 * 60 * 60 * 24));
           return dias;
        },
        //funcion para mostrar mensaje 
        showMessage: function(title, body, image){
           Push.create( title, {
                      body: body,
                      icon: baseurl + 'assets/images/' + image,
                      timeout: 4000,
                      onClick: function () {
                          window.focus();
                          this.close();
                      }
           });

        },
        //pintar en la tabla despues de actualizar
        painUpdate: function(obj){
          // console.log(obj);
          vista.tr.find('td:eq(4)').html("<div style='color:blue;'>" + obj[0] + "</div><div style='width: 100%;height: 2px; background-color: #" +obj[1] + ";'></div>");
          vista.tr.find('td:eq(5)').html("<div style='color:blue;'>" + obj[2] + "</div>")       
          vista.tr.find('td:eq(6)').html("<div style='color:blue;'>" + obj[3] + "</div>")       
          vista.tr.find('td:eq(7)').html("<div style='color:blue;'>" + obj[4] + "</div>")       
          vista.tr.find('td:eq(8)').html("<div style='color:blue;'>" + obj[5] + "</div>")       
          vista.tr.find('td:eq(9)').html("<div style='color:blue;'>" + obj[6] + "</div>")       
          vista.tr.find('td:eq(10)').html("<div style='color:blue;'>" + obj[7] + "</div>")       
          vista.tr.find('td:eq(11)').html("<div style='color:blue;'>" + obj[8] + "</div>")       
          vista.tr.find('td:eq(12)').html("<div style='color:blue;'>" + obj[9] + "</div>")       
        },

        onClickVerActividadTr: function(){
            var aLink = $(this);
            var trParent = aLink.parents('tr');
            var record = vista.tablePreventive.row(trParent).data();
            modalEditar(record, record.id, $('#session_id').val(), $('#session_role').val());
        },
        onClickVerActividadGd: function(){
            var aLink = $(this);
            var trParent = aLink.parents('tr');
            var record = vista.tableGDATOS.row(trParent).data();
            modalEditar(record, record.id, $('#session_id').val(), $('#session_role').val());
        },
        onClickTabTables: function () {
            var tab = $(this);
            var path = tab.attr('href');
            sessionStorage.setItem('path_tab_tables', path);
        },
        onClickPreviewBtn: function () {
            var btn = $(this);
            var tr = btn.parents('tr');
            var table = vista[btn.attr('data-table')];
            if (!table) {
                return;
            }
            var record = table.row(tr).data();
            // console.log(tr, record);
            $('#formDetallesBasicos').fillForm(record);
            $('#modalPreview').modal('show');
        },
        // //Temporalmente...
        fillNA: function () {
            return "N/A";
        },       
    };

    vista.init();
});
