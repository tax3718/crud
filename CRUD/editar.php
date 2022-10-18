<?php

// Necesitamos obtener los datos del usuario que estamos editando desde la base de datos y mostrar un formulario de edición

include 'funciones.php';

$config = include 'config.php';

$resultado = [
  'error' => false,
  'mensaje' => ''
];

// Código para obtener el alumno que queremos editar.

if (!isset($_GET['id'])) {
  $resultado['error'] = true;
  $resultado['mensaje'] = 'El alumno no existe';
}
/*
Debemos detectar si el parámetro $_POST['submit'] está presente. 
Si es así, nos conectamos a la base de datos y actualizamos el alumno con los nuevos datos.
*/
if (isset($_POST['submit'])) {
  try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    $alumno = [
      "id"        => $_GET['id'],
      "nombre"    => $_POST['nombre'],
      "apellido"  => $_POST['apellido'],
      "email"     => $_POST['email'],
      "edad"      => $_POST['edad']
    ];
// Usaremos una sentencia SQL UPDATE para actualizar los valores del alumno cuyo id se corresponde con el que estamos editando.
    $consultaSQL = "UPDATE alumnos SET
        nombre = :nombre,
        apellido = :apellido,
        email = :email,
        edad = :edad,
        updated_at = NOW() 
        WHERE id = :id";
// también actualizamos el campo updated_at con la fecha actual, que obtenemos mediante la función NOW() de MySQL.
    $consulta = $conexion->prepare($consultaSQL);
    $consulta->execute($alumno);

  } catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
  }
}

try {
  $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
  $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
    
  $id = $_GET['id'];
  $consultaSQL = "SELECT * FROM alumnos WHERE id =" . $id;

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $alumno = $sentencia->fetch(PDO::FETCH_ASSOC);

  if (!$alumno) {
    $resultado['error'] = true;
    $resultado['mensaje'] = 'No se ha encontrado el alumno';
  }

} catch(PDOException $error) {
  $resultado['error'] = true;
  $resultado['mensaje'] = $error->getMessage();
}
?>

<?php require "templates/header.php"; ?>

<?php
// Mostramos algún error en caso de que haya ocurrido alguno.
if ($resultado['error']) {
  ?>
  <div class="container mt-2">
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-danger" role="alert">
          <?= $resultado['mensaje'] ?>
        </div>
      </div>
    </div>
  </div>
  <?php
}
?>

<?php
// Mostramos también un mensaje de confirmación siempre y cuando no haya habido errores.
if (isset($_POST['submit']) && !$resultado['error']) {
  ?>
  <div class="container mt-2">
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-success" role="alert">
          El alumno ha sido actualizado correctamente
        </div>
      </div>
    </div>
  </div>
  <?php
}
?>

<?php
/*
Formulario con los datos actuales del alumno que hemos obtenido desde la base de datos, que están en el array $alumno.
Este formulario es casi idéntico al que hemos agregado en el archivo crear.php, con la salvedad de que en este caso los campos tendrán un valor.
*/
if (isset($alumno) && $alumno) {
  ?>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h2 class="mt-4">Editando el alumno <?= escapar($alumno['nombre']) . ' ' . escapar($alumno['apellido'])  ?></h2>
        <hr>
        <form method="post">
          <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" value="<?= escapar($alumno['nombre']) ?>" class="form-control">
          </div>
          <div class="form-group">
            <label for="apellido">Apellido</label>
            <input type="text" name="apellido" id="apellido" value="<?= escapar($alumno['apellido']) ?>" class="form-control">
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?= escapar($alumno['email']) ?>" class="form-control">
          </div>
          <div class="form-group">
            <label for="edad">Edad</label>
            <input type="text" name="edad" id="edad" value="<?= escapar($alumno['edad']) ?>" class="form-control">
          </div>
          <div class="form-group">
            <input type="submit" name="submit" class="btn btn-primary" value="Actualizar">
            <a class="btn btn-primary" href="index.php">Regresar al inicio</a>
          </div>
        </form>
      </div>
    </div>
  </div>
  <?php
}
/*
Solamente mostramos el formulario en caso de que se haya obtenido un alumno. 
Hemos usado el atributo value de los campos input HTML para definir el valor que tendrá cada campo.
*/
?>
<?php require "templates/footer.php"; ?>