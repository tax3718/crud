<?php

include 'funciones.php';

if (isset($_POST['submit'])) {
  $resultado = [
    'error' => false,
    'mensaje' => 'El alumno ' . escapar($_POST['nombre']) . ' ha sido agregado con éxito' // Función escapar creada en el archivo funciones.
  ];
  
  $config = include 'config.php';

/*
El array $resultado almacenará algún posible error, de haberlo. 
Luego hemos incluido el array de configuración del archivo config.php y nos hemos conectado a la base de datos. 
Esta vez hemos definido el nombre de la base de datos a la que nos conectamos.
*/

  try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
  
// Código encargado de crear un nuevo usuario en la base de datos. Array con los datos del nuevo alumno, que obtendremos del array $_POST
    $alumno = array(
        "nombre"   => $_POST['nombre'],
        "apellido" => $_POST['apellido'],
        "email"    => $_POST['email'],
        "edad"     => $_POST['edad'],
      );
      
      $consultaSQL = "INSERT INTO alumnos (nombre, apellido, email, edad)"; // Con la sentencia INSERT para dar entrada a los datos en la tabla.
      $consultaSQL .= "values (:" . implode(", :", array_keys($alumno)) . ")"; // implode — Une elementos de un array en un string.
// A continuación vamos a usar el método prepare y a ejecutar la consulta:  
      $sentencia = $conexion->prepare($consultaSQL);
      $sentencia->execute($alumno);

  } catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
  }

/*
Hemos usado un bloque try/catch, en cuyo interior insertamos el usuario. 
De haber algún error, se ejecutará el bloque catch, en donde almacenamos el error en el array resultado.
*/

}

?>

<?php include "templates/header.php"; ?>

<?php
if (isset($resultado)) {
  ?>
  <div class="container mt-3">
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-<?= $resultado['error'] ? 'danger' : 'success' ?>" role="alert">
          <?= $resultado['mensaje'] ?>
        </div>
      </div>
    </div>
  </div>
  <?php
}
?>
<!-- Creamos formulario HTML para la creación de alumnos 
Hemos agregado el atributo name a cada campo <input> del formulario. 
El valor del atributo name será el nombre que tendrá cada campo cuando se envíe el formulario.
Hemos agregado también una etiqueta <label> para cada campo, que se relacionará con su correspondiente campo gracias al atributo for. 
El valor del atributo for es el mismo que el del atributo id del campo con el que se relaciona.-->
<div class="container"> 
  <div class="row">
    <div class="col-md-12">
      <h2 class="mt-4">Crea un alumno</h2>
      <hr>
      <form method="post">
        <div class="form-group">
          <label for="nombre">Nombre</label>
          <input type="text" name="nombre" id="nombre" class="form-control">
        </div>
        <div class="form-group">
          <label for="apellido">Apellido</label>
          <input type="text" name="apellido" id="apellido" class="form-control">
        </div>
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" name="email" id="email" class="form-control">
        </div>
        <div class="form-group">
          <label for="edad">Edad</label>
          <input type="text" name="edad" id="edad" class="form-control">
        </div>
        <div class="form-group">
          <input type="submit" name="submit" class="btn btn-primary" value="Enviar">
          <a class="btn btn-primary" href="index.php">Regresar al inicio</a>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include "templates/footer.php"; ?>