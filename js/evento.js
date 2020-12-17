 //Create Read Update Delete 
var IdEliminar  =0;
var IdActualizar=0;
function ActionRead(){

	$.ajax({
	  method:"post",
	  url: "../php/evento.php",
	  data: {
	    accion: "read"
	  },
	  success: function( result ) {
	  	var resultJSON = JSON.parse(result);
	  	
	  	if(resultJSON.estado==1){
	  		
	  		var tabla=$('#example1').DataTable();

	  		resultJSON.tipos_eventos.forEach(function(tipo_evento){
	  			
	  			Botones='<div align="center"> <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-actualizar" onclick="IdenticaActualizar('+tipo_evento.id+');">Edit</button>';
	  			Botones=Botones+' | <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-eliminar" onclick="IndentificaEliminar('+tipo_evento.id+');">Del</button></div>';
				  
				NombreEvento='<div align="center">'+tipo_evento.nombre+'</div>';

				NombreObservaciones='<div align="center">'+tipo_evento.observaciones+'</div>';
				
	  			tabla.row.add([
					NombreEvento,
					NombreObservaciones,
	  				Botones
	  				]).draw().node().id="row_"+tipo_evento.id;

	  		});
	  		
	  	}else
	    	alert(resultJSON.mensaje);
	  }
	});
}

function ActionDelete(){

	IdElim=IdEliminar;

	$.ajax({
	  method:"post",
	  url: "../php/evento.php",
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

function ActionUpdate(){
	
	idAct 				= IdActualizar;
	nombreAct			= $("#nombreEventoAct").val();
	observacionesAct	= $("#descripcionEventoAct").val();


	$.ajax({
	  method:"post",	
	  url: "../php/evento.php",
	  data: {
	    accion: "update",
	    id    : idAct,
	    nombre: nombreAct,
	    observaciones: observacionesAct
	  },
	  success: function( result ) {
	  	resultJSON = JSON.parse(result);
	  	if(resultJSON.estado==1){

	  		tabla		 = $("#example1").DataTable();
	  		
	  		renglon		 = tabla.row("#row_"+idAct).data();
	  		
			  renglon[0]   = '<div align="center">'+nombreAct+'</div>'; //
			  renglon[1]   = '<div align="center">'+observacionesAct+'</div>';//

			tabla.row("#row_"+idAct).data(renglon);	  		

	  	}else
	  	   alert(resultJSON.mensaje);
	  }
	});
}

function ActionCreate(){

	nomEvento=$("#nombre").val();
	obsEvento=$("#descripcionEvento").val();
	
    
	$.ajax({
	  method:"post",
	  url: "../php/evento.php",
	  data: {
	  	accion:"create",
	    nombre:nomEvento,
	    observaciones:obsEvento
	  },
	  success: function( result ) {
	   
	    resultJSON = JSON.parse(result);
	    
	    if(resultJSON.estado==1){
	    	
	    	var tabla=$('#example1').DataTable();
	    	
	    	  	Botones='<div align="center"> <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-actualizar" onclick="IdenticaActualizar('+resultJSON.id+');">Edit</button>';
	  			Botones=Botones+' | <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-eliminar" onclick="IndentificaEliminar('+resultJSON.id+');">Del</button></div>';

	  			NombreEvento='<div align="center">'+nomEvento+'</div>';

				NombreObservaciones='<div align="center">'+obsEvento+'</div>';
	  		
	  		tabla.row.add([
				NombreEvento,
				NombreObservaciones,
  				Botones
  				]).draw().node().id="row_"+resultJSON.id;

	    }else
	    	alert(resultJSON.mensaje);
	  }
	});

	$("#nombre").val("");
    $("#descripcionEvento").val("");
	
}

function IndentificaEliminar(id){
	IdEliminar=id;

	tabla= $("#example1").DataTable();
	renglon=tabla.row("#row_"+IdEliminar).data();
	nombre= renglon[0];
	nombre=nombre.slice(20,-6);
	document.getElementById("elementoEliminar").innerHTML=nombre;
	

	
}

function IdenticaActualizar(id)
{
    IdActualizar=id;
	tabla= $("#example1").DataTable();
	
    renglon=tabla.row("#row_"+IdActualizar).data();
    nombre= renglon[0];
	observaciones= renglon[1];
	
	nombre=nombre.slice(20,-6);
	observaciones=observaciones.slice(20,-6);

 
    $("#nombreEventoAct").val(nombre);
    $("#descripcionEventoAct").val(observaciones);  
 
}
