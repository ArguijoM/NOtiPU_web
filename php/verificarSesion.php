<?php
              
        SESSION_START();
        $_SESSION["timeout"]=time();
        include "conexion.php";
        $Respuesta = array();

        if(isset($_SESSION['id'],$_SESSION['email']))
        {
            $IDU=$_SESSION['id'];
            $EMAILU=$_SESSION['email'];

            $Query = "SELECT * FROM usuario WHERE id_usuario='".$IDU."' AND email='".$EMAILU."'";
            
            mysqli_query($conexion,$Query);

            if(mysqli_affected_rows($conexion)>0){

                $Respuesta['estado'] = 1;
                $Respuesta['mensaje'] = "Acceso correcto PASE USTED";

            }
            else
            {
                $Respuesta['estado'] = 0;
                $Respuesta['mensaje'] = "INICIE SESION, PRIMERO";
            }

        }
        else{
            $Respuesta['estado'] = 0;
            $Respuesta['mensaje'] = "No hay variables definidas favor de identificarse";
        }
        
		
        echo json_encode($Respuesta);
	
?>