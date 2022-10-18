<!-- Se inclute el array creado en el archivo config.php y asigna una nueva instancia de la clase PDO a una variable, 
a la que llamaremos $conexion. 
<?php

    $config = include 'config.php';
    try {
        $conexion = new PDO('mysql:host=' . $config['db']['host'], $config['db']['user'], $config['db']['pass'], $config['db']['options']); // Se crea la conexión
        $sql = file_get_contents("data/migracion.sql"); // Asignamos nuestra consulta SQL a una variable usando el método file_get_contents.
    
        $conexion->exec($sql); // Usaremos el método exec para ejecutar la consulta.
        echo "La base de datos y la tabla de alumnos se han creado con éxito.";
        } catch(PDOException $error) {
            echo $error->getMessage();
        }

?>