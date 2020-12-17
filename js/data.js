var IdEliminar  =0;
var IdActualizar=0;
var IdEvidencia=0;

function ActionRead(){

	//varificarSecion
	tipoEvento();

	$.ajax({
	  method:"post",
	  url: "../php/data.php",
	  data: {
	    accion: "read"
	  },
	  success: function( result ) {
		  
		  
		var resultJSON = JSON.parse(result);
		  
	  	
	  	if(resultJSON.estado==1){
	  		
	  		var tabla=$('#example1').DataTable();

	  		resultJSON.alta_eventos.forEach(function(alta_evento){
	  			
	  			Botones='<div align="center"> <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal-Evidencias" onclick="IdenticaEvidencia('+alta_evento.id+');">Evid</button>'; //BOTON EVIDENCIAS

				Botones=Botones+' | <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-actualizar" onclick="IdenticaActualizar('+alta_evento.id+');">Edit</button>'; //BOTON ACTUALIZAR

				Botones=Botones+' | <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-danger" onclick="IndentificaEliminar('+alta_evento.id+');">Del</button></div>'; //BOTON ELIMINAR
				 
				NombreEvento='<div align="center">'+alta_evento.nombre+'</div>';

				FechaInicialEvento='<div align="center">'+alta_evento.fecha_inicio+'</div>'; //fechaInicial es el nombre que tiene la base de datos se puede cambiar

				FechaFinalEvento='<div align="center">'+alta_evento.fecha_final+'</div>'; //fechaInicial es el nombre que tiene la base de datos se puede cambiar
				


	  			tabla.row.add([
	  				NombreEvento,
					FechaInicialEvento,
					FechaFinalEvento,
	  				Botones
	  				]).draw().node().id="row_"+alta_evento.id;

	  		});
	  		
	  	}else
	    	alert(resultJSON.mensaje);
	  }
	});
}

function tipoEvento(){
	$.ajax({
		method:"post",
		url: "../php/evento.php",
		data: {
		  accion: "read"
		},
        success: function( result ) {

        var resultJSON = JSON.parse(result);//Convertimos el dato JSON

		    if(resultJSON.estado == 1){//Si la variable en su posicion estado vale 1, todo saliÃ³ bien  
			resultJSON.tipos_eventos.forEach(function(tipo_evento){//Recorremos cada valor obtenido
				let select = document.getElementById('tipoEvento');   
				let option = document.createElement('option');
				option.text = tipo_evento.nombre;
				select.appendChild(option);
			});
                
            }else
              alert(resultJSON.mensaje);//Si hubo un error, mandamos un mensaje
        }
      });
}
function ActionCreate(){

	nom_Evento    = $("#nombreEvento").val();
	obs_Evento    = $("#descripcionEvento").val();

	clase_Evento  = $("#tipoEvento").val();
	tipo_Evento   = $("#tipoPublico").val();
////////////////////////
	

	var fecha_Inicio = "";
	var Fecha_Final = "";
	
	if($("#fechaNuevo").data("daterangepicker").startDate.format("A") == "PM")
	{
		let horaInicio = parseInt($("#fechaNuevo").data("daterangepicker").startDate.format("hh"))+12;
		
			  if(horaInicio == 24)
			  {
                horaInicio -= 12;
              }
			  fecha_Inicio = $("#fechaNuevo").data("daterangepicker").startDate.format("YYYY-MM-DD "+horaInicio+":mm");
	}
	else{
		let horaInicio = parseInt($("#fechaNuevo").data("daterangepicker").startDate.format("hh"));
			 
			if(horaInicio == 12){
                horaInicio = 0;
             }
			 fecha_Inicio = $("#fechaNuevo").data("daterangepicker").startDate.format("YYYY-MM-DD "+horaInicio+":mm");
	}

	if($("#fechaNuevo").data("daterangepicker").endDate.format("A") == "PM")
	{
		let horaFin = parseInt($("#fechaNuevo").data("daterangepicker").endDate.format("hh"))+12;
              
              if(horaFin == 24){
                horaFin -= 12;
              }
            
			  Fecha_Final = $("#fechaNuevo").data("daterangepicker").endDate.format("YYYY-MM-DD "+horaFin+":mm");
	}
	else{
		
		let horaFin = parseInt($("#fechaNuevo").data("daterangepicker").endDate.format("hh"));
		 
		 if(horaFin == 12){
			horaFin = 0;
		 }
		 Fecha_Final = $("#fechaNuevo").data("daterangepicker").endDate.format("YYYY-MM-DD "+horaFin+":mm");
	}

	
///////////////////////////
	
	$.ajax({
	  method:"post",
	  url: "../php/data.php",
	  data: {
	  	accion:"create",
	    nombre:nom_Evento,
	    observaciones:obs_Evento,
	    fecha_inicio:fecha_Inicio,
	    fecha_final:Fecha_Final,
	    clase_evento:clase_Evento,
	    tipo_evento:tipo_Evento
	  },
	  success: function( result ) {
	   
		var resultJSON = JSON.parse(result);
	    if(resultJSON.estado==1){

	    	
	    	var tabla=$('#example1').DataTable();
	    	
			Botones='<div align="center"> <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal-Evidencias">Evid</button>'; //BOTON EVIDENCIAS

			Botones=Botones+' | <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-actualizar" onclick="IdenticaActualizar('+resultJSON.id+');">Edit</button>'; //BOTON ACTUALIZAR

			Botones=Botones+' | <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-danger" onclick="IndentificaEliminar('+resultJSON.id+');">Del</button></div>'; //BOTON ELIMINAR
			  
			let FechaICalen = $("#fechaNuevo").data("daterangepicker").startDate.format("DD/MM/YYYY hh:mm");
			FechaICalen=FechaICalen.substring(0,FechaICalen.length-5);
			let FechaFCalen = $("#fechaNuevo").data("daterangepicker").endDate.format("DD/MM/YYYY hh:mm");
			FechaFCalen=FechaFCalen.substring(0,FechaFCalen.length-5);
			
			NombreEvento='<div align="center">'+nom_Evento+'</div>';

			FechaInicialEvento='<div align="center">'+FechaICalen+'</div>'; //fechaInicial es el nombre que tiene la base de datos se puede cambiar

			FechaFinalEvento='<div align="center">'+FechaFCalen+'</div>'; //fechaInicial es el nombre que tiene la base de datos se puede cambiar
			

				tabla.row.add([
  				NombreEvento,
  				FechaInicialEvento,
  				FechaFinalEvento,
  				Botones
			    ]).draw().node().id="row_"+resultJSON.id;


	    }else
	    	alert(resultJSON.mensaje);
	  }
	});

	$("#nombreEvento").val("");
	$("#descripcionEvento").val("");
}

function IndentificaEliminar(id){
	IdEliminar=id;

	tabla= $("#example1").DataTable();
	renglon=tabla.row("#row_"+IdEliminar).data();
	nombre= renglon[0];
	//nombre=nombre.slice(20,-6);
	document.getElementById("eliminarAlta").innerHTML=nombre;	
}
function ActionDelete(){

	IdElim=IdEliminar;

	$.ajax({
	  method:"post",
	  url: "../php/data.php",
	  data: {
	    id: IdElim,
	    accion: "delete"
	  },
	  success: function( result ) {
	  	resultJSON = JSON.parse(result);

	  	if(resultJSON.estado==1){
	  		//Eliminar el renglon de la tabla
	  		tabla = $("#example1").DataTable();
	  		tabla.row("#row_"+IdElim).remove().draw();
	  	}else{
	  		alert(resultJSON.mensaje);	
	  	}
	  }
	});
}
function IdenticaActualizar(id){
	
	IdActualizar=id;

    tabla= $("#example1").DataTable();	
    renglon=tabla.row("#row_"+IdActualizar).data();


	nombre = renglon[0];
	nombre=nombre.slice(20,-6);
	$("#nombreEventoA").val(nombre);

	obtenerDatos();	
}
function obtenerDatos(){
	
	$.ajax({
		method:"post",
        url: "../php/data.php",
        data: {
		  accion: "lecturaDatos",
          id: IdActualizar
        },
        success: function( result ) {
			
			
			var resultJSON = JSON.parse(result);
			
			

			if(resultJSON.estado==1)
			{
				$("#texAreaText").val(resultJSON.observaciones);

				let fechaInicio = resultJSON.fecha_inicio.toString();
                let fechaFin = resultJSON.fecha_final.toString();

				/*let fechaInicio = resultJSON.fecha_inicio.toString().substring(0,resultJSON.fecha_inicio.length-3);
                let fechaFin = resultJSON.fecha_final.toString().substring(0,resultJSON.fecha_final.length-3);*/
                $("#fechaActualizar").data("daterangepicker").setStartDate("'"+fechaInicio+"'");
				$('#fechaActualizar').data('daterangepicker').setEndDate("'"+fechaFin+"'");

				var eventoEditar = resultJSON.tipo_evento;
				if(resultJSON.tipo_evento=="NULL")
				{
					$("#tipoEventoA").val("");
				}else{
					tipoEventoE(eventoEditar);
				}
				

			   $('#publicoObj option').remove();
               let select = document.getElementById('publicoObj');   
               let option = document.createElement('option');
               let option2 = document.createElement('option');
               option.text = "Interno";
               option2.text = "Externo";
                  if(option.text == resultJSON.clase_publico){
                    option.selected = true;
                  }else{
                    option2.selected = true;
                  }
               select.appendChild(option);
               select.appendChild(option2);
			   
			}
			else{
				alert("datos no guardados");
			}
        }
      });
}
function tipoEventoE(tipoE){
	
	$.ajax({
		method:"post",
		url: "../php/evento.php",
		data: {
		  accion: "read"
		},
		  success: function( result ) {
  
		  var resultJSON = JSON.parse(result);//Convertimos el dato JSON
		  $('#tipoEventoA option').remove();
			  if(resultJSON.estado == 1){  
				  
				resultJSON.tipos_eventos.forEach(function(tipo_evento){
					  let select = document.getElementById('tipoEventoA');   
					  let option = document.createElement('option');
					  option.text = tipo_evento.nombre;
					  option.value = tipo_evento.nombre;
					  if(option.text == tipoE){
						  option.selected = true;
					  }
					  select.appendChild(option);
				  });
				  
			  }else
				alert(resultJSON.mensaje);
		  }
		});
}
function ActionUpdate(){
	
	idAct 		  = IdActualizar;
	nom_Evento    = $("#nombreEventoA").val();
	obs_Evento    = $("#texAreaText").val();
	clase_Evento  = $("#tipoEventoA").val();
	tipo_Evento   = $("#publicoObj").val();
	
	

	////////////////////////
	

	var fecha_Inicio = "";
	var Fecha_Final = "";
	
	if($("#fechaActualizar").data("daterangepicker").startDate.format("A") == "PM")
	{
		let horaInicio = parseInt($("#fechaActualizar").data("daterangepicker").startDate.format("hh"))+12;
		
			  if(horaInicio == 24)
			  {
                horaInicio -= 12;
              }
			  fecha_Inicio = $("#fechaActualizar").data("daterangepicker").startDate.format("YYYY-MM-DD "+horaInicio+":mm");
	}
	else{
		let horaInicio = parseInt($("#fechaActualizar").data("daterangepicker").startDate.format("hh"));
			 
			if(horaInicio == 12){
                horaInicio = 0;
             }
			 fecha_Inicio = $("#fechaActualizar").data("daterangepicker").startDate.format("YYYY-MM-DD "+horaInicio+":mm");
	}

	if($("#fechaActualizar").data("daterangepicker").endDate.format("A") == "PM")
	{
		let horaFin = parseInt($("#fechaActualizar").data("daterangepicker").endDate.format("hh"))+12;
              
              if(horaFin == 24){
                horaFin -= 12;
              }
            
			  Fecha_Final = $("#fechaActualizar").data("daterangepicker").endDate.format("YYYY-MM-DD "+horaFin+":mm");
	}
	else{
		
		let horaFin = parseInt($("#fechaActualizar").data("daterangepicker").endDate.format("hh"));
		 
		 if(horaFin == 12){
			horaFin = 0;
		 }
		 Fecha_Final = $("#fechaActualizar").data("daterangepicker").endDate.format("YYYY-MM-DD "+horaFin+":mm");
	}

	
///////////////////////////
    
	$.ajax({
	  method:"post",	
	  url: "../php/data.php",
	  data: {
	    accion: "update",
	    id:idAct,
	    nombre:nom_Evento,
	    observaciones:obs_Evento,
	    fecha_inicio:fecha_Inicio,
	    fecha_final:Fecha_Final,
	    clase_evento:clase_Evento,
	    tipo_evento:tipo_Evento
	    
	  },
	  success: function( result ) {

		
		resultJSON = JSON.parse(result);
		
		  
		  
		  
	  	if(resultJSON.estado==1){
	
			fecha_Inicio = $("#fechaActualizar").data("daterangepicker").startDate.format("DD/MM/YYYY hh:mm");
			fecha_Inicio=fecha_Inicio.substring(0,fecha_Inicio.length-5);
			Fecha_Final = $("#fechaActualizar").data("daterangepicker").endDate.format("DD/MM/YYYY hh:mm");
			Fecha_Final=Fecha_Final.substring(0,Fecha_Final.length-5);

			
	  		tabla		 = $("#example1").DataTable();
	  		
	  		renglon		 = tabla.row("#row_"+idAct).data();
	  		renglon[0]   = '<div align="center">'+nom_Evento+'</div>'; 
	  		renglon[1]	 = '<div align="center">'+fecha_Inicio+'</div>';
	  		renglon[2]   = '<div align="center">'+Fecha_Final+'</div>';

			tabla.row("#row_"+idAct).data(renglon);	  
			

	  	}else
	  	   alert(resultJSON.mensaje); 
	  } 
	});	
}

function IdenticaEvidencia(id){
	IdActualizar=0;
	IdActualizar=id;

	$.ajax({
		method:"post",
		url: "../php/data.php",
		data: {
		  accion: "identificaIdEvidencias",
		  id:IdActualizar
		},
		  success: function( result ) {

			
  
		  var resultJSON = JSON.parse(result);//Convertimos el dato JSON
		
		  
		  if(resultJSON.estado==1){ //EXISTE id
			
			mostrarDatosEvidencia();

		  }
		  else{
			   /*LO DE ABAJO ES PARA LIMPIAR EL ALTA EVIDENCIAS*/ 
			    var binculo="../dist/img/sinImagen.png"
				$("#CantidadHombres").val("");
				$("#CantidadMujeres").val("");
				$("#Expositores").val("");
				$("#pormenores").val("");
				$(".img1 ").attr("src", binculo );
				$(".img2 ").attr("src", binculo );
				$("#image1").val("");
				$("#image2").val("");
				
				/*EN ESTE CASO LA IMAGEN OCUPA REGRESAR A LA IMAGEN INICIAL
				*/
		  }
		  }
		});
    
}

function mostrarDatosEvidencia()//editar evidencia
{
	$.ajax({
		method:"post",
        url: "../php/data.php",
        data: {
		  accion: "lecturaDatosEvidencia",
          id: IdActualizar
        },
        success: function( result ) {
			
			
			var resultJSON = JSON.parse(result);
			

			if(resultJSON.estado==1)
			{
				$("#CantidadHombres").val(resultJSON.cant_hombres);
				$("#CantidadMujeres").val(resultJSON.cant_mujeres);
				$("#Expositores").val(resultJSON.expositor);
				$("#pormenores").val(resultJSON.pormenor);
				$(".img1 ").attr("src", resultJSON.evid_1);
				$(".img2 ").attr("src", resultJSON.evid_2);
				$("#img1 ").attr("src", resultJSON.evid_1);
				$("#img2 ").attr("src", resultJSON.evid_2);

		        				/*

				Img2   = $("#img2").val();
				PARA MOSTRAR LAS IMAGENES*/
			}
			else{
				alert("datos no encontrados");
			}
        }
      });
}

function cargarEvidencias()//crear NUEVA evidencia
{

	idEVEN   	   = IdActualizar;
	numHombres     = $("#CantidadHombres").val();
	numMujeres     = $("#CantidadMujeres").val();
	numExpositores = $("#Expositores").val();
	pormenores     = $("#pormenores").val();
	imge1          = $(".img1").prop('src');
	imge2  		   = $(".img2").prop('src');
	
	
	console.log(imge1);//PARA HACER CUENTITAS
		Imge1  = imge1.substring(36,136);
	console.log(imge2);//PARA HACER CUENTITAS
		Imge2  = imge2.substring(36,136);
	
	
	$.ajax({
		method:"post",
		url: "../php/data.php",
		data: {
		  accion:"crearEvidencia",
		  id:idEVEN,
		  hombres:numHombres,
		  mujeres:numMujeres,
		  expositores:numExpositores,
		  porme:pormenores,
		  imagen1:Imge1,
		  imagen2:Imge2
		},
		success: function( result ) {

		 alert("ALERT "+result);
		  var resultJSON = JSON.parse(result);
		  
		}
	  });
}





