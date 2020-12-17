 <?php

$Respuesta=array();

if(isset($_POST['accion'])){
	
	include "conexion.php";
	
	switch ($_POST['accion']) {
		case 'read':
			ActionReadPHP($conexion);
			break;
		case 'update':
			ActionUpdatePHP($conexion);
			break;
		case 'create':
			ActionCreatePHP($conexion);
			break;
		case 'delete':
			ActionDeletePHP($conexion);
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

function ActionReadPHP($conexion){
	
	$Query 		="SELECT * FROM tipo_evento";
	
	$Respuesta["tipos_eventos"]	=	array();

	$Resultado 	= mysqli_query($conexion,$Query);


	while($Renglon = mysqli_fetch_array($Resultado)){

		$Tipo_Evento = array();

		$Tipo_Evento["id"]			 = $Renglon["id"];
		$Tipo_Evento["nombre"]		 = $Renglon["nombre"];
		$Tipo_Evento["observaciones"]= $Renglon["observaciones"];

		array_push($Respuesta["tipos_eventos"], $Tipo_Evento);
	}

	$Respuesta["estado"]	=1;
	$Respuesta["mensaje"]	="Consulta exitosa";
	
	echo json_encode($Respuesta);
}

function ActionDeletePHP($conexion){
	
	$Respuesta=array();

	if(isset($_POST['id'])){
		
		$id = $_POST['id'];
		$Query = "DELETE FROM tipo_evento WHERE id=".$id;

		mysqli_query($conexion,$Query);

		if(mysqli_affected_rows($conexion)>0){
			$Respuesta["estado"]	=1;
			$Respuesta["mensaje"]	="Se elimino correctamente";
		}else{
			$Respuesta["estado"]	=0;
			$Respuesta["mensaje"]	="Ocurrio un error desconocido";
		}
	}else{
		$Respuesta["estado"]	=0;
		$Respuesta["mensaje"]	="Falta un id";
	}

	echo json_encode($Respuesta);
}

function ActionUpdatePHP($conexion){
	
	$Nombre 		= $_POST['nombre'];
	$Observaciones  = $_POST['observaciones'];
	$Id 			= $_POST['id'];

	$Query ="UPDATE tipo_evento SET nombre='".$Nombre."', observaciones='".$Observaciones."' WHERE id=".$Id;
	
	mysqli_query($conexion,$Query);

	if(mysqli_affected_rows($conexion)>0){
		$Respuesta['estado']=1;
		$Respuesta['mensaje']="Datos actualizados correctamente";	
	}else{
		$Respuesta['estado']=0;
		$Respuesta['mensaje']="Ocurrrio un error desconocido";
	}

	
	echo json_encode($Respuesta);
}

function ActionCreatePHP($conexion){
	
	$Respuesta=array();

	if(isset($_POST['nombre'])&&isset($_POST['observaciones'])){
		$nombre = $_POST['nombre'];
		$observaciones = $_POST['observaciones'];

		$Query = "INSERT INTO tipo_evento(nombre,observaciones) VALUES('$nombre','$observaciones')";

		mysqli_query($conexion,$Query);

		if(mysqli_affected_rows($conexion)>0){
			$id 					=mysqli_insert_id($conexion);
			
			$Respuesta['estado']	=1;
			$Respuesta['mensaje']	="El evento se guardo correctamente";
			$Respuesta['id']		=$id;
			
		}else{
			$Respuesta['estado']=0;
			$Respuesta['mensaje']="Ocurrio un error desconocido";
		}

	}
	else{
		$Respuesta['estado']=0;
		$Respuesta['mensaje']="Faltan parametros";
	}

	echo json_encode($Respuesta);
}

?>