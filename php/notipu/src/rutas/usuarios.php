<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, DELETE, PUT, GET, OPTIONS');

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

// GET Todos los usuarios 
$app->get('/api/usuarios', function(Request $request, Response $response){
  $Respuesta['usuarios']=array();
  $sql = "SELECT * FROM usuario";
  try{
    $db = new db();
    $db = $db->conectDB();
    $resultado = $db->query($sql);

    if ($resultado->rowCount() > 0){
      $Respuesta['usuarios'] = $resultado->fetchAll(PDO::FETCH_OBJ);
      $Respuesta['estado']=1;
      $Respuesta['mensaje']='La consulta se realizó exitosamente';
    }else {
      $Respuesta['estado']=0;
      $Respuesta['mensaje']='No existen usuarios';
    }
    echo json_encode($Respuesta);
    $resultado = null;
    $db = null;
  }catch(PDOException $e){
    echo '{"error" : {"text":'.$e->getMessage().'}';
  }
});

// GET Recueperar Usuarios por ID 
$app->get('/api/usuarios/{id}', function(Request $request, Response $response){
  $Respuesta['usuarios']=array();
  $id_usuario = $request->getAttribute('id');
  $sql = "SELECT * FROM usuario WHERE idUsuario = $id_usuario";
  try{
    $db = new db();
    $db = $db->conectDB();
    $resultado = $db->query($sql);

    if ($resultado->rowCount() > 0){
      $Respuesta['usuarios'] = $resultado->fetchAll(PDO::FETCH_OBJ);
      $Respuesta['estado']=1;
      $Respuesta['mensaje']='La consulta se realizó exitosamente';
    }else {
      $Respuesta['estado']=0;
      $Respuesta['mensaje']='No existe el usuario';
    }
    echo json_encode($Respuesta);
    $resultado = null;
    $db = null;
  }catch(PDOException $e){
    echo '{"error" : {"text":'.$e->getMessage().'}';
  }
}); 

// GET Recueperar Usuarios por nombre
$app->get('/api/usuariosN/{id}', function(Request $request, Response $response){
  $Respuesta['usuarios']=array();
  $id_usuario = $request->getAttribute('id');
  $sql = "SELECT * FROM usuario WHERE nombre = $id_usuario";
  try{
    $db = new db();
    $db = $db->conectDB();
    $resultado = $db->query($sql);

    if ($resultado->rowCount() > 0){
      $Respuesta['usuarios'] = $resultado->fetchAll(PDO::FETCH_OBJ);
      $Respuesta['estado']=1;
      $Respuesta['mensaje']='La consulta se realizó exitosamente';
    }else {
      $Respuesta['estado']=0;
      $Respuesta['mensaje']='No existe el usuario';
    }
    echo json_encode($Respuesta);
    $resultado = null;
    $db = null;
  }catch(PDOException $e){
    echo '{"error" : {"text":'.$e->getMessage().'}';
  }
}); 


// POST Crear nuevo Usuario 
$app->post('/api/usuarios/nuevo', function(Request $request, Response $response){
   $nombrecompleto = $request->getParam('nombrecompleto');
   $token = $request->getParam('token');
   $tipo = $request->getParam('tipo');
   $Programa_idPrograma = $request->getParam('Programa_idPrograma');
  
  $sql = "INSERT INTO usuario (nombrecompleto, token, tipo, Programa_idPrograma) VALUES 
          (:nombrecompleto, :token, :tipo, :Programa_idPrograma)";
  try{
    $db = new db();
    $db = $db->conectDB();
    $resultado = $db->prepare($sql);

    $resultado->bindParam(':nombrecompleto', $nombrecompleto);
    $resultado->bindParam(':token', $token);
    $resultado->bindParam(':tipo', $tipo);
    $resultado->bindParam(':Programa_idPrograma', $Programa_idPrograma);

    $resultado->execute();
    echo json_encode("Nuevo usuario guardado.");  

    $resultado = null;
    $db = null;
  }catch(PDOException $e){
    echo '{"error" : {"text":'.$e->getMessage().'}';
  }
}); 



// PUT Modificar usuario
$app->put('/api/usuarios/modificar/{id}', function(Request $request, Response $response){
   $idUsuario = $request->getAttribute('id');
   $boleta = $request->getParam('boleta');
   $nombrecompleto = $request->getParam('nombrecompleto');
   $token = $request->getParam('token');
   $tipo = $request->getParam('tipo');
   $Programa_idPrograma = $request->getParam('Programa_idPrograma');
  
  $sql = "UPDATE usuario SET
          boleta = :boleta, 
          nombrecompleto = :nombrecompleto,
          token = :token,
          tipo = :tipo,
          Programa_idPrograma = :Programa_idPrograma
        WHERE idUsuario = $idUsuario";
     
  try{
    $db = new db();
    $db = $db->conectDB();
    $resultado = $db->prepare($sql);

    $resultado->bindParam(':boleta', $boleta);
    $resultado->bindParam(':nombrecompleto', $nombrecompleto);
    $resultado->bindParam(':token', $token);
    $resultado->bindParam(':tipo', $tipo);
    $resultado->bindParam(':Programa_idPrograma', $Programa_idPrograma);

    $resultado->execute();
    echo json_encode("Usuario modificado.");  

    $resultado = null;
    $db = null;
  }catch(PDOException $e){
    echo '{"error" : {"text":'.$e->getMessage().'}';
  }
}); 


// DELETE borar cliente 
$app->delete('/api/usuarios/delete/{id}', function(Request $request, Response $response){
   $id_usuario = $request->getAttribute('id');
   $sql = "DELETE FROM usuario WHERE idUsuario = $id_usuario";
     
  try{
    $db = new db();
    $db = $db->conectDB();
    $resultado = $db->prepare($sql);
     $resultado->execute();

    if ($resultado->rowCount() > 0) {
      echo json_encode("Usuario eliminado.");  
    }else {
      echo json_encode("No existe Usuario con este ID.");
    }

    $resultado = null;
    $db = null;
  }catch(PDOException $e){
    echo '{"error" : {"text":'.$e->getMessage().'}';
  }
}); 


///////////////////////////NOTIFICACIONES///////////////////////////////////////////

// GET Todos los notificaciones
$app->get('/api/notificaciones', function(Request $request, Response $response){
  $Respuesta['notificaciones']=array();
  $sql = "SELECT * FROM notificacion";
  try{
    $db = new db();
    $db = $db->conectDB();
    $resultado = $db->query($sql);

    if ($resultado->rowCount() > 0){
      $Respuesta['notificaciones'] = $resultado->fetchAll(PDO::FETCH_OBJ);
      $Respuesta['estado']=1;
      $Respuesta['mensaje']='La consulta se realizó exitosamente';
     
    }else {
      $Respuesta['estado']=0;
      $Respuesta['mensaje']='No hay notificaciónes';
    }
    echo json_encode($Respuesta);
    $resultado = null;
    $db = null;
  }catch(PDOException $e){
    echo '{"error" : {"text":'.$e->getMessage().'}';
  }
}); 

$app->get('/api/notificaciones/{id}', function(Request $request, Response $response){
  $Respuesta['notificacion']=array();
  $id_notificacion = $request->getAttribute('id');
  $sql = "SELECT * FROM notificacion WHERE idNotificacion = $id_notificacion";
  try{
    $db = new db();
    $db = $db->conectDB();
    $resultado = $db->query($sql);

    if ($resultado->rowCount() > 0){
      $Respuesta['notificacion'] = $resultado->fetchAll(PDO::FETCH_OBJ);
      $Respuesta['estado']=1;
      $Respuesta['mensaje']='La consulta se realizó exitosamente';
    }else {
      $Respuesta['estado']=0;
      $Respuesta['mensaje']='No existe el usuario';
    }
    echo json_encode($Respuesta);
    $resultado = null;
    $db = null;
  }catch(PDOException $e){
    echo '{"error" : {"text":'.$e->getMessage().'}';
  }
}); 

// POST Crear nueva Notificación 
$app->post('/api/notificaciones/nuevo', function(Request $request, Response $response){
  $titulo = $request->getParam('titulo');
  $descripcion = $request->getParam('descripcion');
  $fecha = $request->getParam('fecha');
  $Grupo_idGrupo = $request->getParam('Grupo_idGrupo');
 
 $sql = "INSERT INTO notificacion (titulo, descripcion, fecha, Grupo_idGrupo) VALUES 
         (:titulo, :descripcion, :fecha, :Grupo_idGrupo)";
 try{
   $db = new db();
   $db = $db->conectDB();
   $resultado = $db->prepare($sql);

   $resultado->bindParam(':titulo', $titulo);
   $resultado->bindParam(':descripcion', $descripcion);
   $resultado->bindParam(':fecha', $fecha);
   $resultado->bindParam(':Grupo_idGrupo', $Grupo_idGrupo);

   $resultado->execute();
   echo json_encode("Nueva notificacion guardada.");  

   $resultado = null;
   $db = null;
 }catch(PDOException $e){
   echo '{"error" : {"text":'.$e->getMessage().'}';
 }
}); 

// DELETE borar Notificación 
$app->delete('/api/notificaciones/delete/{id}', function(Request $request, Response $response){
  $id_notificacion = $request->getAttribute('id');
  $sql = "DELETE FROM notificacion WHERE idNotificacion = $id_notificacion";
    
 try{
   $db = new db();
   $db = $db->conectDB();
   $resultado = $db->prepare($sql);
    $resultado->execute();

   if ($resultado->rowCount() > 0) {
     echo json_encode("Notificacion eliminado.");  
   }else {
     echo json_encode("No existe esa notificacion.");
   }

   $resultado = null;
   $db = null;
 }catch(PDOException $e){
   echo '{"error" : {"text":'.$e->getMessage().'}';
 }
}); 




///////////////////////////GRUPOS///////////////////////////////////////////

// GET Todos los grupos
$app->get('/api/grupos', function(Request $request, Response $response){
  $Respuesta['grupos']=array();
  $sql = "SELECT * FROM grupo";
  try{
    $db = new db();
    $db = $db->conectDB();
    $resultado = $db->query($sql);

    if ($resultado->rowCount() > 0){
      $Respuesta['grupos'] = $resultado->fetchAll(PDO::FETCH_OBJ);
      $Respuesta['estado']=1;
      $Respuesta['mensaje']='La consulta se realizó exitosamente';
     
    }else {
      $Respuesta['estado']=0;
      $Respuesta['mensaje']='No hay grupos';
    }
    echo json_encode($Respuesta);
    $resultado = null;
    $db = null;
  }catch(PDOException $e){
    echo '{"error" : {"text":'.$e->getMessage().'}';
  }
}); 

//GET grupo por ID
$app->get('/api/grupos/{id}', function(Request $request, Response $response){
  $Respuesta['grupos']=array();
  $id_grupo = $request->getAttribute('id');
  $sql = "SELECT * FROM grupo WHERE idGrupo = $id_grupo";
  try{
    $db = new db();
    $db = $db->conectDB();
    $resultado = $db->query($sql);

    if ($resultado->rowCount() > 0){
      $Respuesta['grupos'] = $resultado->fetchAll(PDO::FETCH_OBJ);
      $Respuesta['estado']=1;
      $Respuesta['mensaje']='La consulta se realizó exitosamente';
    }else {
      $Respuesta['estado']=0;
      $Respuesta['mensaje']='No existe el grupo';
    }
    echo json_encode($Respuesta);
    $resultado = null;
    $db = null;
  }catch(PDOException $e){
    echo '{"error" : {"text":'.$e->getMessage().'}';
  }
}); 

//GET grupo por nombre del grupo
$app->get('/api/gruposN/{id}', function(Request $request, Response $response){
  $Respuesta['grupos']=array();
  $nombre_grupo = $request->getAttribute('id');
  $sql = "SELECT * FROM grupo WHERE nombre ='$nombre_grupo'";
  try{
    $db = new db();
    $db = $db->conectDB();
    $resultado = $db->query($sql);

    if ($resultado->rowCount() > 0){
      $Respuesta['grupos'] = $resultado->fetchAll(PDO::FETCH_OBJ);
      $Respuesta['estado']=1;
      $Respuesta['mensaje']='La consulta se realizó exitosamente';
    }else {
      $Respuesta['estado']=0;
      $Respuesta['mensaje']='No existe el grupo';
    }
    echo json_encode($Respuesta);
    $resultado = null;
    $db = null;
  }catch(PDOException $e){
    echo '{"error" : {"text":'.$e->getMessage().'}';
  }
}); 

// POST Crear nuevo grupo 
$app->post('/api/grupos/nuevo', function(Request $request, Response $response){
  $nombre = $request->getParam('nombre');
  $descripcion = $request->getParam('descripcion');
 
 $sql = "INSERT INTO grupo (nombre, descripcion) VALUES 
         (:nombre, :descripcion)";
 try{
   $db = new db();
   $db = $db->conectDB();
   $resultado = $db->prepare($sql);

   $resultado->bindParam(':nombre', $nombre);
   $resultado->bindParam(':descripcion', $descripcion);

   $resultado->execute();
   echo json_encode("Nuevo grupo guardado.");  

   $resultado = null;
   $db = null;
 }catch(PDOException $e){
   echo '{"error" : {"text":'.$e->getMessage().'}';
 }
});

// PUT Modificar grupo
$app->put('/api/grupos/modificar/{id}', function(Request $request, Response $response){
  $idGrupo = $request->getAttribute('id');
  $nombre = $request->getParam('nombre');
  $descripcion = $request->getParam('descripcion');
 
 $sql = "UPDATE grupo SET
         nombre = :nombre, 
         descripcion = :descripcion
       WHERE idGrupo = $idGrupo";
    
 try{
   $db = new db();
   $db = $db->conectDB();
   $resultado = $db->prepare($sql);

   $resultado->bindParam(':nombre', $nombre);
   $resultado->bindParam(':descripcion', $descripcion);

   $resultado->execute();
   echo json_encode("Grupo modificado.");  

   $resultado = null;
   $db = null;
 }catch(PDOException $e){
   echo '{"error" : {"text":'.$e->getMessage().'}';
 }
}); 

// DELETE borar Grupo
$app->delete('/api/grupos/delete/{id}', function(Request $request, Response $response){
  $id_grupo = $request->getAttribute('id');
  $sql = "DELETE FROM grupo WHERE idGrupo = $id_grupo";
    
 try{
   $db = new db();
   $db = $db->conectDB();
   $resultado = $db->prepare($sql);
    $resultado->execute();

   if ($resultado->rowCount() > 0) {
     echo json_encode("Grupo eliminado.");  
   }else {
     echo json_encode("No existe ese Grupo.");
   }

   $resultado = null;
   $db = null;
 }catch(PDOException $e){
   echo '{"error" : {"text":'.$e->getMessage().'}';
 }
}); 



//////////////////AGRUPAMIENTO//////////////////////////////////
// GET Todos los agrupamientos
$app->get('/api/agrupamientos', function(Request $request, Response $response){
  $Respuesta['agrupamientos']=array();
  $sql = "SELECT * FROM agrupamiento";
  try{
    $db = new db();
    $db = $db->conectDB();
    $resultado = $db->query($sql);

    if ($resultado->rowCount() > 0){
      $Respuesta['agrupamientos'] = $resultado->fetchAll(PDO::FETCH_OBJ);
      $Respuesta['estado']=1;
      $Respuesta['mensaje']='La consulta se realizó exitosamente';
    }else {
      $Respuesta['estado']=0;
      $Respuesta['mensaje']='No existen agrupamientos';
    }
    echo json_encode($Respuesta);
    $resultado = null;
    $db = null;
  }catch(PDOException $e){
    echo '{"error" : {"text":'.$e->getMessage().'}';
  }
}); 

// GET agrupamiento por ID 
$app->get('/api/agrupamientos/{id}', function(Request $request, Response $response){
  $Respuesta['agrupamiento']=array();
  $id_agrupamiento = $request->getAttribute('id');
  $sql = "SELECT * FROM agrupamiento WHERE idAgrupamiento = $id_agrupamiento";
  try{
    $db = new db();
    $db = $db->conectDB();
    $resultado = $db->query($sql);

    if ($resultado->rowCount() > 0){
      $Respuesta['agrupamiento'] = $resultado->fetchAll(PDO::FETCH_OBJ);
      $Respuesta['estado']=1;
      $Respuesta['mensaje']='La consulta se realizó exitosamente';
    }else {
      $Respuesta['estado']=0;
      $Respuesta['mensaje']='No existe el agrupamiento';
    }
    echo json_encode($Respuesta);
    $resultado = null;
    $db = null;
  }catch(PDOException $e){
    echo '{"error" : {"text":'.$e->getMessage().'}';
  }
}); 

// GET agrupamiento por ID de Grupo 
$app->get('/api/agrupamientosGrupo/{id}', function(Request $request, Response $response){
  $Respuesta['agrupamiento']=array();
  $id_agrupamiento = $request->getAttribute('id');
  $sql = "SELECT * FROM agrupamiento WHERE Grupo_idGrupo = $id_agrupamiento";
  try{
    $db = new db();
    $db = $db->conectDB();
    $resultado = $db->query($sql);

    if ($resultado->rowCount() > 0){
      $Respuesta['agrupamiento'] = $resultado->fetchAll(PDO::FETCH_OBJ);
      $Respuesta['estado']=1;
      $Respuesta['mensaje']='La consulta se realizó exitosamente';
    }else {
      $Respuesta['estado']=0;
      $Respuesta['mensaje']='No existe el agrupamiento';
    }
    echo json_encode($Respuesta);
    $resultado = null;
    $db = null;
  }catch(PDOException $e){
    echo '{"error" : {"text":'.$e->getMessage().'}';
  }
}); 

// POST Crear nuevo agrupamiento 
$app->post('/api/agrupamientos/nuevo', function(Request $request, Response $response){
  $Usuario_idUsuario = $request->getParam('Usuario_idUsuario');
  $Grupo_idGrupo = $request->getParam('Grupo_idGrupo');
 
 $sql = "INSERT INTO agrupamiento (Usuario_idUsuario, Grupo_idGrupo) VALUES 
         (:Usuario_idUsuario , :Grupo_idGrupo)";
 try{
   $db = new db();
   $db = $db->conectDB();
   $resultado = $db->prepare($sql);

   $resultado->bindParam(':Usuario_idUsuario', $Usuario_idUsuario);
   $resultado->bindParam(':Grupo_idGrupo', $Grupo_idGrupo);

   $resultado->execute();
   echo json_encode("Nuevo grupo guardado.");  

   $resultado = null;
   $db = null;
 }catch(PDOException $e){
   echo '{"error" : {"text":'.$e->getMessage().'}';
 }
});

// DELETE borar Grupo
$app->delete('/api/agrupamientos/delete/{id}', function(Request $request, Response $response){
  $id_agrupamiento = $request->getAttribute('id');
  $sql = "DELETE FROM agrupamiento WHERE Usuario_idUsuario = $id_agrupamiento";
    
 try{
   $db = new db();
   $db = $db->conectDB();
   $resultado = $db->prepare($sql);
    $resultado->execute();

   if ($resultado->rowCount() > 0) {
     echo json_encode("Agrupamiento eliminado.");  
   }else {
     echo json_encode("No existe ese Agrupamiento.");
   }

   $resultado = null;
   $db = null;
 }catch(PDOException $e){
   echo '{"error" : {"text":'.$e->getMessage().'}';
 }
}); 





