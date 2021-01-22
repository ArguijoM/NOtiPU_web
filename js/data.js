var IdEliminar  =0;
var IdActualizar=0;
var idUsuario=0;
var id_grupo=0;
var nombreUsuario="";
var exist;

$(document).on('show.bs.modal', '.modal', function () {
    var zIndex = 1040 + (10 * $('.modal:visible').length);
    $(this).css('z-index', zIndex);
    setTimeout(function() {
        $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
    }, 0);
});
$(document).on('hidden.bs.modal', '.modal', function () {
    $('.modal:visible').length && $(document.body).addClass('modal-open');
});

function firebaseMessaging(grup,tit,desc){
	var token="";
	$.ajax({
		method: "GET",
		url   : "http://localhost/NOtiPU_web/php/notipu/public/api/agrupamientosGrupo/"+grup,
		data  : {
			accion: "read"
		},
		success: function( result2 ) {
			var respuesta2 = JSON.parse(result2);
			if(respuesta2.estado==1){
				respuesta2.agrupamiento.forEach(function(agrupamiento){
					$.ajax({
						method:"GET",
						url: "http://localhost/NOtiPU_web/php/notipu/public/api/usuarios/"+agrupamiento.Usuario_idUsuario,
						data: {
							accion: "read"
						},
						success: function( result3) {
							var respuesta3 = JSON.parse(result3); 
				
							if(respuesta3.estado==1){	
								respuesta3.usuarios.forEach(function(usuarios){
									token = usuarios.token;
									//token = "ejbyNs9RR-G3RSMr1qMBO8:APA91bESLb_8VsNPwER6OZ3R4GjMGu1OUtdwVuSBGdnHj4W8rjKOpHamzoHj-Wnt4lzzBLfZtV5W_E4D-Sk4KpTJMQHp_CVunylPYnd4ewHnJkMLK-T7W2pTRzQ561SBAGFAI-P9uL5r"
									$.ajax({        
										type : 'POST',
										url : "https://fcm.googleapis.com/fcm/send",
										headers : {
											Authorization : 'key=' + 'AAAAlFB6NyI:APA91bHvdsBl7D-CMph0-b84mWTG0xnvfYRnC89MuJru9fOqTlxI4dBWMY2cN664NOedHbhW4QX-4x-l03oW6KYWt6SBlam2wexTziHAV-vyWaqoRBUKBs-KXiSEeMhnWIZE4qigFp8l'
										},
										contentType : 'application/json',
										dataType: 'json',
										data: JSON.stringify({"to":token, "notification": {"title":tit,"body":desc}}),
										success : function(response) {
											console.log(response);
										},
										error : function(xhr, status, error) {
											console.log(xhr.error);                   
										}
									});
								});
								
							}else
							console.log(respuesta3.mensaje);
				
							}
						});
				});
				
			}else{
				console.log(respuesta2.mensaje);
			}
		}
		});	
}

function generarNotificaciones(){

	//varificarSecion
	//tipoEvento();

	$.ajax({
	  method:"GET",
	  url: "http://localhost/NOtiPU_web/php/notipu/public/api/notificaciones",
	  data: {
	    accion: "read"
	  },
	  success: function( result ) {
		var resultJSON = JSON.parse(result);

	  	if(resultJSON.estado==1){

	  		resultJSON.notificaciones.forEach(function(notificaciones){

				$.ajax({
					method:"GET",
					url: "http://localhost/NOtiPU_web/php/notipu/public/api/grupos/"+notificaciones.Grupo_idGrupo,
					data: {
					  accion: "read"
					},
					success: function( result2 ) {
						var respuesta = JSON.parse(result2); 
		
						if(respuesta.estado==1){
							
							var tabla=$('#example2').DataTable();
							
							respuesta.grupos.forEach(function(grupos){
								
								Botones='<div align="center"> <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-ver" onclick="mostrar('+notificaciones.idNotificacion+')">Ver</button>'; //BOTON EVIDENCIAS
							   
							  	titulo='<div align="center">'+notificaciones.titulo+'</div>';
			  
							  	grupo='<div align="center">'+grupos.nombre+'</div>'; //fechaInicial es el nombre que tiene la base de datos se puede cambiar
							  
			  
								tabla.row.add([
								  titulo,
								  grupo,
									Botones
									]).draw().node().id=""+notificaciones.idNotificacion;
			
								});
						}else
						  alert(resultJSON2.mensaje);
					}
				  });

	  		});
	  		
	  	}
	  }
	});
}

function generarAgrupamientos(){
	//varificarSecion
	

	$.ajax({
	  method:"GET",
	  url: "http://localhost/NOtiPU_web/php/notipu/public/api/grupos",
	  data: {
	    accion: "read"
	  },
	  success: function( result ) {
		  
		  
		var resultJSON = JSON.parse(result);
		  
	  	
	  	if(resultJSON.estado==1){
			var tabla=$('#example1').DataTable();
			tabla.clear().draw();
			generarAlumnosPorGrupo();
			generarUsuarios();
			
	  		var tabla=$('#grupos').DataTable();

	  		resultJSON.grupos.forEach(function(grupos){
	  			
	  			Botones='<div align="center"> <button type="button" onclick="mostrarGrupo('+grupos.idGrupo+')" class="btn btn-primary" data-toggle="modal" data-target="#modal-actualizar"><i class="fas fa-edit"></i></button>'; //BOTON EVIDENCIAS

				Botones=Botones+' <button type="button" class="btn btn-danger" onclick="mostrarEliminar('+grupos.idGrupo+')" data-toggle="modal" data-target="#modal-eliminar"><i class="fas fa-trash-alt"></i></button>'; //BOTON ACTUALIZAR

				Botones=Botones+' <button type="button" class="btn btn-success" onclick="generarIdGrupo('+grupos.idGrupo+');" data-toggle="modal" data-target="#modal-default"><i class="fas fa-user-friends"></i></button></div>'; //BOTON ELIMINAR
				 
				nombres='<div align="center">'+grupos.nombre+'</div>';

				descripciones='<div align="center">'+grupos.descripcion+'</div>'; //fechaInicial es el nombre que tiene la base de datos se puede cambiar


	  			tabla.row.add([
					nombres,
					descripciones,
	  				Botones
	  				]).draw().node().id=""+grupos.idGrupo;

	  		});
	  		
	  	}else
	    	alert(resultJSON.mensaje);
	  }
	});
}

function agregarGrupo(){
	var nombreGrupo   = $("#nombreGrupo").val();
	var descripcionGrupo =$("#descripcionGrupo").val();

	$.ajax({
		method: "POST",
		url   : "http://localhost/NOtiPU_web/php/notipu/public/api/grupos/nuevo",
		data  : {
		  "nombre": nombreGrupo,
		  "descripcion": descripcionGrupo
		},
		success: function(result) {
			var tabla=$('#grupos').DataTable();
			tabla.clear().draw();
			generarAgrupamientos();	
			location.reload();
			//nombreGrupo   = $("#nombreGrupo").val("");
			//descripcionGrupo =$("#descripcionGrupo").val("");
		  }

	  });

}

function mostrar(id){
	
	//varificarSecion
	//tipoEvento();

	$.ajax({
		method:"GET",
		url: "http://localhost/NOtiPU_web/php/notipu/public/api/notificaciones/"+id.toString(),
		data: {
			"idGrupo": id,
		},
		success: function( result ) {
			
			
		  var resultJSON = JSON.parse(result);
			if(resultJSON.estado==1){
				resultJSON.notificacion.forEach(function(notificacion){
					$.ajax({
						method:"GET",
						url: "http://localhost/NOtiPU_web/php/notipu/public/api/grupos/"+notificacion.Grupo_idGrupo,
						data: {
						  accion: "read"
						},
						success: function( result2 ) {
							var respuesta = JSON.parse(result2); 
			
							if(respuesta.estado==1){
								
								respuesta.grupos.forEach(function(grupos){
									
									$("#asunto").text(''+notificacion.titulo);
									$("#destinatario").text(''+grupos.nombre);
									$("#descripcion").text(''+notificacion.descripcion);
									$("#fecha").text(''+notificacion.fecha);
				
								});
							}else
							  alert(resultJSON2.mensaje);
						}
					  });	
				
				});
				
			}else
			  alert(resultJSON.mensaje);
		}
	  });
}

function mostrarGrupo(id){
	IdActualizar=id;

	$.ajax({
		method:"GET",
		url: "http://localhost/NOtiPU_web/php/notipu/public/api/grupos/"+id.toString(),
		data: {
		  accion: "read"
		},
		success: function( result) {
			var respuesta = JSON.parse(result); 

			if(respuesta.estado==1){
				
				respuesta.grupos.forEach(function(grupos){	
					$("#nombreEventoAct").val(''+grupos.nombre);
					$("#grupoDescripcion").val(''+grupos.descripcion);
				});
			}else
			  alert(resultJSON2.mensaje);
		}
	  });
	
}

function editarGrupo(){
	var nombreGrupo   = $("#nombreEventoAct").val();
	var descripcionGrupo =$("#grupoDescripcion").val();
	$.ajax({
		method:"PUT",
		url: "http://localhost/NOtiPU_web/php/notipu/public/api/grupos/modificar/"+IdActualizar,
		data: {
			"nombre": nombreGrupo,
			"descripcion": descripcionGrupo,
		},
		success: function( result) {
			respuesta = $.parseJSON(result); 
			
			tabla	= $("#grupos").DataTable();
			tabla.clear().draw();
			generarAgrupamientos();
		}
	  });
	  

}

function mostrarEliminar(id){
	IdEliminar =id;
}
function generarIdGrupo(id){
	
	$.ajax({
		method:"GET",
		url: "http://localhost/NOtiPU_web/php/notipu/public/api/grupos/"+id,
		data: {
		  accion: "read"
		},
		success: function( result) {
			var respuesta = JSON.parse(result); 

			if(respuesta.estado==1){
				
				respuesta.grupos.forEach(function(grupos){	
					$("#nombre_Grupo").text("Alumnos del grupo: "+grupos.nombre);
				});
			}else
			  alert(resultJSON2.mensaje);
		}
	  });
	
	id_grupo=id;
	var tabla=$('#example1').DataTable();
	tabla.clear().draw();
	generarAlumnosPorGrupo();
}

function eliminarUsuarioGrupo(id){
	$.ajax({
		method:"DELETE",
		url: "http://localhost/NOtiPU_web/php/notipu/public/api/agrupamientos/delete/"+id,
		data: {
			accion: "read",
		},
		success: function( result) {
			respuesta = $.parseJSON(result); 
			if(respuesta){
				var tabla=$('#example1').DataTable();
				tabla.clear().draw();
				generarAlumnosPorGrupo();
			}
		}
	  });
}

function eliminarGrupo(){
	$.ajax({
		method:"DELETE",
		url: "http://localhost/NOtiPU_web/php/notipu/public/api/grupos/delete/"+IdEliminar,
		data: {
			accion: "read",
		},
		success: function( result) {
			respuesta = $.parseJSON(result); 
			location.reload();
			//var tabla=$('#grupos').DataTable();
			//tabla.clear().draw();
			//generarAgrupamientos();
		}
	  });
}

function agrupar(id){
	alert(id);
}

function generarGrupos() { 
	$.ajax({
		method:"GET",
		url: "http://localhost/NOtiPU_web/php/notipu/public/api/grupos",
		data: {
		  accion: "read"
		},
		success: function( result) {
			var respuesta = JSON.parse(result); 

			if(respuesta.estado==1){
				
				respuesta.grupos.forEach(function(grupos){	
					$('#nuevoGrupo').append(new Option(grupos.nombre));
				});
			}else
			  alert(respuesta.mensaje);
		}
	  });

} 

function guardarNotificacion(){
	var titulo   = $("#nuevoAsunto").val();
	var descripcion = $("#nuevaDescripcion").val();
	var f = new Date();
	var nombre = $('#nuevoGrupo').find(":selected").text();
	var Idgrupo=0;
	var fecha ="";
	fecha =""+f.getFullYear()+"-"+f.getMonth()+1+"-"+f.getDate()+" "+f.getHours()+"-"+f.getMinutes()+"-"+f.getSeconds();
	//Consultar el id del grupo
	$.ajax({
		method:"GET",
		url: "http://localhost/NOtiPU_web/php/notipu/public/api/gruposN/"+nombre,
		data: {
		  accion: "read"
		},
		success: function( result) {
			var respuesta = JSON.parse(result); 

			if(respuesta.estado==1){
				
				respuesta.grupos.forEach(function(grupos){	
					//Idgrupo=grupos.idGrupo;
					$.ajax({
						method: "POST",
						url   : "http://localhost/NOtiPU_web/php/notipu/public/api/notificaciones/nuevo",
						data  : {
						  "titulo": titulo,
						  "descripcion": descripcion,
						  "fecha": fecha,
						  "Grupo_idGrupo": grupos.idGrupo
						},
						success: function( result2 ) {
				  
						  respuesta2 = $.parseJSON(result2); 
					   
						  if(respuesta.estado==1){
							firebaseMessaging(grupos.idGrupo,titulo,descripcion);
							var tabla=$('#example2').DataTable();
							tabla.clear().draw();
							titulo   = $("#nuevoAsunto").val("");
							descripcion = $("#nuevaDescripcion").val("");
							generarNotificaciones();
						  }
				  
						}
					  });
				});
			}else
			  alert(respuesta.mensaje);
		}
	  });
}

function generarUsuarios(){
	//generarGrupos();

	
	var tabla=$('#example3').DataTable();
	tabla.clear().draw();
	$.ajax({
		method:"GET",
		url: "http://localhost/NOtiPU_web/php/notipu/public/api/usuarios",
		data: {
		  accion: "read"
		},
		success: function( result) {
			var respuesta = JSON.parse(result); 

			if(respuesta.estado==1){
			
				
				respuesta.usuarios.forEach(function(usuarios){

					Botones = '<div align="center"> <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-eliminar-usuario">E</button>';	
					nombres=usuarios.nombrecompleto;
					funcion=usuarios.tipo; 

					tabla.row.add([
						nombres,
						funcion,
						Botones
						  ]).draw().node().id=usuarios.idUsuario;
				});
				
				
				$("#example3 tr").click(function(){
					$(this).addClass('selected').siblings().removeClass('selected');
					idUsuario = this.id;    
					nombreUsuario=$(this).find('td:first').html();  
				 });
				 
				 $('#ok').on('click', function(e){
					var nombreUsuario =$("#example3 tr.selected td:first").html();
					//alert(nombreUsuario);
				 });
	
			}else
			  alert(respuesta.mensaje);

			}
	  });
}

function asignarGrupo(){
	exist=0;
	$.ajax({
		method: "GET",
		url   : "http://localhost/NOtiPU_web/php/notipu/public/api/agrupamientosGrupo/"+id_grupo,
		data  : {
			accion: "read"
		},
		success: function( result2 ) {
			var respuesta2 = JSON.parse(result2);
			if(respuesta2.estado==1){
				respuesta2.agrupamiento.forEach(function(agrupamiento){
					if(agrupamiento.Usuario_idUsuario == idUsuario){
						exist=exist+1;
					}
				});
				agregarUsuarioGrupo(exist);
			}else{
				agregarUsuarioGrupo(0);
			}
		}
		});	
}

function agregarUsuarioGrupo(e){
	if(e>0){
		alert("El usuario ya forma parte del grupo");
	}else{
		$.ajax({
			method:"POST",
			url: "http://localhost/NOtiPU_web/php/notipu/public/api/agrupamientos/nuevo",
			data: {
				"Usuario_idUsuario": idUsuario,
				"Grupo_idGrupo": id_grupo,
			},
			success: function(result) {
					//alert(result);
					var tabla=$('#example1').DataTable();
					tabla.clear().draw();
					generarAlumnosPorGrupo();	
				}
			});
	}
}

function generarAlumnosPorGrupo(){
	$.ajax({
		method: "GET",
		url   : "http://localhost/NOtiPU_web/php/notipu/public/api/agrupamientosGrupo/"+id_grupo,
		data  : {
			accion: "read"
		},
		success: function( result2 ) {
			var respuesta2 = JSON.parse(result2); 
			if(respuesta2.estado==1){
				respuesta2.agrupamiento.forEach(function(agrupamiento){
					id_usuario=agrupamiento.Usuario_idUsuario;
					$.ajax({
						method:"GET",
						url: "http://localhost/NOtiPU_web/php/notipu/public/api/usuarios/"+id_usuario,
						data: {
							accion: "read"
						},
						success: function( result3) {
							var respuesta3 = JSON.parse(result3); 
				
							if(respuesta3.estado==1){
								var tabla=$('#example1').DataTable();
								
								respuesta3.usuarios.forEach(function(usuarios){
									Botones = '<div align="center"> <button type="button" onclick="eliminarUsuarioGrupo('+usuarios.idUsuario+');" class="btn btn-primary">E</button>';	
									nombres=usuarios.nombrecompleto;
									funcion=usuarios.tipo; 
				
									tabla.row.add([
										nombres,
										funcion,
										Botones
											]).draw().node().id=""+usuarios.idUsuario;
								});
								
							}else
								alert(respuesta3.mensaje);
				
							}
						});
			});
			}

		}
		});
}

function eliminarUsuario(){
	//alert(idUsuario);

	$.ajax({
		method:"DELETE",
		url: "http://localhost/NOtiPU_web/php/notipu/public/api/agrupamientos/delete/"+idUsuario,
		data: {
			accion: "read",
		},
		success: function( result) {
			respuesta = $.parseJSON(result); 
			if(respuesta){
				$.ajax({
					method:"DELETE",
					url: "http://localhost/NOtiPU_web/php/notipu/public/api/usuarios/delete/"+idUsuario,
					data: {
						accion: "read",
					},
					success: function( result2) {
						if(result2){
							generarUsuarios();
						}
					}
				  });
			}
		}
	  });

	
}