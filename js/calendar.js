function identificarEvento(ID)
{
 // alert("ENTRA A BUSCAR INFORMACION y el ID ES: "+ID);

 $.ajax({
  method:"post",
  url: "../php/calendar.php",
  data: {
    accion: "identificaIdEvidencias",
    id:ID
  },
    success: function( result ) {

   // alert(result);

    var resultJSON = JSON.parse(result);//Convertimos el dato JSON
  
    if(resultJSON.estado==1){ //EXISTE id
    
      //alert("existe una evidencia");
      mostrarConEvidencia(ID);

    }
    else{
     // alert("NO existe una evidencia");
      mostrarSinEvidencias(ID);
    }
    }
  });
  
}

function mostrarSinEvidencias(ID)
{
  $("#apartadoObservaciones").html("");
  $("#tipoEvento").html("");
  $("#publicoObjetivo").html("");
  $("#fechaInicial").html("");
  $("#fechaFinal").html("");
  $("#titleSE").html("");
  $.ajax({
	  url: '../php/calendar.php',
    method:'post',
	  data: {
      accion: "obtenerDatosSinEvidencia",
      id:ID
	  },
	  success: function( result ) {
    //alert(result);
    var resultJSON = JSON.parse(result);
    
    $("#apartadoObservaciones").append(resultJSON.observaciones);
    $("#tipoEvento").append(resultJSON.tipo_evento);
    $("#publicoObjetivo").append(resultJSON.clase_publico);
    $("#fechaInicial").append(resultJSON.fecha_inicio);
    $("#fechaFinal").append(resultJSON.fecha_final);
    $("#titleSE").html("Evento: "+resultJSON.nombre);
    $("#modal-sinEvidencias").modal("show");
	  }
	});

}

function mostrarConEvidencia(ID)
{
  $("#cantidadHombres").html("");
  $("#cantidadMujeres").html("");
  $("#poblacionAtendida").html("");
  $("#pormenores").html("");
  $("#titleCE").html("");
  $(".img1 ").attr("src", resultJSON.evid_1);
  $(".img2 ").attr("src", resultJSON.evid_2);
  
  $.ajax({
	  url: '../php/calendar.php',
    method:'post',
	  data: {
      accion: "obtenerDatosConEvidencia",
      id:ID
	  },
	  success: function( result ) {
    //alert(result);
    var resultJSON = JSON.parse(result);
    
    $("#cantidadHombres").append(resultJSON.cant_hombres);
    $("#cantidadMujeres").append(resultJSON.cant_mujeres);
    $("#poblacionAtendida").append(resultJSON.clase_publico);
    $("#pormenores").append(resultJSON.pormenor);
    $("#titleCE").html("Evento: "+resultJSON.nombre);
    $(".img1 ").attr("src", resultJSON.evid_1);
    $(".img2 ").attr("src", resultJSON.evid_2);
    $("#modal-xl").modal("show");
	  }
	});
}