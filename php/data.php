 <?php
/*
 SESSION_START();
 $IDU=$_SESSION['id'];
 $EMAILU=$_SESSION['email'];
*/

$Respuesta=array();


if(isset($_POST['accion'])){
	
	include "conexion.php";
	
	switch ($_POST['accion']) {
		case 'read':
			ActionReadPHP($conexion);
			break;
		case 'create':
			ActionCreatePHP($conexion);
			break;
		case 'update':
			ActionUpdatePHP($conexion);
			break;
		case 'delete':
			ActionDeletePHP($conexion);
			break;
		case 'lecturaDatos':
			ActionObtenerDatosPHP($conexion);
				break;	
		case 'identificaIdEvidencias':
			ActionIdentificarIdPHP($conexion);
				break;
		case 'crearEvidencia':
			ActionCrearEvidenciaPHP($conexion);
				break;
		case 'lecturaDatosEvidencia':
			ActionObtenerEvidenciasPHP($conexion);
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
	
	$Query 		="SELECT * FROM alta_evento";	
	$Respuesta["alta_eventos"]	=	array();
	$Resultado 	= mysqli_query($conexion,$Query);

	$Query_F="SELECT DATE_FORMAT(fecha_inicio, '%d/%m/%Y'), DATE_FORMAT(fecha_final, '%d/%m/%Y') FROM alta_evento";
	$Resultado2 	= mysqli_query($conexion,$Query_F);// or die (mysl_error());

	while($Renglon = mysqli_fetch_array($Resultado)){

		$Alta_Evento = array();
		$Alta_Evento["id"]		 = $Renglon["id"];
		$Alta_Evento["nombre"]		 = $Renglon["nombre"];

		$Renglon2 = mysqli_fetch_array($Resultado2);
		
		$Alta_Evento["fecha_inicio"] = $Renglon2["DATE_FORMAT(fecha_inicio, '%d/%m/%Y')"];
		$Alta_Evento["fecha_final"]  = $Renglon2["DATE_FORMAT(fecha_final, '%d/%m/%Y')"];
		


		array_push($Respuesta["alta_eventos"], $Alta_Evento);
	}


	$Respuesta["estado"]	=1;
	$Respuesta["mensaje"]	="Consulta exitosa";
	
	echo json_encode($Respuesta);
}

function ActionCreatePHP($conexion){
	
	$Respuesta=array();

	if(isset($_POST['nombre'])&&isset($_POST['observaciones'])&&isset($_POST['fecha_inicio'])&&isset($_POST['fecha_final'])&&isset($_POST['clase_evento'])&&isset($_POST['tipo_evento'])){
		
		$nombre        = $_POST['nombre'];
		$observaciones = $_POST['observaciones'];
		$fecha_inicio  = $_POST['fecha_inicio'];
		$fecha_final   = $_POST['fecha_final'];
		$clase_evento  = $_POST['clase_evento'];

		/*if(isset($_POST['tipo_evento']))
		{*/
			$tipo_evento   = $_POST['tipo_evento'];
		/*}
		else{
			$tipo_evento="NULL";
		}*/
		

		
        
		$Query = "INSERT INTO alta_evento(nombre,observaciones,fecha_inicio,fecha_final,tipo_evento,clase_publico) VALUES('$nombre','$observaciones','$fecha_inicio','$fecha_final','$clase_evento','$tipo_evento')";
        
		mysqli_query($conexion,$Query);

		if(mysqli_affected_rows($conexion)>0){
			$id					=mysqli_insert_id($conexion);
			
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
function ActionDeletePHP($conexion){
	
	$Respuesta=array();

	if(isset($_POST['id'])){
		
		$id = $_POST['id'];
		$Query = "DELETE FROM alta_evento WHERE id=".$id;
		mysqli_query($conexion,$Query);
		
          
		if(mysqli_affected_rows($conexion)>0){

  		$QueryE="SELECT * FROM evidencias WHERE id=".$id;
		mysqli_query($conexion,$QueryE);

		if(mysqli_affected_rows($conexion)>0){ //EXISTE UNA FILA CON DICHO VALOR
			$QueryEvidencia = "DELETE FROM evidencias WHERE id=".$id;
			mysqli_query($conexion,$QueryEvidencia);
			$Respuesta["estado"]	=1;
			$Respuesta["mensaje"]	="Se elimino correctamente los dos datos";
		}else{ //NO EXISTE NINGUNA FILA CON ESE ID
			$Respuesta['estado']=1;
			$Respuesta['mensaje']="Solo se elimino el alta de eventos";
		}

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
	
	$nombre        = $_POST['nombre'];
	$observaciones = $_POST['observaciones'];
	$fecha_inicio  = $_POST['fecha_inicio'];
	$fecha_final   = $_POST['fecha_final'];
	$tipo_evento   = $_POST['clase_evento'];
	$clase_publico = $_POST['tipo_evento'];
	$Id			   = $_POST['id'];

	$Query ="UPDATE alta_evento SET nombre='".$nombre."', observaciones='".$observaciones."', fecha_inicio='".$fecha_inicio."', fecha_final='".$fecha_final."', tipo_evento='".$tipo_evento."', clase_publico='".$clase_publico."' WHERE id=".$Id;

	mysqli_query($conexion,$Query);

	if(mysqli_affected_rows($conexion)>0){
		$Respuesta['estado']=1;
		$Respuesta['mensaje']="Datos actualizados correctamente";	
	}else{
		$Respuesta['estado']=0;
		$Respuesta['mensaje']="Ocurrrio un error DESCONOCIDO AQUI";
	}

	
	echo json_encode($Respuesta);
}
function ActionObtenerDatosPHP($conexion){
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

			/*$Tipo_Evento = array();*/
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
function ActionIdentificarIdPHP($conexion){
	$Id= $_POST['id'];

	$Query="SELECT * FROM evidencias WHERE id=".$Id;
	
	mysqli_query($conexion,$Query);

	if(mysqli_affected_rows($conexion)>0){ //EXISTE UNA FILA CON DICHO VALOR
		$Respuesta['estado']=1;
		$Respuesta['mensaje']="Ya hay datos conocidos";	
	}else{ //NO EXISTE NINGUNA FILA CON ESE ID
		$Respuesta['estado']=0;
		$Respuesta['mensaje']="No se ha registrado nada";
	}	
	echo json_encode($Respuesta);
}
function ActionCrearEvidenciaPHP($conexion){
	$Respuesta=array();

	if(isset($_POST['id'])&&isset($_POST['hombres'])&&isset($_POST['mujeres'])&&isset($_POST['expositores'])&&isset($_POST['porme'])&&isset($_POST['imagen1']))
	{

		$id = $_POST['id'];
		$hombres = $_POST['hombres'];
		$mujeres = $_POST['mujeres'];
		$expositores = $_POST['expositores'];
		$porme = $_POST['porme'];
		$imagen1 = $_POST['imagen1'];
		

		if(isset($_POST['imagen2']))
		{
			$imagen2=$_POST['imagen2'];
			
		}
		else
		{
			$imagen2="sinImagen.png";
		}
 //////////////////
	
    $QueryId="SELECT * FROM evidencias WHERE id=".$id;
	
	mysqli_query($conexion,$QueryId);

	if(mysqli_affected_rows($conexion)>0){ //EXISTE UNA FILA CON DICHO VALOR
		
		/**/
		$Query ="UPDATE evidencias SET id='".$id."', cant_hombres='".$hombres."', cant_mujeres='".$mujeres."', expositor='".$expositores."', pormenor='".$porme."', evid_1='".$imagen1."' , evid_2='".$imagen2."' WHERE id=".$id;
		mysqli_query($conexion,$Query);

		if(mysqli_affected_rows($conexion)>0){
		$Respuesta['estado']=1;
		$Respuesta['mensaje']="Datos actualizados correctamente";	
		}else{
		$Respuesta['estado']=0;
		$Respuesta['mensaje']="Ocurrrio un error desconocido AQUI";
		}
		
		/* */
	}else{ //NO EXISTE NINGUNA FILA CON ESE ID
		$Query = "INSERT INTO evidencias(id,cant_hombres, cant_mujeres, expositor, pormenor, evid_1, evid_2) VALUES('$id','$hombres','$mujeres','$expositores','$porme','$imagen1', '$imagen2')";

		mysqli_query($conexion,$Query);


		if(mysqli_affected_rows($conexion)>0){
			
			$Respuesta['estado']	=1;
			$Respuesta['mensaje']	="El evento se guardo correctamente";
			
		}else{
			$Respuesta['estado']=0;
			$Respuesta['mensaje']="Ocurrio un error desconocido";
		}

	}	


 ///////////////////
		

	}
	else{
		$Respuesta['estado']=0;
		$Respuesta['mensaje']="Faltan parametros";
	}

	echo json_encode($Respuesta);
}
function ActionObtenerEvidenciasPHP($conexion){
	if(isset($_POST['id']))
	{
		$id = $_POST['id'];
		$Query ="SELECT * FROM evidencias WHERE id=".$id;
		mysqli_query($conexion,$Query);
		

		///
		$Resultado 	= mysqli_query($conexion,$Query);
		$Renglon = mysqli_fetch_array($Resultado);
		///

		if(mysqli_affected_rows($conexion)>0){

			/*$Tipo_Evento = array();*/
			$Respuesta["cant_hombres"]= $Renglon["cant_hombres"];
			$Respuesta["cant_mujeres"]= $Renglon["cant_mujeres"];
			$Respuesta["expositor"]	  = $Renglon["expositor"];
			$Respuesta["pormenor"]	  = $Renglon["pormenor"];
			$Respuesta["evid_1"]	  = "../dist/img/".$Renglon["evid_1"];
			$Respuesta["evid_2"]	  = "../dist/img/".$Renglon["evid_2"];
			$Respuesta["estado"]  	  =1;
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