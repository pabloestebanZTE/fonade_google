<!DOCTYPE html>
<html lang="en">
<head>
<title>Detalles Mantenimiento Preventivo</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<link rel="icon" href="http://cellaron.com/media/wysiwyg/zte-mwc-2015-8-l-124x124.png">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/mainModalWindow2.css" type="text/css" media="all">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/reset.css" type="text/css" media="all">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/layout.css" type="text/css" media="all">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css" type="text/css" media="all">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/chunkyButtons.css" type="text/css" media="all">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/zerogrid.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/responsive.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/wheelmenu.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/index.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/sweetalert/dist/sweetalert.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/tablesInventory.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/multiTable.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/animate.css/3.2.0/animate.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Oleo+Script:400,700" >
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Teko:400,700">
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-1.6.js" ></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/cufon-yui.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/cufon-replace.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/Swis721_Cn_BT_400.font.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/Swis721_Cn_BT_700.font.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/tms-0.3.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/tms_presets.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jcarousellite.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/script.js"></script>
<script src="<?php echo base_url(); ?>assets/js/css3-mediaqueries.js"></script>
<script src="<?php echo base_url(); ?>assets/js/responsiveslides.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/tabs.js"></script>
<script src="<?php echo base_url(); ?>assets/css/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.wheelmenu.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/css/canvasJS/canvasjs.min.js"></script>


<script>
var newElementQuantityCCC = "<?php echo count($CCC); ?>";
var newElementQuantity = 0;
var equipmentType;
var inventory;
var category;
var checklist;
var zones;
var nameZonesG;
var idZonesG;

    function showMessage(){
        var a = "<?php echo $msj[0]; ?>";
        var b = "<?php echo $msj[1]; ?>";
        var c = "<?php echo $msj[2]; ?>";
        sweetAlert(a, b, c);
    }

    function deleteElement(idInv){
        swal({
          title: "¿Esta segur@?",
          text: "Si elimina un elemento no se puede recuperar",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Si, eliminar",
          cancelButtonText: "Cancelar",
          closeOnConfirm: false
        },
        function(){
          window.location.href="<?php echo base_url(); ?>Equipment/deleteElement?k_fase=<?php echo $PVD->getFase() ?>&k_tipo=<?php echo $PVD->getTipologia() ?>&k_pvd=<?php echo $PVD->getID() ?>&k_ticket=<?php echo $ticket ?>&k_element="+idInv;
        });
      }



    function showModalSoftware(inventario){
      $('#modalSFT').modal('show');
    }

    function showModalCCC(){
      $('#modalCCC').modal('show');
    }

    function showModal(idEquipo, inventario, name, categorias, rutina){
      newElementQuantity = 0;
    //  console.log(idEquipo);
    //  console.log(inventario);
      //console.log(name);
  //    console.log(categorias);
      checklist = rutina;
      equipmentType = idEquipo;
      inventory = inventario;
      category = categorias;
      $('#chk').remove();
      $('#inventory').remove();
      $('#corrective').remove();
      $('#NE').remove();

      console.log("o.o");
      nameZones = ""+"<?php
         for($i=0;$i<count($PVD->getZones());$i++){
           echo $PVD->getZones()[$i]['N_NAME'];
           echo "@";
         }
        ?>";
      idZones = ""+"<?php
         for($i=0;$i<count($PVD->getZones());$i++){
           echo $PVD->getZones()[$i]['K_IDPVDZONE'];
           echo "-";
         }
        ?>";

        nameZonesG = nameZones = nameZones.split("@");
        idZonesG = idZones = idZones.split("-");

        $selectZones = "";
        for(var i = 0; i < idZones.length -1; i++){
          $selectZones = $selectZones+"<option value='"+idZones[i]+"'>"+nameZones[i]+"</option>";
        }
        zones = $selectZones

      $('#tableInventory').append("<tbody id='inventory' name='inventory'></tbody>");
      $('#tableCorrective').append("<tbody id='corrective' name='corrective'></tbody>");
      $('#tableNE').append("<tbody id='NE' name='NE'></tbody>");

      if(inventario != "NI"){
        for(var i = 0; i<inventario.length; i++){
          for (var j = 0; j<categorias.length; j++){
            if (categorias[j].K_IDSTUFF_CATEGORY == inventario[i].K_IDSTUFF_CATEGORY){
              var elemento =  "<td>"+categorias[j].N_NAME+"</td>";
              for(k = 0; k<categorias[j].model.length; k++){
                if(categorias[j].model[k].K_IDMODEL == inventario[i].K_IDMODEL){
                  var modelo =  "<td>"+categorias[j].model[k].N_NAME+"</td>";
                  var marca =  "<td>"+categorias[j].model[k].K_IDMANUFACTURER.N_NAME+"</td>";
                }
              }
            }
          }
        //  var deleteRB = "<td>"+"<div class'[ form-group ]'><input type='checkbox' name='fancy-checkbox-primary' id='fancy-checkbox-primary' autocomplete='off' /><div class='[ btn-group ]'><label for='fancy-checkbox-primary' class='[ btn btn-primary ]'><span class='[ glyphicon glyphicon-ok ]'></span><span> </span></label><label for='fancy-checkbox-primary' class='[ btn btn-default active ]'>Delete</label></div></div>"+"</td>";
          var deleteRB = "<td><a href='javascript:deleteElement("+inventario[i].K_IDSTUFF+")'><span class='glyphicon glyphicon-remove-circle'></span></a></td>";
          var serial =  "<td><input name='fieldName"+newElementQuantity+"' value='"+inventario[i].N_SERIAL+"'></td>";
          var placa =  "<td><input name='fieldPlaca"+newElementQuantity+"' value='"+inventario[i].N_PLACAINVENTARIO+"'></td>";
          var parte =  "<td><input name='fieldParte"+newElementQuantity+"' value='"+inventario[i].N_PARTE+"'></td>";

          var zone = "<td><select onchange='cambiarURL("+newElementQuantity+")' style='font-size:10px' name='selectZones"+newElementQuantity+"' id='selectZones"+newElementQuantity+"' aria-describedby='basic-addon1'>";
          zone = zone + "<option value='-1'>"+inventario[i].K_IDPVD_PLACE.N_NAME+"</option>";
          zone = zone+zones;
          zone = zone+"</select></td>";
          var id = "<td hidden><input id='idElement"+newElementQuantity+"' name='idElement"+newElementQuantity+"' value='"+inventario[i].K_IDSTUFF+"'></td>";

          if(inventario[i].N_NAME != null) {
            var observaciones = "<td id='tdta"+newElementQuantity+"'><textarea name='observaciones"+newElementQuantity+"' id='observaciones"+newElementQuantity+"' style='font-size:10px' type='text' aria-describedby='basic-addon1'  placeholder='Descripción de la falla *' >"+inventario[i].N_NAME+"</textarea></td>";
          } else {
            var observaciones = "<td id='tdta"+newElementQuantity+"'><textarea name='observaciones"+newElementQuantity+"' id='observaciones"+newElementQuantity+"' style='font-size:10px' type='text' aria-describedby='basic-addon1'  placeholder='Observaciones *' ></textarea></td>";
          }

          if(inventario[i].Q_PROGRESS == "0"){
            var finalizado = "<td><select style='font-size:10px' name='selectFinalizado"+newElementQuantity+"' id='selectFinalizado"+newElementQuantity+"' aria-describedby='basic-addon1'>";
            finalizado = finalizado+"<option value='0'>No</option><option value='1'>Si</option>";
            finalizado = finalizado+"</select></td>";
          } else {
            var finalizado = "<td><select style='font-size:10px' name='selectFinalizado"+newElementQuantity+"' id='selectFinalizado"+newElementQuantity+"' aria-describedby='basic-addon1'>";
            finalizado = finalizado+"<option value='1'>Si</option><option value='0'>No</option>";
            finalizado = finalizado+"</select></td>";
          }

          if (inventario[i].N_ESTADO == "Funcional"){
            var fotos = "<td><a id='fotos"+newElementQuantity+"' name='fotos"+newElementQuantity+"' class='push_button blue' role='button' href='"+inventario[i].url+"' target='_blank'>Ver</a></td>";
            var estados = "<td><select onchange='cambioTabla("+newElementQuantity+")' style='font-size:10px' name='selectEstados"+newElementQuantity+"' id='selectEstados"+newElementQuantity+"' aria-describedby='basic-addon1'>";
            estados = estados+"<option value='Funcional'>Funcional</option><option value='Averiado'>Averiado</option><option value='No encontrado'>No encontrado</option>";
            estados = estados+"</select></td>";
            $('#inventory').append( "<tr id='linea"+newElementQuantity+"' name='linea"+newElementQuantity+"'>"+deleteRB+elemento+marca+modelo+serial+placa+parte+zone+estados+fotos+finalizado+id+observaciones+"</tr>" );
          }
          if (inventario[i].N_ESTADO == "No encontrado"){
            var fotos = "<td><a id='fotos"+newElementQuantity+"' name='fotos"+newElementQuantity+"' class='push_button blue' role='button' href='"+inventario[i].url+"' target='_blank'>Ver</a></td>";
            var estados = "<td><select onchange='cambioTabla("+newElementQuantity+")' style='font-size:10px' name='selectEstados"+newElementQuantity+"' id='selectEstados"+newElementQuantity+"' aria-describedby='basic-addon1'>";
            estados = estados+"<option value='No encontrado'>No encontrado</option><option value='Funcional'>Funcional</option><option value='Averiado'>Averiado</option>";
            estados = estados+"</select></td>";
            $('#NE').append( "<tr id='linea"+newElementQuantity+"' name='linea"+newElementQuantity+"'>"+deleteRB+elemento+marca+modelo+serial+placa+parte+zone+estados+fotos+finalizado+observaciones+id+"</tr>" );
            var selectEstado = document.getElementById("selectFinalizado"+newElementQuantity);
            selectEstado.style.display = 'none';
          }
          if (inventario[i].N_ESTADO == "Averiado"){
            console.log(inventario[i]);
            var newURL = inventario[i].url.split("Registro");
            inventario[i].url = newURL[0]+"Registro Fotografico Correctivos/?region=us-west-2&tab=overview";
            var fotos = "<td><a id='fotos"+newElementQuantity+"' name='fotos"+newElementQuantity+"' class='push_button blue' role='button' href='"+inventario[i].url+"' target='_blank'>Ver</a></td>";
            var newRow = "<tr id='newRow"+newElementQuantity+"' name='newRow"+newElementQuantity+"'>";
            newRow = newRow+"<td hidden><input id='idCM"+newElementQuantity+"' name='idCM"+newElementQuantity+"' value='"+inventario[i].corrective.K_IDTICKET_CORRECTIVE+"' ></td>";
            newRow = newRow+"<td>Elementos averiados:<textarea name='equiposAveriados"+newElementQuantity+"' id='equiposAveriados"+newElementQuantity+"' style='font-size:10px' type='text' aria-describedby='basic-addon1'  placeholder='Lista de equipos averiados *' required>"+inventario[i].corrective.N_DAMAGED_ELEMENTS+"</textarea></td>";
            newRow = newRow+"<td>Referencias elementos:<textarea name='referenciaEquiposAveriados"+newElementQuantity+"' id='referenciaEquiposAveriados"+newElementQuantity+"' style='font-size:10px' type='text' aria-describedby='basic-addon1'  placeholder='Referencias de equipos averiados *' required>"+inventario[i].corrective.N_REFERENCE_D_ELEMENTS+"</textarea></td>";
            newRow = newRow+"<td>Descripción de la falla:<textarea name='descripcionFalla"+newElementQuantity+"' id='descripcionFalla"+newElementQuantity+"' style='font-size:10px' type='text' aria-describedby='basic-addon1'  placeholder='Descripción de la falla *' required>"+inventario[i].corrective.N_FAILURE_DESCRIPTION+"</textarea></td>";
            newRow = newRow+"<td>Pruebas realizadas: <textarea name='pruebas"+newElementQuantity+"' id='pruebas"+newElementQuantity+"' style='font-size:10px' type='text' aria-describedby='basic-addon1'  placeholder='Pruebas realizadas (por favor explicar los detalles) *' required>"+inventario[i].corrective.N_TEST+"</textarea></td>";
            newRow = newRow+"<td>Elementos necesarios:<textarea name='elementos"+newElementQuantity+"' id='elementos"+newElementQuantity+"' style='font-size:10px' type='text' aria-describedby='basic-addon1'  placeholder='Elementos necesarios para solucionar la falla (Listar TODOS los elementos) *' required>"+inventario[i].corrective.N_NEW_ELEMENTS+"</textarea></td>";
            newRow = newRow+"<td></td><td><p>Tipo de falla: "+inventario[i].corrective.N_FAILURE_CLASSIFICATION+"</p></td>";
            newRow = newRow+"<td>Ticket CCC:<input  name='cccTicket"+newElementQuantity+"' id='cccTicket"+newElementQuantity+"' style='font-size:10px' type='text' aria-describedby='basic-addon1'  placeholder='Ticket CCC *' value='"+inventario[i].corrective.N_CCC+"'></td><td></td><td></td>";
            newRow = newRow+"</tr>";
            var estados = "<td><select onchange='cambioTabla("+newElementQuantity+")' style='font-size:10px' name='selectEstados"+newElementQuantity+"' id='selectEstados"+newElementQuantity+"' aria-describedby='basic-addon1'>";
            estados = estados+"<option value='Averiado'>Averiado</option><option value='Funcional'>Funcional</option><option value='No encontrado'>No encontrado</option>";
            estados = estados+"</select></td>";
            $('#corrective').append("<tr id='linea"+newElementQuantity+"' name='linea"+newElementQuantity+"'>"+deleteRB+elemento+marca+modelo+serial+placa+parte+zone+estados+fotos+finalizado+observaciones+id+"</tr>" );
            $('#corrective').append(newRow);

            var selectEstado = document.getElementById("selectFinalizado"+newElementQuantity);
            selectEstado.style.display = 'none';
            var selectEstado = document.getElementById("tdta"+newElementQuantity);
            selectEstado.style.display = 'none';

          }
          newElementQuantity++;
        }
      }
      $("#Elements").val(newElementQuantity);

      $('#todo-list').empty();
      var check = "";
      for (var i = 0; i < checklist.length; i++){
        check = check + "<span class='todo-wrap'><input type='checkbox' id='"+i+"'/><label for='"+i+"' class='todo'><i class='fa fa-check'></i>"+checklist[i].K_IDITEM_CHECKLIST.N_NAME+"</label></span>";
      }
      $('#todo-list').append(check);
      avance = "<?php echo $avance ?>";
      if (avance > 60){
        for (var i = 0; i < checklist.length; i++){
          document.getElementById(""+i).checked = true;
        }
      }
      $('#modal-02').modal('show');
    }

    function cambiarSelectMarca(equipo_categoria){
      var equipo = $("#selectElement"+equipo_categoria+" option:selected").attr('value');
      for(var i = 0;i <category.length; i++){
        if(category[i].K_IDSTUFF_CATEGORY == equipo){
          var manufacturersTotal = [];
          for(var j = 0; j< category[i].model.length; j++){
            manufacturersTotal[j] = category[i].model[j].K_IDMANUFACTURER;
          }
          unique = [...new Set(manufacturersTotal.map(a => a.K_IDMANUFACTURER))];
          unique2 = [...new Set(manufacturersTotal.map(a => a.N_NAME))];
          var manufacturers = "";
          for(var j = 0; j< unique2.length; j++){
            manufacturers = manufacturers+"<option value='"+unique[j]+"'>"+unique2[j]+"</option>";
          }

          var models = "";
          for(var j = 0; j < category[i].model.length; j++){
            if(category[i].model[j].K_IDMANUFACTURER.K_IDMANUFACTURER == unique[0]){
              models = models+"<option value='"+category[i].model[j].K_IDMODEL+"'>"+category[i].model[j].N_NAME+"</option>";
            }
          }
        }
        $("#selectMarca"+equipo_categoria).empty();
        $("#selectModelo"+equipo_categoria).empty();
        $("#selectMarca"+equipo_categoria).append(manufacturers);
        $("#selectModelo"+equipo_categoria).append(models);
      }
    }

    function cambiarSelectModelo(equipo_categoria){
      var equipo = $("#selectElement"+equipo_categoria+" option:selected").attr('value');
      var marca = $("#selectMarca"+equipo_categoria+" option:selected").attr('value');
      var models = "";
      for(var i = 0; i<category.length;i++){
        if(category[i].K_IDSTUFF_CATEGORY == equipo){
          for(var j = 0; j<category[i].model.length; j++){
            if(category[i].model[j].K_IDMANUFACTURER.K_IDMANUFACTURER == marca){
              models = models+"<option value='"+category[i].model[j].K_IDMODEL+"'>"+category[i].model[j].N_NAME+"</option>";
            }
          }
        }
      }
      $("#selectModelo"+equipo_categoria).empty();
      $("#selectModelo"+equipo_categoria).append(models);
    }

    function cambiarURL(equipo_categoria){
      var e = document.getElementById("selectZones"+equipo_categoria);
      var index = e.options[e.selectedIndex].value;
      var newIndex;
      for(var i = 0; i < idZonesG.length; i++){
        if(idZonesG[i] == index){
          newIndex = i;
        }
      }
      var href = document.getElementById("fotos"+equipo_categoria).getAttribute("href");
      href = href.split("/");
      href = href[0] +"/"+ href[1] +"/"+ href[2] +"/"+ href[3] +"/"+ href[4] +"/"+ href[5] +"/"+ href[6] +"/"+nameZonesG[newIndex]+"/"+href[9];
      console.log(href);
      document.getElementById("fotos"+equipo_categoria).href = href;
    }

    function cambioTabla(equipo_categoria){
      var estado = $("#selectEstados"+equipo_categoria+" option:selected").attr('value');
      var linea = document.getElementById("linea"+equipo_categoria);
      try {
          var tdta = document.getElementById("tdta"+equipo_categoria);
      }
      catch(err) {
      }
      var selectEstado = document.getElementById("selectFinalizado"+equipo_categoria);
      if(estado == "Averiado"){
        tdta.style.display = 'none';
        selectEstado.style.display = 'none';
        var href = document.getElementById("fotos"+equipo_categoria).getAttribute("href");
        var newURL = href.split("Registro");
        href = newURL[0]+"Registro Fotografico Correctivos/?region=us-west-2&tab=overview";
        document.getElementById("fotos"+equipo_categoria).href = href;
        var newRow = "<tr id='newRow"+equipo_categoria+"' name='newRow"+equipo_categoria+"'>";
        newRow = newRow+"<td><textarea name='equiposAveriados"+equipo_categoria+"' id='equiposAveriados"+equipo_categoria+"' style='font-size:10px' type='text' aria-describedby='basic-addon1'  placeholder='Lista de equipos averiados *' required></textarea></td>";
        newRow = newRow+"<td><textarea name='referenciaEquiposAveriados"+equipo_categoria+"' id='referenciaEquiposAveriados"+equipo_categoria+"' style='font-size:10px' type='text' aria-describedby='basic-addon1'  placeholder='Referencias de equipos averiados *' required></textarea></td>";
        newRow = newRow+"<td><textarea name='descripcionFalla"+equipo_categoria+"' id='descripcionFalla"+equipo_categoria+"' style='font-size:10px' type='text' aria-describedby='basic-addon1'  placeholder='Descripción de la falla *' required></textarea></td>";
        newRow = newRow+"<td><textarea name='pruebas"+equipo_categoria+"' id='pruebas"+equipo_categoria+"' style='font-size:10px' type='text' aria-describedby='basic-addon1'  placeholder='Pruebas realizadas (por favor explicar los detalles) *' required></textarea></td>";
        newRow = newRow+"<td><textarea name='elementos"+equipo_categoria+"' id='elementos"+equipo_categoria+"' style='font-size:10px' type='text' aria-describedby='basic-addon1'  placeholder='Elementos necesarios para solucionar la falla (Listar TODOS los elementos) *' required></textarea></td>";
        newRow = newRow+"<td></td><td><select name='selectFalla"+equipo_categoria+"' id='selectFalla"+equipo_categoria+"'><option value'Daño por uso'>Por uso</option><option value'Daño por mal uso'>Por mal uso</option><option value'Daño por falta de mantenimiento'>Por falta de mto.</option><option value'Daño por falla eléctrica'>Por falla eléctrica</option><option value'Otras Causas'>Otras causas</option></select></td>";
        newRow = newRow+"<td><input name='cccTicket"+equipo_categoria+"' id='cccTicket"+equipo_categoria+"' style='font-size:10px' type='text' aria-describedby='basic-addon1'  placeholder='Ticket CCC *' ></td><td></td><td></td></tr>";
        $("#tableCorrective").append(linea);
        $("#tableCorrective").append(newRow);
      }
      if(estado == "Funcional"){
        tdta.style.display = 'block';
        selectEstado.style.display = 'block';
        $("#newRow"+equipo_categoria).remove();
        $("#tableInventory").append(linea);
      }
      if(estado == "No encontrado"){
        tdta.style.display = 'block';
        selectEstado.style.display = 'none';
        $("#newRow"+equipo_categoria).remove();
        $("#tableNE").append(linea);
      }
    }

    function showActaIT(){
      var form = document.getElementById("formActaIT");
      form.style.display = 'block';
    }

    function showActaAA(){
      var form = document.getElementById("formActaAA");
      form.style.display = 'block';
    }

    function añadirElemento(){
      var deleteE = "<td></td>";
      var options = "<td><select onchange='cambiarSelectMarca("+newElementQuantity+")' style='font-size:10px' name='selectElement"+newElementQuantity+"' id='selectElement"+newElementQuantity+"' aria-describedby='basic-addon1'>";
      for(var i = 0; i < category.length; i++){
        options = options+"<option value='"+category[i].K_IDSTUFF_CATEGORY+"'>"+category[i].N_NAME+"</option>";
      }
      options = options + "</select></td>";

      var manufacturersTotal = [];
      for(var i = 0; i< category[0].model.length; i++){
        manufacturersTotal[i] = category[0].model[i].K_IDMANUFACTURER;
      }
      unique = [...new Set(manufacturersTotal.map(a => a.K_IDMANUFACTURER))];
      unique2 = [...new Set(manufacturersTotal.map(a => a.N_NAME))];
      var manufacturers = "<td><select onchange='cambiarSelectModelo("+newElementQuantity+")' style='font-size:10px' name='selectMarca"+newElementQuantity+"' id='selectMarca"+newElementQuantity+"' aria-describedby='basic-addon1'>";
      for(var i = 0; i< unique2.length; i++){
        manufacturers = manufacturers+"<option value='"+unique[i]+"'>"+unique2[i]+"</option>";
      }
      manufacturers = manufacturers + "</select></td>";

      var models = "<td><select style='font-size:10px' name='selectModelo"+newElementQuantity+"' id='selectModelo"+newElementQuantity+"' aria-describedby='basic-addon1'>";
      for(var i = 0; i < category[0].model.length; i++){
        if(category[0].model[i].K_IDMANUFACTURER.K_IDMANUFACTURER == unique[0]){
          models = models+"<option value='"+category[0].model[i].K_IDMODEL+"'>"+category[0].model[i].N_NAME+"</option>";
        }
      }
      models = models + "</select></td>";

      var fieldName = "<td><input name='fieldName"+newElementQuantity+"' id='fieldName"+newElementQuantity+"' style='font-size:10px' type='text' aria-describedby='basic-addon1'></td>";
      var fieldPlaca = "<td><input name='fieldPlaca"+newElementQuantity+"' id='fieldPlaca"+newElementQuantity+"' style='font-size:10px' type='text' aria-describedby='basic-addon1'></td>";
      var fieldParte = "<td><input name='fieldParte"+newElementQuantity+"' id='fieldParte"+newElementQuantity+"' style='font-size:10px' type='text' aria-describedby='basic-addon1'></td>";
      var region = "<?php echo $PVD->getRegion();?>";
      if (region == "Zona 1"){
        var href = "https://drive.google.com/drive/folders/0BxX2l5kpb3SaZGNJT0E4OTY0Rjg";
      } else {
        var href = "https://drive.google.com/drive/folders/0BxX2l5kpb3SabFduRW1hMFhyWDQ";
      }
      var fotos = "<td><a id='fotos"+newElementQuantity+"' name='fotos"+newElementQuantity+"' class='push_button blue' href='"+href+"' target='_blank'>Ver</a></td>";

      var zonaE = "<td><select onchange='cambiarURL("+newElementQuantity+")' style='font-size:10px' name='selectZones"+newElementQuantity+"' id='selectZones"+newElementQuantity+"' aria-describedby='basic-addon1'>";
      zonaE = zonaE+zones;
      zonaE = zonaE+"</select></td>";

      var estados = "<td><select onchange='cambioTabla("+newElementQuantity+")' style='font-size:10px' name='selectEstados"+newElementQuantity+"' id='selectEstados"+newElementQuantity+"' aria-describedby='basic-addon1'>";
      estados = estados+"<option value='Funcional'>Funcional</option><option value='Averiado'>Averiado</option><option value='No encontrado'>No encontrado</option>";
      estados = estados+"</select></td>";

      var finalizado = "<td><select style='font-size:10px' name='selectFinalizado"+newElementQuantity+"' id='selectFinalizado"+newElementQuantity+"' aria-describedby='basic-addon1'>";
      finalizado = finalizado+"<option value='0'>No</option><option value='1'>Si</option>";
      finalizado = finalizado+"</select></td>";

      var observacion = "<td id='tdta"+newElementQuantity+"'><textarea name='observaciones"+newElementQuantity+"' id='observaciones"+newElementQuantity+"' style='font-size:10px' type='text' aria-describedby='basic-addon1'  ></textarea></td>";
      $('#inventory').append( "<tr id='linea"+newElementQuantity+"' name='linea"+newElementQuantity+"'>"+deleteE+options+manufacturers+models+fieldName+fieldPlaca+fieldParte+zonaE+estados+fotos+finalizado+observacion+"</tr>" );
      newElementQuantity++;
      $("#Elements").val(newElementQuantity);
    }

    function añadirElementoCCC(){
      var idTicket = "<td><input name='idCCC"+newElementQuantityCCC+"' id='idCCC"+newElementQuantityCCC+"' style='font-size:10px' type='text' aria-describedby='basic-addon1' required></td>";
      var tipo = "<td><select  style='font-size:10px' name='selectTipo"+newElementQuantityCCC+"' id='selectTipo"+newElementQuantityCCC+"' aria-describedby='basic-addon1'>";
      tipo = tipo + "<option value='IT'>IT</option><option value='AA'>AA</option>";
      tipo = tipo + "</select></td>";
      desc = "<td><textarea name='desc"+newElementQuantityCCC+"' id='desc"+newElementQuantityCCC+"' style='font-size:10px' type='text' aria-describedby='basic-addon1'  required></textarea></td>";
      var Estado = "<td><select  style='font-size:10px' name='select"+newElementQuantityCCC+"' id='select"+newElementQuantityCCC+"' aria-describedby='basic-addon1'>";
      Estado = Estado + "<option value='Abierto'>Abierto</option><option value='En Correctivo'>En Correctivo</option><option value='Solucionado'>Solucionado</option>";
      Estado = Estado + "</select></td>";
      obs = "<td><textarea name='observciones"+newElementQuantityCCC+"' id='observciones"+newElementQuantityCCC+"' style='font-size:10px' type='text' aria-describedby='basic-addon1' ></textarea></td>";

      $('#tableCCC').append( "<tr id='lineaCCC"+newElementQuantityCCC+"' name='lineaCCC"+newElementQuantityCCC+"'>"+idTicket+tipo+desc+Estado+obs+"</tr>" );
      newElementQuantityCCC++;
    }
</script>
<script type="text/javascript">
$(window).on('load', function() {
	var chart = new CanvasJS.Chart("chartContainer",
	{
		title:{
			text: " Porcentaje de avance del mantenimiento"
		},
                animationEnabled: true,
		data: [
		{
			type: "doughnut",
			startAngle: 60,
			toolTipContent: "{legendText}: {y} - <strong>#percent% </strong>",
			showInLegend: true,
			dataPoints: [
				{y: <?php echo $avance ?>, indexLabel: "Avance #percent%", legendText: "Trabajo realizado" },
				{y: <?php echo 100 - $avance ?>, indexLabel: "Restante #percent%", legendText: "Trabajo Faltante" }
  		]
		}
		]
	});
	chart.render();
});
</script>
</head>
<body id="page1">
<div class="body1">
	<div class="body2">
  <div class="body5">
		<div class="main zerogrid">
<!-- header -->
			<header>
				<div class="wrapper row">
				<h1><a id="logo"><img src="<?php echo base_url(); ?>assets/images/logo.png" /></a></h1>
				<nav>
					<ul id="menu">
          	<?php
							if ($_SESSION['permissions'] != NULL){
                echo "<li id='nav1'><a href='".base_url()."User/loadPrincipalView'>Bienvenid@<span>".$_SESSION['name']."</span></a></li>";
								if($_SESSION['permissions'][3] == 1){
									echo "<li id='nav3'><a href='#'>PVD<span>HV</span></a></li>";
								}
								if($_SESSION['permissions'][1] == 1){
									echo "<li id='nav4'><a href='".base_url()."Mantenimientos/loadMPView'>Preventivos<span>Mantenimientos</span></a></li>";
								}
								if($_SESSION['permissions'][2] == 1){
									echo "<li id='nav4'><a href='".base_url()."MCorrectivos/formMC'>Correctivos<span>Mantenimientos</span></a></li>";
								}
								if($_SESSION['permissions'][4] == 1){
                  echo "<li id='nav2'><a href='http://legalizaciones.us-west-2.elasticbeanstalk.com/?usuarioAdmin=".$_SESSION['id']."&passAdmin=".$_SESSION['pass']."'>legalizaciones<span>legalizaciones</span></a></li>";
                }
								if($_SESSION['permissions'][5] == 1){
                  echo "<li id='nav5'><a href='".base_url()."ZTEPlatform/platformZTE'>ZTE<span>Plataforma</span></a></li>";
								}
							}
            ?>
						<li id="nav6"><a href="<?php echo base_url(); ?>welcome/index">Salir<span>Logout</span></a></li>
					</ul>
				</nav>
				</div>
			</header>
<!-- header end-->
    </div>
		</div>
	</div>
</div>
	<div class="body3">
<!-- content -->
			<article id="content">
        <?php
        echo "<div id='pricing-table' class='clear'>";
          echo "<center>";
                echo "<div class='plan' id='most-popular'>";
                    echo "<h3>Información General<span><img src='".base_url()."assets/images/pvd.png'/></span></h3>";
                    echo "<ul>";
                        echo "<li><b>Ticket: </b>".$ticket."</li>";
                        echo "<li><b>ID: </b>".$PVD->getId()."</li>";
                        echo "<li><b>Región: </b>".$PVD->getRegion()."</li>";
                        echo "<li><b>Departamento: </b>".$PVD->getDepartment()."</li>";
                        echo "<li><b>Ciudad: </b>".$PVD->getCity()."</li>";
                        echo "<li><b>Dirección: </b>".$PVD->getDireccion()."</li>";
                        echo "<li><b>Tipologia: </b>".$PVD->getTipologia()."</li>";
                        echo "<li><b>Fase: </b>".$PVD->getFase()."</li>";
                    echo "</ul>";
                echo "</div>";
                echo "<div id='chartContainer' style='height: 400px; width: 50%;'></div>";
              echo "</div>";

          echo "</center>";
         ?>
          <?php
          echo "<center><div class='btn-group'>";
            if(isset($software)){
              echo "<a class='btn btn-success btn-sm' onclick='showModalSoftware(".json_encode($software).")'>Inventario de Software</a>";
            }
            if($_SESSION['id'] != 314618 && $_SESSION['id'] != 314619){
                echo "<a class='btn btn-success btn-sm' onclick='showModalCCC()'>Tickets CCC</a>";
            }
            if ($PVD->getRegion() == "Zona 1"){
              echo "<a class='btn btn-primary btn-sm' target='_blank' href='https://drive.google.com/drive/folders/0BxX2l5kpb3SaZGNJT0E4OTY0Rjg'>Videos AA </a>";
              echo "<a class='btn btn-primary btn-sm' target='_blank' href='https://drive.google.com/drive/folders/0BxX2l5kpb3SaZGNJT0E4OTY0Rjg'>Videos IT </a>";
            }
            if ($PVD->getRegion() == "Zona 4"){
              echo "<a class='btn btn-primary btn-sm' target='_blank' href='https://drive.google.com/drive/folders/0BxX2l5kpb3SabFduRW1hMFhyWDQ'>Videos AA </a>";
              echo "<a class='btn btn-primary btn-sm' target='_blank' href='https://drive.google.com/drive/folders/0BxX2l5kpb3SabFduRW1hMFhyWDQ'>Videos IT </a>";
            }

          if($_SESSION['id'] != 314618 && $_SESSION['id'] != 314619){
              echo "<a class='btn btn-primary btn-sm' role='button' onclick='showActaIT()'> Generar Acta IT</a>";
              echo "<a class='btn btn-primary btn-sm' role='button' onclick='showActaAA()'> Generar Acta AA</a>";
            }
            echo "</div></center><br><br><br>";
            echo "<center><div class='btn-group'>";
              echo "<a class='btn btn-primary btn-sm' target='_blank' href='".base_url()."PDF/exportInventoryExcel?k_fase=".$PVD->getFase()."&k_tipo=".$PVD->getTipologia()."&k_pvd=".$PVD->getID()."&k_ticket=".$ticket."' >Exportar Inventario</a>";
              echo "<a class='btn btn-primary btn-sm' target='_blank' href='".base_url()."PDF/createFacturationReport?k_fase=".$PVD->getFase()."&k_tipo=".$PVD->getTipologia()."&k_pvd=".$PVD->getID()."&k_ticket=".$ticket."' >Generar Acta Facturacion</a>";
              if ($PVD->getRegion() == "Zona 1"){
                echo "<a class='btn btn-primary btn-sm' target='_blank' href='https://drive.google.com/drive/folders/0BxX2l5kpb3SaZGNJT0E4OTY0Rjg'>Acta</a>";
              }
              if ($PVD->getRegion() == "Zona 4"){
                echo "<a class='btn btn-primary btn-sm' target='_blank' href='https://drive.google.com/drive/folders/0BxX2l5kpb3SabFduRW1hMFhyWDQ'>Acta</a>";
              }
            echo "</div></center><br><br><br>";



          echo "<div id='formActaIT' name='formActaIT' hidden>";
            echo "<form method='post' name='form1'>";
              echo "<table class='container'>";
                echo "<thead>";
                  echo "<tr>";
                    echo "<th><h1>Nombre Admin</h1></th>";
                    echo "<th><h1>Correo Admin</h1></th>";
                    echo "<th><h1>Cedula Admin</h1></th>";
                    echo "<th><h1>Ciudad de Expedición</h1></th>";
                    echo "<th><h1>Télefono Admin</h1></th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                  echo "<tr>";
                    echo "<td><input id='nombreAdmin' name='nombreAdmin' style='font-size:10px' type='text' aria-describedby='basic-addon1' required></td>";
                    echo "<td><input id='correoAdmin' name='correoAdmin' style='font-size:10px' type='text' aria-describedby='basic-addon1' required></td>";
                    echo "<td><input id='cedulaAdmin' name='cedulaAdmin' style='font-size:10px' type='text' aria-describedby='basic-addon1' required></td>";
                    echo "<td><input id='ciudadAdmin' name='ciudadAdmin' style='font-size:10px' type='text' aria-describedby='basic-addon1' required></td>";
                    echo "<td><input id='telefonoAdmin' name='telefonoAdmin' style='font-size:10px' type='text' aria-describedby='basic-addon1' required></td>";
                  echo "</tr>";
               echo "</tbody>";
             echo "</table><br><br>";

             echo "<table class='container'>";
               echo "<thead>";
                 echo "<tr>";
                   echo "<th><h1>Nombre Técnico</h1></th>";
                   echo "<th><h1>Cedula Técnico</h1></th>";
                   echo "<th><h1>Ciudad de Expedición</h1></th>";
                   echo "<th><h1>Velocidad de Download</h1></th>";
                   echo "<th><h1>Velocidad de Upload</h1></th>";
                   echo "<th><h1>Generar Acta</h1></th>";
                 echo "</tr>";
               echo "</thead>";
               echo "<tbody>";
                 echo "<tr>";
                   echo "<td><input id='nombreTec' name='nombreTec' style='font-size:10px' type='text' aria-describedby='basic-addon1' required></td>";
                   echo "<td><input id='cedulaTec' name='cedulaTec' style='font-size:10px' type='text' aria-describedby='basic-addon1' required></td>";
                   echo "<td><input id='ciudadTec' name='ciudadTec' style='font-size:10px' type='text' aria-describedby='basic-addon1' required></td>";
                   echo "<td><input id='velocidadD' name='velocidadD' style='font-size:10px' type='text' aria-describedby='basic-addon1' required></td>";
                   echo "<td><input id='velocidadU' name='velocidadU' style='font-size:10px' type='text' aria-describedby='basic-addon1' required></td>";
                   echo "<td><button onclick = \"this.form.action = '".base_url()."PDF/crearActaIT?k_fase=".$PVD->getFase()."&k_tipo=".$PVD->getTipologia()."&k_pvd=".$PVD->getID()."&k_ticket=".$ticket."' \"type='submit' class='push_button blue' target='_blank'>importar<button></td>";
                 echo "</tr>";
              echo "</tbody>";
            echo "</table><br><br>";
           echo "</form>";
          echo "</div>";

          echo "<div id='formActaAA' name='formActaAA' hidden>";
            echo "<form method='post' name='form1'>";
              echo "<table class='container'>";
                echo "<thead>";
                  echo "<tr>";
                    echo "<th><h1>Nombre Admin</h1></th>";
                    echo "<th><h1>Correo Admin</h1></th>";
                    echo "<th><h1>Cedula Admin</h1></th>";
                    echo "<th><h1>Ciudad de Expedición</h1></th>";
                    echo "<th><h1>Télefono Admin</h1></th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                  echo "<tr>";
                    echo "<td><input id='nombreAdmin' name='nombreAdmin' style='font-size:10px' type='text' aria-describedby='basic-addon1' required></td>";
                    echo "<td><input id='correoAdmin' name='correoAdmin' style='font-size:10px' type='text' aria-describedby='basic-addon1' required></td>";
                    echo "<td><input id='cedulaAdmin' name='cedulaAdmin' style='font-size:10px' type='text' aria-describedby='basic-addon1' required></td>";
                    echo "<td><input id='ciudadAdmin' name='ciudadAdmin' style='font-size:10px' type='text' aria-describedby='basic-addon1' required></td>";
                    echo "<td><input id='telefonoAdmin' name='telefonoAdmin' style='font-size:10px' type='text' aria-describedby='basic-addon1' required></td>";
                  echo "</tr>";
               echo "</tbody>";
             echo "</table><br><br>";

             echo "<table class='container'>";
               echo "<thead>";
                 echo "<tr>";
                   echo "<th><h1>Nombre Técnico</h1></th>";
                   echo "<th><h1>Cedula Técnico</h1></th>";
                   echo "<th><h1>Ciudad de Expedición</h1></th>";
                   echo "<th><h1>Generar Acta</h1></th>";
                 echo "</tr>";
               echo "</thead>";
               echo "<tbody>";
                 echo "<tr>";
                   echo "<td><input id='nombreTec' name='nombreTec' style='font-size:10px' type='text' aria-describedby='basic-addon1' required></td>";
                   echo "<td><input id='cedulaTec' name='cedulaTec' style='font-size:10px' type='text' aria-describedby='basic-addon1' required></td>";
                   echo "<td><input id='ciudadTec' name='ciudadTec' style='font-size:10px' type='text' aria-describedby='basic-addon1' required></td>";
                   echo "<td><button onclick = \"this.form.action = '".base_url()."PDF/crearActaAA?k_fase=".$PVD->getFase()."&k_tipo=".$PVD->getTipologia()."&k_pvd=".$PVD->getID()."&k_ticket=".$ticket."' \"type='submit' class='push_button blue' target='_blank'>importar<button></td>";
                 echo "</tr>";
              echo "</tbody>";
            echo "</table><br><br>";
           echo "</form>";
          echo "</div>";

            if (isset($inventory)){
              echo "<table class='container'>";
                echo "<thead>";
                  echo "<tr>";
                    echo "<th><h1>Item</h1></th>";
                //    echo "<th><h1>Valor Unitario</h1></th>";
                    echo "<th><h1>Cantidad Tipologia</h1></th>";
                    echo "<th><h1>En Funcionamiento</h1></th>";
                    echo "<th><h1>En Correctivo</h1></th>";
                    echo "<th><h1>No Encontrados</h1></th>";
              //      echo "<th><h1>Valor Total</h1></th>";
                    echo "<th><h1>Expandir</h1></th>";
                    echo "<th><h1>Avance</h1></th>";
                  echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                  for ($i = 0; $i < count($inventory); $i++){
                    echo "<tr>";
                      echo "<td>".$inventory[$i]['N_NAME']."</td>";
              //        echo "<td>".$inventory[$i]['price']."</td>";
                      echo "<td>".$inventory[$i]['I_QUANTITY']."</td>";
                      echo "<td>".$inventory[$i]['funcional']."</td>";
                      echo "<td>".$inventory[$i]['averiado']."</td>";
                      echo "<td>".$inventory[$i]['NE']."</td>";
              /*        echo "<td>".$inventory[$i]['valorT']."</td>";*/
                      echo "<td><button type='button' class='push_button blue' onclick='showModal(".json_encode($inventory[$i]['K_IDEQUIPMENTTYPE']).",".json_encode($inventory[$i]['inventario']).",".json_encode($inventory[$i]['N_NAME']).",".json_encode($generic[$i]['category']).",".json_encode($generic[$i]['rutina']).")'>Expandir</button></td>";
                      echo "<td> ".$inventory[$i]['avance']."%</td>";
                    echo "</tr>";
                  }
               echo "</tbody>";
             echo "</table>";
            }
            if($_SESSION['id'] == 1023000199 || $_SESSION['id'] == 1014295226 || $_SESSION['id'] == 1023919446){
              if ($estadoI != 1){
                echo "<center><div class='btn-group'>";
                  echo "<br><br><br><a class='btn btn-danger btn-sm' href='".base_url()."Equipment/approveTicket?k_fase=".$PVD->getFase()."&k_tipo=".$PVD->getTipologia()."&k_pvd=".$PVD->getID()."&k_ticket=".$ticket."' >Aprobar a Interventoria</a>";
                echo "</div></center><br><br><br>";
              }
            }
            // echo "<form method='post' name='formActualizar'>";
            //   echo "<center><div class='btn-group'>";
            //     echo "<br><br><br><textarea name='anotaciones'>".$anotaciones."</textarea>";
            //     echo "<button type='submit' class='btn btn-info btn-sm' onclick = \"this.form.action = '".base_url()."Equipment/updateSoftwareInventory?k_fase=".$PVD->getFase()."&k_tipo=".$PVD->getTipologia()."&k_pvd=".$PVD->getID()."&k_ticket=".$ticket."' \"><i class='fa fa-floppy-o' aria-hidden='true'></i> Guardar Cambios</button>";
            //   echo "</div></center><br><br><br>";
            // echo "</form>";

           ?>
			</article>
	</div>
		<div class="main zerogrid">
<!-- footer -->
<!-- footer end -->
		</div>
    <!--Modal de inventario-->
    <div id="modal-02" class="modal fade">
      <div class="modal-content">
        <div id="main" class="container">
          <form method='post' name='formActualizar'>
            <div class="linea 200%">
              <div class="12u">
                <!-- Features -->
                <h2 class="major"><span>Inventario elementos funcionales</span></h2>
                <div>
                  <div class="linea">
                  <!-- content -->
                    <?php
                      echo "<center><div class='btn-group'>";
                        if($_SESSION['id'] != 314618 && $_SESSION['id'] != 314619){
                          echo "<button type='button' class='btn btn-primary btn-sm' onclick='añadirElemento()'><i class='fa fa-plus-square' aria-hidden='true'></i> Añadir Elemento</button>";
                          echo "<button type='submit' class='btn btn-info btn-sm' onclick = \"this.form.action = '".base_url()."Equipment/updateInventory?k_fase=".$PVD->getFase()."&k_tipo=".$PVD->getTipologia()."&k_pvd=".$PVD->getID()."&k_ticket=".$ticket."' \"><i class='fa fa-floppy-o' aria-hidden='true'></i> Guardar Cambios</button>";
                        }
                        echo "<button type='button' class='btn btn-danger btn-sm' data-dismiss='modal'><i class='fa fa-window-close' aria-hidden='true'></i> Salir</button>";
                      echo "</div></center>";
                      if (isset($inventory)){
                        echo "<article id='content'>";
                          echo "<table class='container' id='tableInventory' name='tableInventory'>";
                            echo "<thead>";
                              echo "<tr>";
                                echo "<th><h1>Eliminar</h1></th>";
                                echo "<th><h1>Elemento </h1></th>";
                                echo "<th><h1>Marca</h1></th>";
                                echo "<th><h1>Modelo</h1></th>";
                                echo "<th><h1>Serial</h1></th>";
                                echo "<th><h1>Placa de inventario</h1></th>";
                                echo "<th><h1>Número de parte</h1></th>";
                                echo "<th><h1>Área</h1></th>";
                                echo "<th><h1>Estado</h1></th>";
                                echo "<th><h1>Galeria</h1></th>";
                                echo "<th><h1>Finalizado</h1></th>";
                                echo "<th><h1>Observaciones</h1></th>";
                              echo "</tr>";
                            echo "</thead>";
                            echo "<tbody id='inventory' name='inventory'>";

                           echo "</tbody>";
                         echo "</table>";
                        echo "</article>";
                      }
                     ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="linea 100%">
              <div class="12u">
                <!-- Features -->
                <h2 class="major"><span>Elementos en mantenimiento correctivo</span></h2>
                <div>
                  <div class="linea">
                    <?php
                      if (isset($inventory)){
                        echo "<article id='content'>";
                          echo "<table class='container' id='tableCorrective' name='tableCorrective'>";
                            echo "<thead>";
                              echo "<tr>";
                                echo "<th><h1>Eliminar</h1></th>";
                                echo "<th><h1>Elemento </h1></th>";
                                echo "<th><h1>Marca</h1></th>";
                                echo "<th><h1>Modelo</h1></th>";
                                echo "<th><h1>Serial</h1></th>";
                                echo "<th><h1>Placa de inventario</h1></th>";
                                echo "<th><h1>Número de parte</h1></th>";
                                echo "<th><h1>Área</h1></th>";
                                echo "<th><h1>Estado</h1></th>";
                                echo "<th><h1>Galeria</h1></th>";
                              echo "</tr>";
                            echo "</thead>";
                            echo "<tbody id='corrective' name='corrective'>";
                           echo "</tbody>";
                         echo "</table>";
                        echo "</article>";
                      }
                     ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="linea 100%">
              <div class="12u">
                <!-- Features -->
                <h2 class="major"><span>Elementos no Encontrados</span></h2>
                <div>
                  <div class="linea">
                    <?php
                      if (isset($inventory)){
                        echo "<article id='content'>";
                          echo "<table class='container' id='tableNE' name='tableNE'>";
                            echo "<thead>";
                              echo "<tr>";
                              echo "<th><h1>Eliminar</h1></th>";
                                echo "<th><h1>Elemento </h1></th>";
                                echo "<th><h1>Marca</h1></th>";
                                echo "<th><h1>Modelo</h1></th>";
                                echo "<th><h1>Serial</h1></th>";
                                echo "<th><h1>Placa de inventario</h1></th>";
                                echo "<th><h1>Número de parte</h1></th>";
                                echo "<th><h1>Área</h1></th>";
                                echo "<th><h1>Estado</h1></th>";
                                echo "<th><h1>Galeria</h1></th>";
                                echo "<th><h1></h1></th>";
                                echo "<th><h1>Observaciones</h1></th>";
                              echo "</tr>";
                            echo "</thead>";
                            echo "<tbody id='NE' name='NE'>";
                           echo "</tbody>";
                         echo "</table>";
                        echo "</article>";
                      }
                     ?>
                  </div>
                </div>
              </div>
            </div>
            <input name='pvd' id='pvd' style='font-size:10px' type='hidden' aria-describedby='basic-addon1' value=' <?php echo $_GET['k_pvd'] ?> '></td>
            <input name='Elements' id='Elements' style='font-size:10px' type='hidden' aria-describedby='basic-addon1' value=''></td>
          </form>
          <div class="linea 200%">
            <div class="12u">
              <!-- Features -->
              <h2 class="major"><span>Rutina de Mantenimiento</span></h2>
              <div class="linea" id="checklist" name="checklist">
                <form id="todo-list">
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!--Modal inv Software-->
    <div id="modalSFT" class="modal fade">
      <div class="modal-content">
        <div id="main" class="container">
          <form method='post' name='formActualizar'>
            <div class="linea 100%">
              <div class="12u">
                <!-- Features -->
                <h2 class="major"><span>Inventario de Software</span></h2>
                <div>
                  <div class="linea">
                    <?php
                      if (isset($software)){
                        echo "<center><div class='btn-group'>";
                          if($_SESSION['id'] != 314618 && $_SESSION['id'] != 314619){
                            echo "<button type='submit' class='btn btn-info btn-sm' onclick = \"this.form.action = '".base_url()."Equipment/updateSoftwareInventory?k_fase=".$PVD->getFase()."&k_tipo=".$PVD->getTipologia()."&k_pvd=".$PVD->getID()."&k_ticket=".$ticket."' \"><i class='fa fa-floppy-o' aria-hidden='true'></i> Guardar Cambios</button>";
                          }
                          echo "<button type='button' class='btn btn-danger btn-sm' data-dismiss='modal'><i class='fa fa-window-close' aria-hidden='true'></i> Salir</button>";
                          if ($PVD->getRegion() == "Zona 1"){
                            echo "<a class='btn btn-primary btn-sm' target='_blank' href='https://drive.google.com/drive/folders/0BxX2l5kpb3SaZGNJT0E4OTY0Rjg'>Registro Fotografico de Software </a>";
                          }
                          if ($PVD->getRegion() == "Zona 4"){
                            echo "<a class='btn btn-primary btn-sm' target='_blank' href='https://drive.google.com/drive/folders/0BxX2l5kpb3SabFduRW1hMFhyWDQ'>Registro Fotografico de Software </a>";
                          }
                        echo "</div></center>";
                        echo "<article id='content'>";
                          echo "<table class='container' id='tableCorrective' name='tableCorrective'>";
                            echo "<thead>";
                              echo "<tr>";
                                echo "<th><h1>Elemento</h1></th>";
                                echo "<th><h1>Serial</h1></th>";
                                echo "<th><h1>S. Operativo</h1></th>";
                                echo "<th><h1>Office </h1></th>";
                                echo "<th><h1>Antivirus</h1></th>";
                                echo "<th><h1>Browser</h1></th>";
                                echo "<th><h1>SIMONTIC</h1></th>";
                                echo "<th><h1>MAGIC</h1></th>";
                                echo "<th><h1>NEC</h1></th>";
                                echo "<th><h1>SAC_TIC</h1></th>";
                                echo "<th><h1>JAWS</h1></th>";
                              echo "</tr>";
                            echo "</thead>";
                            echo "<tbody>";
                            for($i = 0; $i < count($software); $i++){
                              echo "<tr>";
                                echo "<td hidden><input id='idSS".$i."' name='idSS".$i."' value='".$software[$i]['K_SOFTWARE_INVENTORY']."' style='font-size:10px' aria-describedby='basic-addon1'></td>";
                                echo "<td>".$software[$i]['marca']." - ".$software[$i]['modelo']."</td>";
                                echo "<td>".$software[$i]['serial']."</td>";
                                echo "<td><input id='SOVer".$i."' name='SOVer".$i."' value='".$software[$i]['N_OPERATIVE_SYSTEM']."' style='font-size:10px' aria-describedby='basic-addon1'></td>";
                                echo "<td><input id='OfficeVer".$i."' name='OfficeVer".$i."'  value='".$software[$i]['N_OFFICE_VERSION']."' style='font-size:10px' aria-describedby='basic-addon1'></td>";
                                echo "<td><input id='AntivirusVer".$i."' name='AntivirusVer".$i."' value='".$software[$i]['N_ANTIVIRUS_VERSION']."' style='font-size:10px' aria-describedby='basic-addon1'></td>";
                                echo "<td><input id='BrowserVer".$i."' name='BrowserVer".$i."' value='".$software[$i]['N_BROWSER_VERSION']."' style='font-size:10px' aria-describedby='basic-addon1'></td>";
                                echo "<td><input id='SimonticVer".$i."' name='SimonticVer".$i."' value='".$software[$i]['N_SIMONTIC_VERSION']."' style='font-size:10px' aria-describedby='basic-addon1'></td>";
                                echo "<td><input id='MagicVer".$i."' name='MagicVer".$i."' value='".$software[$i]['N_MAGIC_VERSION']."' style='font-size:10px' aria-describedby='basic-addon1'></td>";
                                echo "<td><input id='SacVer".$i."' name='SacVer".$i."' value='".$software[$i]['N_SAC_VERSION']."' style='font-size:10px' aria-describedby='basic-addon1'></td>";
                                echo "<td><input id='SemillaVer".$i."' name='SemillaVer".$i."' value='".$software[$i]['N_SEMILLA_VERSION']."' style='font-size:10px' aria-describedby='basic-addon1'></td>";
                                echo "<td><input id='JawsVer".$i."' name='JawsVer".$i."' value='".$software[$i]['N_JAWS_VERSION']."' style='font-size:10px' aria-describedby='basic-addon1'></td>";
                              echo "</tr>";
                            }
                           echo "</tbody>";
                         echo "</table>";
                        echo "</article>";
                      }
                     ?>
                  </div>
                </div>
              </div>
            </div>
            <input name='pvd' id='pvd' style='font-size:10px' type='hidden' aria-describedby='basic-addon1' value=' <?php echo $_GET['k_pvd'] ?> '></td>
            <input name='Elements' id='Elements' style='font-size:10px' type='hidden' aria-describedby='basic-addon1' value='<?php echo count($software) ?>'></td>
          </form>
        </div>
      </div>
    </div>

    <!--Modal inv Software-->
    <div id="modalCCC" class="modal fade">
      <div class="modal-content">
        <div id="main" class="container">
          <form method='post' name='formActualizar'>
            <div class="linea 100%">
              <div class="12u">
                <!-- Features -->
                <h2 class="major"><span>Tickets CCC</span></h2>
                <div>
                  <div class="linea">
                    <?php
                        echo "<center><div class='btn-group'>";
                          echo "<button type='submit' class='btn btn-info btn-sm' onclick = \"this.form.action = '".base_url()."Equipment/updateCCC?k_fase=".$PVD->getFase()."&k_tipo=".$PVD->getTipologia()."&k_pvd=".$PVD->getID()."&k_ticket=".$ticket."' \"><i class='fa fa-floppy-o' aria-hidden='true'></i> Guardar Cambios</button>";
                          echo "<button type='button' class='btn btn-primary btn-sm' onclick='añadirElementoCCC()'><i class='fa fa-plus-square' aria-hidden='true'></i> Añadir Elemento</button>";
                          echo "<button type='button' class='btn btn-danger btn-sm' data-dismiss='modal'><i class='fa fa-window-close' aria-hidden='true'></i> Salir</button>";
                        echo "</div></center>";
                        echo "<article id='content'>";
                          echo "<table class='container' id='tableCCC' name='tableCCC'>";
                            echo "<thead>";
                              echo "<tr>";
                                echo "<th><h1>Id Ticket</h1></th>";
                                echo "<th><h1>Tipo</h1></th>";
                                echo "<th><h1>Descripción</h1></th>";
                                echo "<th><h1>Estado</h1></th>";
                                echo "<th><h1>Observaciones</h1></th>";
                              echo "</tr>";
                            echo "</thead>";
                            echo "<tbody>";
                            for($i = 0; $i < count($CCC); $i++){
                              echo "<tr>";
                                echo "<td hidden><input id='idCCC".$i."' name='idCCC".$i."' value='".$CCC[$i]['K_IDTICKET_CCC']."' style='font-size:10px' aria-describedby='basic-addon1'></td>";
                                echo "<td>".$CCC[$i]['K_IDTICKET_CCC']."</td>";

                                if($CCC[$i]['N_TIPO'] == "IT"){
                                  echo "<td><select style='font-size:10px' name='selectTipo".$i."' aria-describedby='basic-addon1'>";
                                    echo "<option selected='selected' value='IT'>IT</option>";
                                    echo "<option value='AA'>AA</option>";
                                  echo "</select></td>";
                                }

                                if($CCC[$i]['N_TIPO'] == "AA"){
                                  echo "<td><select style='font-size:10px' name='selectTipo".$i."' aria-describedby='basic-addon1'>";
                                    echo "<option selected='selected' value='AA'>AA</option>";
                                    echo "<option value='IT'>IT</option>";
                                  echo "</select></td>";
                                }
                                // echo "<td>".$CCC[$i]['N_TIPO']."</td>";

                                echo "<td><textarea rows='5' cols='70' name='desc".$i."'>".$CCC[$i]['N_DESCRIPTION']."</textarea></td>";

                              //  echo "<td>".$CCC[$i]['N_DESCRIPTION']."</td>";
                                echo "<td><select style='font-size:10px' name='select".$i."' aria-describedby='basic-addon1'>";
                                  echo "<option selected='selected' value='".$CCC[$i]['N_ESTADO']."'>".$CCC[$i]['N_ESTADO']."</option>";
                                  echo "<option value='Abierto'>Abierto</option>";
                                  echo "<option value='Solucionado'>Solucionado</option>";
                                  echo "<option value='En Correctivo'>En Correctivo</option>";
                                echo "</select></td>";
                                echo "<td><textarea name='observciones".$i."'>".$CCC[$i]['N_OBSERVATION']."</textarea></td>";
                              echo "</tr>";
                            }
                           echo "</tbody>";
                         echo "</table>";
                        echo "</article>";
                     ?>
                  </div>
                </div>
              </div>
            </div>
            <input name='pvd' id='pvd' style='font-size:10px' type='hidden' aria-describedby='basic-addon1' value=' <?php echo $_GET['k_pvd'] ?> '></td>
            <input name='Elements' id='Elements' style='font-size:10px' type='hidden' aria-describedby='basic-addon1' value='<?php echo count($CCC) ?>'></td>
          </form>
        </div>
      </div>
    </div>

  <script type="text/javascript"> Cufon.now(); </script>
  <script>
    $(document).ready(function() {
      tabs.init();
    })
  </script>
</body>
</html>
