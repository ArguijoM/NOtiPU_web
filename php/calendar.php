<?php
    
	$Respuesta=array();

	if(isset($_POST['accion'])){
		
		include "conexion.php";
		
		switch ($_POST['accion']) {
			
			case 'identificaIdEvidencias':
				ActionIdentificarIdPHP($conexion);
					break;
			case 'obtenerDatosSinEvidencia':
				ActionSinEvidenciaPHP($conexion);
					break;
			case 'obtenerDatosConEvidencia':
				ActionConEvidenciaPHP($conexion);
					break;
			default:
				$Respuesta["estado"]=0;
				$Respuesta["mensaje"]="Accion no valida";
				echo json_encode($Respuesta);
				break;
		}
	
	}else{
		$Respuesta["estado"]=0;
		$Respuesta["mensaje"]="Faltan Parametros";
		echo json_encode($Respuesta);
	}

	function ActionIdentificarIdPHP($conexion){
		$Id= $_POST['id'];
	
		$Query="SELECT * FROM evidencias WHERE id=".$Id;
		
		mysqli_query($conexion,$Query);
	
		if(mysqli_affected_rows($conexion)>0){ //EXISTE UNA FILA CON DICHO VALOR EXISTE EVIDENCIAS
			$Respuesta['estado']=1;
			$Respuesta['mensaje']="Ya hay datos conocidos";	
		}else{ //NO EXISTE NINGUNA FILA CON ESE ID
			$Respuesta['estado']=0;
			$Respuesta['mensaje']="No se ha registrado nada"; //NO EXISTEN EVIDENCIAS
		}	
		echo json_encode($Respuesta);
	}


	function ActionSinEvidenciaPHP($conexion){
		if(isset($_POST['id']))
		{
			$id = $_POST['id'];
			$Query ="SELECT * FROM alta_evento WHERE id=".$id;
			$Query_F="SELECT DATE_FORMAT(fecha_inicio, '%d/%m/%Y %r'), DATE_FORMAT(fecha_final, '%d/%m/%Y %r') FROM alta_evento WHERE id=".$id;
			/*mysqli_query($conexion,$Query);*/
			
			///
			$Resultado 	= mysqli_query($conexion,$Query);
			$Renglon = mysqli_fetch_array($Resultado);
			///
			$Resultado2 	= mysqli_query($conexion,$Query_F);// or die (mysl_error());
			$Renglon2 = mysqli_fetch_array($Resultado2);
	
	
			if(mysqli_affected_rows($conexion)>0){
	
				$Respuesta["nombre"]= $Renglon["nombre"];
				$Respuesta["observaciones"]= $Renglon["observaciones"];
				$Respuesta["tipo_evento"]= $Renglon["tipo_evento"];
				$Respuesta["clase_publico"]= $Renglon["clase_publico"];
				$Respuesta["fecha_inicio"] = $Renglon2["DATE_FORMAT(fecha_inicio, '%d/%m/%Y %r')"];
				$Respuesta["fecha_final"]  = $Renglon2["DATE_FORMAT(fecha_final, '%d/%m/%Y %r')"];
	
				$Respuesta["estado"]	=1;
				$Respuesta["mensaje"]	="Se obtuvieron los datos";
			}else{
				$Respuesta["estado"]	=0;
				$Respuesta["mensaje"]	="Ocurrio un error desconocido";
			}
	
	
		}
		else{
			$Respuesta["estado"]	=0;
			$Respuesta["mensaje"]	="Falta un id";
		}
		
	
		echo json_encode($Respuesta);

	}

	function ActionConEvidenciaPHP($conexion)
	{
		if(isset($_POST['id']))
	 {
		$id = $_POST['id'];
		$Query ="SELECT * FROM evidencias WHERE id=".$id;
		$Resultado 	= mysqli_query($conexion,$Query);
		$Renglon = mysqli_fetch_array($Resultado);
		///
		$QueryA ="SELECT * FROM alta_evento WHERE id=".$id;
		$Resultado2 	= mysqli_query($conexion,$QueryA);
		$Renglon2 = mysqli_fetch_array($Resultado2);


		if(mysqli_affected_rows($conexion)>0){
			
			$Respuesta["clase_publico"]= $Renglon2["clase_publico"];
			$Respuesta["nombre"]= $Renglon2["nombre"];

			$Respuesta["cant_hombres"]= $Renglon["cant_hombres"];
			$Respuesta["cant_mujeres"]= $Renglon["cant_mujeres"];
			$Respuesta["pormenor"]    = $Renglon["pormenor"];
			$Respuesta["evid_1"]	  = "../dist/img/".$Renglon["evid_1"];
			$Respuesta["evid_2"]	  = "../dist/img/".$Renglon["evid_2"];
			$Respuesta["estado"]	  =1;
			$Respuesta["mensaje"]	  ="Se obtuvieron los datos";
		}else{
			$Respuesta["estado"]	  =0;
			$Respuesta["mensaje"]	  ="Ocurrio un error desconocido";
		}


		}
		else{
			$Respuesta["estado"]	=0;
			$Respuesta["mensaje"]	="Falta un id";
		}
		echo json_encode($Respuesta);


		
	}


	




	

?>