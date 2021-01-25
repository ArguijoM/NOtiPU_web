
function loginPrueba(){
	var usuario   = $("#usuario").val();
	var clave = $("#clave").val();
	try {
		$.ajax({
			method: "get",
			url   : "http://localhost/NOtiPU_web/php/notipu/public/api/loginUsuario/"+usuario,
			data  : {
				"usuario":usuario
			},
			success: function(result) {
				let resultJSON = JSON.parse(result);
				if(resultJSON.estado==1){
					$.ajax({
						method: "get",
						url   : "http://localhost/NOtiPU_web/php/notipu/public/api/loginClave/"+clave,
						data  : {
							"clave":clave
						},
						success: function(result) {
							let resultJSON = JSON.parse(result);
							if(resultJSON.estado==1){
								window.location.replace("pages/inicio.html");
							}else{
								alert("Usuario y/o contraseña incorrectos");
							}
						}
					  });
				}else{
					alert("Usuario y/o contraseña incorrectos");
				}
			}
		  });
		
	} catch (error) {
		alert("Ingrese los datos correspondientes");
	}
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