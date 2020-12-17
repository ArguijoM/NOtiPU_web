<?php

    $Respuesta=array();
    include "conexion.php";

    $Query 		="SELECT * FROM alta_evento";	
	$Resultado 	= mysqli_query($conexion,$Query);

	$Query_F="SELECT DATE_FORMAT(fecha_inicio, '%Y-%m-%dT%T'), DATE_FORMAT(fecha_final, '%Y-%m-%dT%T') FROM alta_evento";
    $Resultado2 	= mysqli_query($conexion,$Query_F);// or die (mysl_error());
    
    $var='[';
    $var2="";

	while($Renglon = mysqli_fetch_array($Resultado)){

		$Respuesta["id"]		 = $Renglon["id"];
		$Respuesta["title"]		 = $Renglon["nombre"];

		$Renglon2 = mysqli_fetch_array($Resultado2);
		
		$Respuesta["start"] = $Renglon2["DATE_FORMAT(fecha_inicio, '%Y-%m-%dT%T')"];
        $Respuesta["end"]  = $Renglon2["DATE_FORMAT(fecha_final, '%Y-%m-%dT%T')"];
        
        //$var2 .='{"id":"'.$Respuesta["id"].'","title":"'.$Respuesta["title"].'","start":"'.$Respuesta["start"].'","end":"'.$Respuesta["end"].'"},';
        $color=color_rand();
        $var2 .='{"id":"'.$Respuesta["id"].'","title":"'.$Respuesta["title"].'","start":"'.$Respuesta["start"].'","end":"'.$Respuesta["end"].'", "backgroundColor":"'.$color.'","borderColor": "#000000"},';        
		
    }
    $var=$var.$var2.'{}]';
    

   
   function color_rand() {
        return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
    }

    echo $var
    

    
    
//echo '[{"id":"50","title":"Hola buenos dias","start":"2020-06-13","end":"2020-06-13", "backgroundColor":"'.$color.'"}]'
/*ESTE YA FUNCIONA PERO CON UN ID DEFINIDO
$Respuesta=array();
include "conexion.php";


$Query 		="SELECT * FROM alta_evento where id=61";	
$Resultado 	= mysqli_query($conexion,$Query);
$Renglon = mysqli_fetch_array($Resultado);
$Respuesta["id"]		 = $Renglon["id"];
$Respuesta["title"]		 = $Renglon["nombre"];

$Query_F 		="SELECT DATE_FORMAT(fecha_inicio, '%Y-%m-%dT%T'), DATE_FORMAT(fecha_final, '%Y-%m-%dT%T') FROM alta_evento where id=61";
$Resultado2 	= mysqli_query($conexion,$Query_F);// or die (mysl_error());
$Renglon2 = mysqli_fetch_array($Resultado2);
$Respuesta["start"] = $Renglon2["DATE_FORMAT(fecha_inicio, '%Y-%m-%dT%T')"];
$Respuesta["end"]  = $Renglon2["DATE_FORMAT(fecha_final, '%Y-%m-%dT%T')"];




echo '[{"id":"'.$Respuesta["id"].'","title":"'.$Respuesta["title"].'","start":"'.$Respuesta["start"].'","end":"'.$Respuesta["end"].'"}]' 
*/


/*EJEMPLOS DE INSERCCION

[{"id":"50","title":"Hola buenos dias","start":"2020-06-13","end":"2020-06-13"},
{"id":"51","title":"Hola otra vez","start":"2020-06-01","end":"2020-06-03"},
{"id":"52","title":"","start":"2020-06-08","end":"2020-06-09"},
{"id":"48","title":"Semana de Programaci\u00f3n y Videojuegos","start":"2020-10-12","end":"2020-10-16"},
{"id":"49","title":"Hola mundo","start":"2020-06-09","end":"2020-06-13"},
{"id":"46","title":"Dia del estudiante","start":"2020-06-08","end":"2020-06-10"},
{"id":"47","title":"Dia del padre","start":"2020-06-10","end":"2020-06-13"}]

[{"id":"50","title":"Hola buenos dias","start":"2020-06-13","end":"2020-06-13"}]


*/

?>



