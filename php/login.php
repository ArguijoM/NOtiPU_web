<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, DELETE, PUT, GET, OPTIONS');

	if(isset($_POST["nombrecompleto"])&&isset( $_POST["token"]))
	{
		
		$Respuesta = array();
		
		include "conexion.php";
		Login($conexion);
       
	}
	else{
		
		$Respuesta["estatus"]=0;
		$Respuesta["mensaje"]="Faltan Parametros";

		echo json_encode($Respuesta);
	}

	
		

	function Login($conexion){
		$usuario    = $_POST["nombrecompleto"];
		$contrase = $_POST["token"];

		$Respuesta = array();
		
		$Query = "SELECT * FROM usuariomovil WHERE nombrecompleto='".$usuario."' AND token='".$contrase."'";
        
		$Resultado = mysqli_query($conexion, $Query);

		if(mysqli_affected_rows($conexion)>0){

			$Respuesta['estatus'] = 1;
			$Respuesta['nombrecompleto'] = "Acceso correcto";
			$Respuesta['mensaje'] = "Acceso correcto";
            
            $Renglon = mysqli_fetch_array($Resultado);


		}else{

			$Respuesta['estatus'] = 0;
			$Respuesta['mensaje'] = "Usuario y/o clave incorrecta";

		}

		echo json_encode($Respuesta);

	}


	
?>

