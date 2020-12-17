

function login(){
	window.location.replace("pages/inicio.html");
	/*var varEmail   = $("#email").val();
	var varPassword1 = $("#password1").val();

	$.ajax({
	  method: "post",
	  url   : "php/login.php",
	  data  : {
	    "email": varEmail,
	    "password1":varPassword1,
	    "accion":"login"
	  },
	  success: function( result ) {
	  	console.log(result);

	    respuesta = $.parseJSON(result); 
     
	    if(respuesta.estatus==1){
	    	alert(respuesta.mensaje);
	    	window.location.replace("pages/calendar.html");

	    }else{
	    	alert(respuesta.mensaje);

	    }

	  }
	});*/
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
//	alert("ENTRA A VERIFICAR EVENTO");
	
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