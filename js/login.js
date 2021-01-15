
function loginPrueba(){
	var usuario   = $("#usuario").val();
	var clave = $("#clave").val();

	$.ajax({
		method: "get",
		url   : "http://sistemas.upiiz.ipn.mx/isc/nopu/api/login.php",
		data  : {
			"usuario":usuario,
			"clave":clave
		},
		success: function(result) {
			let resultJSON = JSON.parse(result);
			if(resultJSON.estado==1){
				window.location.replace("pages/inicio.html");
			}else{
				alert(resultJSON.mensaje);
			}
		}
	  });
}

function loginPrueba2(){
	$.ajax({
		method: "GET",
		url   : "http://sistemas.upiiz.ipn.mx/isc/nopu/api/login.php?usuario=121179&clave=121179",
		success: function(result) {
			let resultJSON = JSON.parse(result);
			if(resultJSON.estado==1){
				window.location.replace("pages/inicio.html");
			}else{
				alert(resultJSON.mensaje);
			}
		}
	  });
}



function login(){
	var varEmail   = $("#nombrecompleto").val();
	var varPassword1 = $("#token").val();

	$.ajax({
	  method: "post",
	  url   : "php/login.php",
	  data  : {
	    "nombrecompleto": varEmail,
	    "token":varPassword1
	  },
	  success: function( result ) {
	  	console.log(result);

	    respuesta = $.parseJSON(result); 
     
	    if(respuesta.estatus==1){
			alert(respuesta.mensaje);
	    	window.location.replace("pages/inicio.html");

	    }else{
			alert(respuesta.mensaje);

	    }

	  }
	});
}


function logout(){

	$.ajax({
	method: "post",
	url: "../php/cerrarSesion.php",
	data: {
		accion: "logout"
	},
	success: function( result ) {
		alert(result);
		window.location.replace("../index.html");
	}
	});

}

function verificaLogin(){
	alert("ENTRA A VERIFICAR EVENTO");
	
	$.ajax({
		method: "post",
		url: "../php/verificarSesion.php",
		data: {
			accion: "verificarLo"
		},
		success: function( result ) {


			resultJSON = $.parseJSON(result);


			if(resultJSON.estado==0){

				alert(resultJSON.mensaje);
				window.location.replace("../index.html");

			}

			
		}
		});
}