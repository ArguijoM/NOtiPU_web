<?php
    //Manejo de sesiones
    
	SESSION_START();
	
	$inactividad=20;
	if(isset($_SESSION["timeout"]))
	{
		$sessionTTL=time()-$_SESSION["timeout"];;
			if($sessionTTL>$inactividad)
			{
				session_destroy();
				header("Location: ../index.html");
			}
	}
	$_SESSION["timeout"]=time();

	if(isset($_POST["email"])&&isset( $_POST["password1"])&&$_POST["accion"]){
		
		$Respuesta = array();
		$accion    = $_POST["accion"];
		
		include "conexion.php";

		if($accion=="login")
		{
			Login($conexion);
		}
		
		elseif ($accion=="logout") {
			Logout();
		}
		else{
			$Respuesta["estatus"]=0;
			$Respuesta["mensaje"]="Opcion no valida";
			echo json_encode($Respuesta);	
		}
	}
	else{
		
		$Respuesta["estatus"]=0;
		$Respuesta["mensaje"]="Faltan Parametros";

		echo json_encode($Respuesta);
	}

	
		

	function Login($conexion){
		$usuario    = $_POST["email"];
		$contrase = $_POST["password1"];

		$Respuesta = array();
		
		$Query = "SELECT * FROM usuario WHERE email='".$usuario."' AND password1='".$contrase."'";
        
		$Resultado = mysqli_query($conexion, $Query);

		if(mysqli_affected_rows($conexion)>0){

			$Respuesta['estatus'] = 1;
			$Respuesta['email'] = "Acceso correcto";
			$Respuesta['mensaje'] = "Acceso correcto";
            
            $Renglon = mysqli_fetch_array($Resultado);
			
			//VARIABLES DE SESION
			$_SESSION["id"] = $Renglon["id_usuario"];
			$_SESSION["email"] = $Renglon["email"];


		}else{

			$Respuesta['estatus'] = 0;
			$Respuesta['mensaje'] = "Usuario y/o clave incorrecta";

		}

		echo json_encode($Respuesta);

	}

	function Logout(){

		unset($_SESSION["id"]);
		unset($_SESSION["email"]);

		session_unset();
		session_destroy();

	}

	
?>

