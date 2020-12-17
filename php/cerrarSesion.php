<?php


    SESSION_START();

    SESSION_UNSET();

    SESSION_DESTROY();

   /*

  session_start();
  unset($_SESSION["id"]); 
  unset($_SESSION["email"]);
  session_destroy();
  header("Location: ../index.php");
  exit;*/

  /*
        unset($_SESSION["id"]);
		unset($_SESSION["email"]);

		session_unset();
		session_destroy();

		$Respuesta = array();
		$Respuesta['id'] = $_SESSION["id"];
		$Respuesta['email'] =  $_SESSION["email"];
		echo json_encode($Respuesta);
  */

?>